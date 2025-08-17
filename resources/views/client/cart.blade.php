@extends('client.layouts.master')
@section('content')
@php
	$total = 0;
@endphp

    	<!-- Shopping Cart -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th>Sản phẩm</th>
								<th>Tên sản phẩm</th>
								<th class="text-center">Giá</th>
								<th class="text-center">Số Lượng</th>
								<th class="text-center">Tổng</th> 
								<th class="text-center"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($carts as $item)
								<tr>
									<td class="image" data-title="No"><img src="{{asset('products')}}/{{$item['img']}}" alt="#"></td>
									<td class="product-des" data-title="Description">
										<p class="product-name"><a href="{{route('client.product_details',$item['slug'])}}">{{$item['name']}}</a></p>
										{{-- <p class="product-des">Maboriosam in a tonto nesciung eget  distingy magndapibus.</p> --}}
									</td>
									<td class="price" data-title="Price"><span class="span-price">{{currency_format($item['price'])}}</span></td>
									<td class="qty" data-title="Qty"><!-- Input Order -->
										<div class="input-group">
											<div class="button minus">
												<button type="button" class="btn btn-primary btn-number btn_update_quantity" data-slug="{{$item['slug']}}" data-type="0" >
													<i class="ti-minus"></i>
												</button>
											</div>
												<input data-slug="{{$item['slug']}}" data-type="-1" type="text" name="quantity" class="input-number quantity" data-min="1" data-max="100" value="{{$item['quantity']}}">
											<div class="button plus">
												<button type="button" class="btn btn-primary btn-number btn_update_quantity" data-slug="{{$item['slug']}}" data-type="1" >
													<i class="ti-plus"></i>
												</button>
											</div>
										</div>
										<!--/ End Input Order -->
									</td>
									<td class="sum" data-title="Total"><span>
											@php
												$sum = $item['price'] * $item['quantity'];
												$total += $sum;
												echo currency_format($sum);
											@endphp
										</span></td>
									<td class="action" data-title="Remove">
										<a href="#" class="btn-delete-cart" data-slug="{{$item['slug']}}"><i class="ti-trash remove-icon"></i></a>
									</td>
								</tr>	
							@endforeach

						</tbody>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12">
								<div class="left">
									<div class="button5">
										<a style="color: aliceblue" href="{{route('client.product')}}" class="btn">Tiếp tục mua hàng</a>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li class="last total">Tổng tiền<span>
											@php
											 	echo currency_format($total);
											@endphp</span>
										</li>
									</ul>
									<div class="button5">
										@if(Auth::guard('client')->check())
										<a href="{{route('client.checkout')}}" class="btn">Thanh toán</a>
										@else
											<a class="btn" data-toggle="modal" data-target="#notificationLogin" title="Checkout" href="#">Thanh toán</a>
										@endif
										
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->
			
	<!-- Start Shop Services Area  -->
	<section class="shop-services section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shiping</h4>
						<p>Orders over $100</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Sucure Payment</h4>
						<p>100% secure payment</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Peice</h4>
						<p>Guaranteed price</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->
	
	<!-- Start Shop Newsletter  -->
	<section class="shop-newsletter section">
		<div class="container">
			<div class="inner-top">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 col-12">
						<!-- Start Newsletter Inner -->
						<div class="inner">
							<h4>Newsletter</h4>
							<p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
							<form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
								<input name="EMAIL" placeholder="Your email address" required="" type="email">
								<button class="btn">Subscribe</button>
							</form>
						</div>
						<!-- End Newsletter Inner -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->
	@section('scripts')
		{{-- <script type="text/javascript">
			$(document).ready(function(){
				$(".btn_update_quantity").click(function(e){
					let slug = $(this).data('slug');
					let type = parseInt($(this).data('type'));
					let tr = $(this).closest('tr');
					onChangeQuantity(slug, type, tr);
				});

				$("input.quantity").on('input', function() {
					let slug = $(this).data('slug');
					let type = parseInt($(this).data('type'));
					let tr = $(this).closest('tr');
					const value = $(this).val();

					if (value <= 0) {
						$(this).val(1);
					}

					onChangeQuantity(slug, -1, tr, $(this).val());
				});
				$(".btn-delete").click(function(){
					let btn = $(this);
					let slug = btn.data('slug');
					let tr = btn.parents('tr');
					$.ajax({
							url: "{{route('client.destroyCart')}}",
							type: 'POST',
							data:{
								slug: slug,
								_token: "{{csrf_token()}}"
							},
						})
						.done(function(res){
							tr.remove();
							$('.shopping-cart .total > span').html(res.total);
					});
				});
				function onChangeQuantity(slug, type, tr, value = "") {
					const parent = tr;
					$.ajax({
							url: "{{route('client.updateCart')}}",
							type: 'GET',
							data:{
								slug: slug,
								type: parseInt(type),
								value: value,
							},
						})
						.done(function(res){
							parent.find('input.quantity').val(res.cart.quantity);
							parent.find('td.sum').html(res.cart.sum_price);
							$('.shopping-cart .total > span').html(res.total);
					});
				}
			});
		</script> --}}
	@endsection
@endsection