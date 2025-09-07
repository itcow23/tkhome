@extends('client.layouts.master')
@section('css')
<style>
    .order-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 20px;
        padding: 12px 16px;
        font-size: 14px;
    }
    .order-header, .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-products .product-item {
        display: grid;
        grid-template-columns: 70px 1fr auto;
        gap: 12px;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .order-products .product-item:last-child {
        border-bottom: none;
    }
    .order-products img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 6px;
    }
    .order-footer {
        border-top: 1px solid #f5f5f5;
        margin-top: 10px;
        padding-top: 8px;
    }
    .order-footer .total {
        font-weight: bold;
        font-size: 15px;
        color: #d0011b;
    }
    .order-actions {
        text-align: right;
        margin-top: 10px;
    }
    .order-actions .btn {
        font-size: 13px;
        padding: 4px 10px;
        border-radius: 6px;
    }
    /* Bộ lọc bên trái */
    .filter-box {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 15px;
    }
    .filter-box h5 {
        font-size: 16px;
        margin-bottom: 12px;
    }
    .filter-box select, .filter-box button {
        width: 100%;
    }
</style>

@endsection
@section('content')

    	<!-- Shopping Cart -->
	{{-- <div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
						<!-- Shopping Summery -->
							<div class="shop-shorter">
								<form action="{{route('client.filter_orders')}}" method="post">
									@csrf
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
							</div>
						<table class="table shopping-summery">
							<thead>
								<tr class="main-hading">
									<th>Thông tin nhận hàng</th>
									<th class="text-center">Thông tin đơn hàng</th>
									<th class="text-center">Ghi chú</th> 
									<th class="text-center">Ngày đặt</th>
									<th class="text-center">Trạng thái</th> 
									<th class="text-center"><i class="ti-trash remove-icon"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($orders as $item)
									<tr>
										<td class="product-des" data-title="Description">
											<span class="product-name">{{$item->fullname}}</span>
											<p class="product-name">{{$item->address}}</p>
											<p class="product-name">{{$item->email}}</p>
											<p class="product-name">{{$item->phone_number}}</p>
										</td>
										<td class="product-des" data-title="Description">
											<h2>@if($item->pay==1) Thanh toán chuyển khoản @else Thanh toán khi nhận hàng @endif</h2>
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
										<td id="orderstatus{{$item->id}}" class="product-des" data-title="Description">
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
										
										<td 
											@php
											if($item->status == 1){
												echo 'style ="display:none;"';
											}
											@endphp 
											class="action" data-title="Remove"
										>
											<a href="{{route('client.cancel_order',['id'=>$item->id])}}" class="btn-delete-cart"><i class="ti-trash remove-icon"></i></a>
										</td>
									</tr>	
								@endforeach

							</tbody>
						</table>
						<!--/ End Shopping Summery -->
				</div>
			</div>
		</div>
	</div> --}}
	<!--/ End Shopping Cart -->

<div class="container">
    <div class="row">
        {{-- Cột trái: Bộ lọc --}}
        <div class="col-md-3 mb-3">
            <div class="filter-box shadow-sm">
                <h5>Bộ lọc đơn hàng</h5>
                <form action="{{route('client.filter_orders')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <select name="filter" class="form-select">
                            <option value="all" @if(isset($filter) && $filter==='all') selected @endif>Tất cả</option>
                            <option value="2" @if(isset($filter) && $filter==='2') selected @endif>Đã giao</option>
                            <option value="1" @if(isset($filter) && $filter==='1') selected @endif>Đã xác nhận</option>
                            <option value="0" @if(isset($filter) && $filter==='0') selected @endif>Đang xử lý</option>
                            <option value="-1" @if(isset($filter) && $filter==='-1') selected @endif>Đã hủy</option>
                        </select>
                    </div>
                    <button class="btn btn-secondary w-100">Áp dụng</button>
                </form>
            </div>
        </div>

        {{-- Cột phải: Danh sách đơn hàng --}}
        <div class="col-md-9">
            @foreach ($orders as $item)
                <div class="order-card shadow-sm">
                    
                    {{-- Header --}}
                    <div class="order-header border-bottom pb-2 mb-2">
                        <div class="fw-bold"><i class="ti-bag"></i> {{ $item->fullname }}</div>
                        <div>
                            @php
                                switch ($item->status) {
                                    case 0: echo '<span class="text-warning">Đang xử lý</span>'; break;
                                    case 1: echo '<span class="text-success">Đã xác nhận</span>'; break;
                                    case 2: echo '<span class="text-info">Giao hàng thành công</span>'; break;
                                    case -1: echo '<span class="text-danger">Đã hủy</span>'; break;
                                }
                            @endphp
                        </div>
                    </div>

                    {{-- Products --}}
                    <div class="order-products">
                        @php
                            $products = DB::table('product')
                                            ->join('order_details','order_details.product_id','=','product.id')
                                            ->where('order_details.order_id',$item->id)
                                            ->get();
                        @endphp
                        @foreach ($products as $product)
                            @php $sum = $product->price * $product->quantity; @endphp
                            <div class="product-item">
                                <img src="{{asset('products')}}/{{$product->img}}" alt="">
                                <div>
                                    <div class="name">{{$product->name}}</div>
                                    <div class="qty">x {{$product->quantity}}</div>
                                </div>
                                <div class="text-danger fw-bold">{{currency_format($sum)}}</div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Footer --}}
                    <div class="order-footer">
                        <div class="text-muted small">
                            @if($item->pay==1)
                                Thanh toán chuyển khoản
                            @else
                                Thanh toán khi nhận hàng
                            @endif
                        </div>
                        <div class="total">
                            Thành tiền: {{currency_format($products->sum(fn($p)=>$p->price*$p->quantity))}}
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="order-actions">
                        @if($item->status != 1)
                            <a href="{{route('client.cancel_order',['id'=>$item->id])}}" class="btn btn-outline-danger btn-sm">Hủy đơn</a>
                        @endif
                        <a href="#" class="btn btn-primary btn-sm">Mua lại</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
			
@endsection

@section('scripts')
<script>
    var channel = pusher.subscribe('order-channel');
    channel.bind('orderstatus-event', function(data) {
		var id = data.id;
        $('td#orderstatus'+id).html(data.orderStatus);
    });
</script>
@endsection