@extends('client.layouts.master')
@section('content')

@php
	$total = 0;
	$carts = session()->get('cart', []);
	if($carts != null){
		foreach ($carts as $item) {
			$sum = $item['quantity'] * $item['price'];
			$total += $sum;
		}
	}
	$count = count($carts);
@endphp

				
		<!-- Start Checkout -->
		<section class="shop checkout section">
			<div class="container">
				<div class="row"> 
					@if($carts != null)
					<div class="col-lg-8 col-12">
						<div class="">
							<h2>Thông tin giao hàng</h2>
							<p></p>
							<!-- Form -->
							<form class="form" method="post" action="{{route('client.process_checkout')}}">
								@csrf
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Họ tên<span>*</span></label>
											<input type="text" name="fullname" placeholder="Họ tên" value="{{Auth::guard('client')->user()->fullname}}">
											@error('fullname')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Email<span>*</span></label>
											<input type="email" name="email" placeholder="Email" value="{{Auth::guard('client')->user()->email}}">
											@error('email')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Số điện thoại<span>*</span></label>
											<input type="text" name="phone_number" placeholder="Số điện thoại" value="{{Auth::guard('client')->user()->phone_number}}">
											@error('phone_number')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Tỉnh<span>*</span></label>
											<select name="province" id="province" >
												<option value=" ">Tỉnh/Thành Phố</option>
												@foreach ($provinces as $item)
													<option  value="{{$item->province_id}}">{{$item->name}}</option>
												@endforeach
											</select>
										</div>
											@error('province')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
									</div>
									<div class="col-lg-6 col-md-6 col-12" id="district">
										<div class="form-group">
											<label>Huyện<span>*</span></label>
											<select class="form-select" name="district" id="district" >
												<option value=" ">Quận/Huyện</option>
											</select>
										</div>
											@error('district')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
									</div>
									<div class="col-lg-6 col-md-6 col-12" id="ward">
											<select class="form-select" name="ward" id="ward" >
												<option value=" ">Xã/Phường</option>
											</select>
											@error('ward')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
									</div>
									
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Địa chỉ cụ thể<span>*</span></label>
											<input type="text" name="address" placeholder="Địa chỉ" >
											@error('address')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Lưu ý</label>
											<textarea name="note" id="" cols="15" rows="5"></textarea>
										</div>
									</div>
								</div>
								<!-- Order Widget -->
									<div class="single-widget">
										<h2>Hình thức thanh toán</h2>
										<div class="content">
											<div class="form-check">
												<input class="form-check-input" type="radio" name="pay" value="2" id="cash">
												<label onclick="cash()" class="form-check-label" for="cash">
													Thanh toán khi nhận hàng
												</label>
											</div>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="radio" name="pay" value="1" id="transfer">
											<label onclick="transfer()" class="form-check-label" for="transfer">
												  Chuyển khoản
											</label>
										</div>
										<div id="pay_transfer" style="display: none;">
											<h3>Ngân hàng MBBank</h3>
											<p>STK: 686898686</p>
											<p>Chủ tài khoản: CT CP NOI THA TRUNG KIEN</p>
										</div>
										@error('pay')
												<span style="color: crimson" >{{$message}}</span>
										@enderror
									</div>
								<!--/ End Order Widget -->
								<div class="single-widget get-button col-lg-6 col-md-6">
									<div class="content">
										<div class="button">
											<button class="btn">Đặt hàng</button>
										</div>
									</div>
								</div>
								<!--/ End Button Widget -->
							</form>
							<!--/ End Form -->
						</div>
					</div>
					<div class="col-lg-4 col-12">
						<div class="order-details">
							<!-- Order Widget -->
							<div class="single-widget">
								<h2>Tóm tắt đơn hàng</h2>
								<div class="content">
									<ul>
										<li class="last">Sản Phẩm ({{$count}}) </li>
											<ul>
												@foreach ($carts as $item)
													@php
														$sum = $item['price'] * $item['quantity'];
													@endphp  
													<li>
														<img src="{{asset('products')}}/{{$item['img']}}" alt="#" style="max-height: 80px">
														<p>{{$item['name']}}</p>
														<span>x {{$item['quantity']}} - {{currency_format($sum)}}</span>
													</li>
												@endforeach
											</ul>
										<hr style="height: 0; margin-bottom: 3.5rem;">
										<li class="last">Tổng tiền<span>{{currency_format($total)}}</span></li>
									</ul>
								</div>
							</div>
							<!--/ End Order Widget -->
						</div>
					</div>
					@else
						<h2 style="color: black">Thêm sản phẩm để thanh toán</h2>
					@endif
				</div>
			</div>
		</section>
		<!--/ End Checkout -->
		
		<!-- Start Shop Services Area  -->
		<section class="shop-services section home">
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
		<!-- End Shop Services -->


			
@endsection

@section('scripts')
	<script>
		function transfer(){
			document.getElementById("pay_transfer").style.display="block";
		}
		function cash(){
			document.getElementById("pay_transfer").style.display="none";
		}
	</script>

	<script>
		$(document).on('change','#province',function(){
			let province_id = $(this).val();
			 
			$.ajax({
				url: "{{route('client.district')}}",
				type: 'POST',
				data: {
					province_id: province_id,
					_token: "{{csrf_token()}}"
				},		
				
			})
			.done (function(res){
				$("div#district .nice-select > ul.list").html(res.district_component);
				$("select#district").html(res.district_option_component);
			})
		})
	</script>

<script>
	$(document).on('change','#district',function(){
		let district_id = $(this).val();
		 
		$.ajax({
			url: "{{route('client.ward')}}",
			type: 'POST',
			data: {
				district_id: district_id,
				_token: "{{csrf_token()}}"
			},		
			
		})
		.done (function(res){
			$("div#ward .nice-select > ul.list").html(res.ward_component);
			$("select#ward").html(res.ward_option_component);
		})
	})
</script>
@endsection