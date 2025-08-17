@extends('client.layouts.master')
@section('content')
    <!-- Start Checkout -->
		<section class="shop checkout section">
			<div class="container">
				<div class="row"> 
					<div class="col-lg-8 col-12">
                        <h2 style="font-size: 150%;">Đổi mặt khẩu</h2>
						<div class="col-md-6 offset-md-3">
							<p></p>
							<!-- Form -->
							<form class="form" method="post" action="{{route('client.processChangePassword')}}">
								@csrf
								<div class="row">
									<div class="col-12">
										<div class="form-group">
											<label>Nhập mật khẩu cũ<span>*</span></label>
											<input type="password" name="old_password" placeholder="Mật khẩu">
											@error('old_password')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
                                            @if (!empty(session()->get('error')))
                                                <span style="color: crimson" >{{session()->get('error')}}</span>
                                            @endif
										</div>
									</div>
                                    <div class="col-12">
										<div class="form-group">
											<label>Nhập mật khẩu mới<span>*</span></label>
											<input type="password" name="password" placeholder="Mật khẩu">
											@error('password')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
										</div>
									</div>
                                    <div class="col-12">
										<div class="form-group">
											<label>Xác nhận lại mật khẩu<span>*</span></label>
											<input type="password" name="confirm_password" placeholder="Mật khẩu">
											@error('confirm_password')
												<span style="color: crimson" >{{$message}}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="single-widget get-button col-12">
									<div class="content">
										<div class="button">
											<button class="btn">Xác nhận</button>
										</div>
									</div>
								</div>
								<!--/ End Button Widget -->
							</form>
							<!--/ End Form -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Checkout -->
@endsection