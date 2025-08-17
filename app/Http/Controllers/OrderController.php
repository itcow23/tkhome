<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\ChangeStatusOrderEvent;

class OrderController extends Controller
{
    private $order;
    public function __construct() {
        $this->order = new Order();  // khởi tạo đối tượng product
    }
    public function index(){
        $orders = $this->order->getAll();
        return view('admin.order.home',compact('orders'))->with('i',(request()->input('page',1)-1)*10);
    }

    public function accept($id){
        $this->order->accept($id);

        $orderStatus = '<p class="text-success"> Đã xác nhận</p>';
        event( new ChangeStatusOrderEvent($orderStatus,$id) );
        return redirect()->back()->with('success','Đã xác nhận đơn hàng');
    }

    public function ship_success($id){
        $this->order->ship_success($id);

        $orderStatus = '<p class="text-info"> Đã giao hàng</p>';
        event( new ChangeStatusOrderEvent($orderStatus,$id) );
        return redirect()->back()->with('success','Đã giao hàng thành công');
    }

    public function cancel($id){
        $this->order->cancel($id);

        $orderStatus = '<p class="text-danger"> Đã huỷ</p>';
        event( new ChangeStatusOrderEvent($orderStatus,$id) );
        return redirect()->back()->with('success','Đã hủy đơn hàng');
    }

    public function filterOrders(Request $request){
        $filter = $request->input('filter');
        switch ($filter){
            case 'all':
                $orders =  DB::table('order')
                            ->orderBy('order.order_date','desc')
                            ->paginate(10)
                            ->appends([
                                'filter' => $filter
                            ]);
                            
                break;
            case -1:
                $orders =  DB::table('order')
                            ->where('status', -1)
                            ->orderBy('order.order_date','desc')
                            ->paginate(10)
                            ->appends([
                                'filter' => $filter
                            ]);
                            
                break;
            case 0:
                $orders =  DB::table('order')
                            ->where('status', 0)
                            ->orderBy('order.order_date','desc')
                            ->paginate(10)
                            ->appends([
                                'filter' => $filter
                            ]);
                            
                break;
            case 1:
                    $orders =  DB::table('order')
                                ->where('status', 1)
                                ->orderBy('order.order_date','desc')
                                ->paginate(10)
                                ->appends([
                                    'filter' => $filter
                                ]);
                                
                    break;
            case 2:
                        $orders =  DB::table('order')  
                                    ->where('status', 2)
                                    ->orderBy('order.order_date','desc')
                                    ->paginate(10)
                                    ->appends([
                                        'filter' => $filter
                                    ]);
                                    
                        break;
        }
        return view('admin.order.home',compact('orders','filter'))->with('i',(request()->input('page',1)-1)*10); // truyền dữ liệu products vào view
    }
}
