<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function getSalesRange(Request $request)
{ 
     $start = $request->query('start');
    $end   = $request->query('end');

    if (!$start || !$end) {
        $start = now()->startOfMonth()->toDateString();
        $end   = now()->endOfMonth()->toDateString();
    }

    // Doanh thu theo ngày
    $daily = DB::table('order')
        ->join('order_details', 'order.id', '=', 'order_details.order_id')
        ->select(
            DB::raw("DATE(order.order_date) as label"),
            DB::raw('SUM(order_details.quantity * order_details.price) as total')
        )
        ->where('order.status', 2)
        ->whereBetween('order.order_date', [$start, $end])
        ->groupBy('label')
        ->orderBy('label')
        ->get();

    // Doanh thu theo tháng
    $monthly = DB::table('order')
        ->join('order_details', 'order.id', '=', 'order_details.order_id')
        ->select(
            DB::raw("DATE_FORMAT(order.order_date, '%m-%Y') as label"),
            DB::raw('SUM(order_details.quantity * order_details.price) as total')
        )
        ->where('order.status', 2)
        ->whereBetween('order.order_date', [$start, $end])
        ->groupBy('label')
        ->orderBy('label')
        ->get();

    // Doanh thu theo năm
    $yearly = DB::table('order')
        ->join('order_details', 'order.id', '=', 'order_details.order_id')
        ->select(
            DB::raw("YEAR(order.order_date) as label"),
            DB::raw('SUM(order_details.quantity * order_details.price) as total')
        )
        ->where('order.status', 2)
        ->whereBetween('order.order_date', [$start, $end])
        ->groupBy('label')
        ->orderBy('label')
        ->get();

    return response()->json([
        'daily' => $daily,
        'monthly' => $monthly,
        'yearly' => $yearly,
    ]);
}

public function getSalesByCategory(Request $request)
{
    $start = Carbon::parse($request->query('start'))->startOfDay();
    $end   = Carbon::parse($request->query('end'))->endOfDay();

    $sales = DB::table('order_details')
        ->join('product', 'order_details.product_id', '=', 'product.id')
        ->join('category_sub', 'product.category_sub_id', '=', 'category_sub.id')
        ->join('order', 'order_details.order_id', '=', 'order.id')
        ->select('category_sub.name', DB::raw('SUM(order_details.quantity * order_details.price) as total_sales'))
        ->where('order.status', 2)
        ->when($start && $end, function ($query) use ($start, $end) {
            return $query->whereBetween('order.order_date', [$start, $end]);
        })
        ->groupBy('category_sub.id', 'category_sub.name')
        ->orderByDesc('total_sales')
        ->get();

    return response()->json($sales);
}

public function getTopProducts(Request $request)
{
    $start = $request->query('start');
    $end   = $request->query('end');

    $sales = DB::table('order_details')
        ->join('product', 'order_details.product_id', '=', 'product.id')
        ->join('order', 'order_details.order_id', '=', 'order.id')
        ->select('product.name', DB::raw('SUM(order_details.quantity) as total_qty'))
        ->where('order.status', 2)
        ->when($start && $end, function ($query) use ($start, $end) {
            return $query->whereBetween('order.order_date', [$start, $end]);
        })
        ->groupBy('product.id', 'product.name')
        ->orderByDesc('total_qty')
        ->limit(5)
        ->get();

    return response()->json($sales);
}
}
