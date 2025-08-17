@extends('admin.layouts.master')
@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="row">
    @php
      $sales = DB::table('order')
                ->select('order_details.price','order_details.quantity')
                ->join('order_details', 'order_details.order_id', '=' ,'order.id')
                ->whereMonth('order_date','=',Carbon::now('Asia/Ho_Chi_Minh')->month)
                ->where('status','=','2')
                ->get();      
        $total = 0;
        foreach ($sales as $sale) {
            $sum = $sale->price * $sale->quantity;
            $total += $sum;
        }
                   
    @endphp
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Doanh thu tháng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{currency_format($total)}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    {{-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Earnings (Annual)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Earnings (Monthly) Card Example -->
    @php
        $count_order_success = DB::table('order')
                                ->select(DB::raw('count(id) as total_order'))
                                ->whereMonth('order_date','=',Carbon::now('Asia/Ho_Chi_Minh')->month)
                                ->where('status','=','2')
                                ->first();
                   
    @endphp  
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn thành công
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$count_order_success->total_order}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->   
    @php
        $count_order_cancel = DB::table('order')
                                ->select(DB::raw('count(id) as total_order'))
                                ->whereMonth('order_date','=',Carbon::now('Asia/Ho_Chi_Minh')->month)
                                ->where('status','=','-1')
                                ->first();
               
    @endphp  
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Đơn hủy</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_order_cancel->total_order}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var channel = pusher.subscribe('order-channel');
    channel.bind('ordersucess-event', function(data) {
        $('#order-wait').html(data.orderCount);
        toastr.success("Bạn có một đơn hàng mới, mã đơn hàng: #" + data.order.id, 'Thông báo', {timeOut: 50000})
    });
</script>
@endsection