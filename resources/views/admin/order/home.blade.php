@extends('admin.layouts.master')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Quản lý sản phẩm</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.order.filter_orders')}}">
            <div class="single-shorter">
                <select name="filter">
                    <option value="all"
                        @php
                            if(isset($filter))
                        {
                            if($filter === 'all')
                                echo 'selected = "selected"';
                        }
                        @endphp
                    >
                        Tất cả
                    </option>
                    <option value="2"
                        @php
                            if(isset($filter))
                        {
                            if($filter === '2')
                                echo 'selected = "selected"';
                        }
                        @endphp
                    >
                        Đã giao
                    </option>
                    <option value="1"
                        @php
                            if(isset($filter))
                        {
                            if($filter === '1')
                                echo 'selected = "selected"';
                        }
                        @endphp
                    >
                        Đã xác nhận
                    </option>
                    <option value="0"
                        @php
                            if(isset($filter))
                        {
                            if($filter === '0')
                                echo 'selected = "selected"';
                        }
                        @endphp
                    >
                        Đang xử lý
                    </option>
                    <option value="-1"
                        @php
                            if(isset($filter))
                        {
                            if($filter === '-1')
                                echo 'selected = "selected"';
                        }
                        @endphp
                    >
                        Đã hủy
                    </option>
                </select>
            </div>

            <button class="btn btn-secondary">Áp dụng</button>
        </form>
        <div class="table-responsive">
            {{$orders->links()}}
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thông tin nhận hàng</th>
                        <th>Thông tin đơn hàng</th>
                        <th>Note</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                        <tr>
                            <td>{{++$i}}</td>
                            <td class="product-des" data-title="Description">
                                <span class="product-name">{{$item->fullname}}</span>
                                <p class="product-name">{{$item->address}}</p>
                                <p class="product-name">{{$item->email}}</p>
                                <p class="product-name">{{$item->phone_number}}</p>
                            </td>
                            <td class="product-des" data-title="Description">
                                <h3>@if($item->pay==1) Thanh toán chuyển khoản @else Thanh toán khi nhận hàng @endif</h3>
                                <div class="order-details">
                                    <!-- Order Widget -->
                                    <div class="single-widget">
                                        <div class="content">
                                                    <ul>
                                                        @php
                                                            $products = DB::table('product')
                                                                            ->join('order_details','order_details.product_id','=','product.id')
                                                                            ->where('order_details.order_id',$item->id)
                                                                            ->get();
                                                        @endphp	
                                                        @foreach ($products as $product)
                                                            @php
                                                                $sum = $product->price * $product->quantity;
                                                            @endphp  
                                                            <li>
                                                                <img src="{{asset('products')}}/{{$product->img}}" alt="#" style="max-height: 80px">
                                                                <p>{{$product->name}}</p>
                                                                <span>x {{$product->quantity}} - {{currency_format($sum)}}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                        </div>
                                    </div>
                                    <!--/ End Order Widget -->
                                </div>
                            </td>
                            <td class="product-des" data-title="Description">
                                <p class="product-name">{{$item->note}}</p>
                            </td>
                            <td class="product-des" data-title="Description">
                                <p class="product-name">{{$item->order_date}}</p>
                            </td>
                            <td class="product-des" data-title="Description">
                                <p class="product-name">
                                    @php
                                        switch ($item->status) {
                                            case 0:
                                                echo '<p class="text-warning"> Đang xử lý</p>';
                                                break;
                                            case 1:
                                                echo '<p class="text-success"> Đã xác nhận</p>';
                                                break;
                                            case 2:
                                                echo '<p class="text-info"> Đã giao hàng</p>';
                                                break;
                                            case -1:
                                                echo '<p class="text-danger"> Đã hủy</p>';
                                                break;
                                        }
                                    @endphp
                                </p>
                            </td>
                                <th
                                    @php
                                        if($item->status == 1 || $item->status == -1 || $item->status == 2)
                                        {
                                            echo 'style="display:none;"';
                                        }
                                    @endphp
                                >
                                    <a class="btn btn-success" href="{{route('admin.order.accept',['id'=>$item->id])}}">Xác nhận</a>
                                </th>
                                <th
                                    @php
                                        if($item->status == -1 || $item->status == 2)
                                        {
                                            echo 'style="display:none;"';
                                        }
                                    @endphp
                                >
                                    <a class="btn btn-danger" href="{{route('admin.order.cancel',['id'=>$item->id])}}">Hủy</a>
                                </th>

                                <th
                                    @php
                                        if($item->status == -1 || $item->status == 2 || $item->status == 0)
                                        {
                                            echo 'style="display:none;"';
                                        }
                                    @endphp
                                >
                                    <a class="btn btn-info" href="{{route('admin.order.ship_success',['id'=>$item->id])}}">Đã giao</a>
                                </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$orders->links()}}
        </div>
    </div>
</div>
@endsection