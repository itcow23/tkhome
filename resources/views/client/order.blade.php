@extends('client.layouts.master')
@section('content')

    	<!-- Shopping Cart -->
	<div class="shopping-cart section">
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
	</div>
	<!--/ End Shopping Cart -->
			
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