@extends('client.layouts.master')
@section('content')
	<!-- main -->
	<div class="main-w3layouts wrapper" style="
    background: linear-gradient(to top, #825f35, #f7941d);
    /* background-size: cover; */
    background-attachment: fixed;
    ">
			<h1>Login</h1>
			<div class="main-agileinfo">
				<div class="agileits-top">
                    <div>
                        @if ($message = session()->get('error'))
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @endif
                    </div>
					<div>
                        @if ($message = session()->get('success'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @endif
                    </div>
					<form action="{{route('client.processLogin')}}" method="post">
                        @csrf
						<input style="color: aliceblue;" class="text email" type="email" name="email" placeholder="Email" required="">
						<input style="color: aliceblue;" class="text" type="password" name="password" placeholder="Password" required="">
						<div class="wthree-text" style="margin-top: 10px;">
							<label class="anim">
								<input type="checkbox" class="checkbox" name="remember">
								<span>Ghi nhớ đăng nhập</span>
							</label>
                            <span style="margin-left: 40%;">
                                <a href="{{route('client.forgetPassword')}}" style="color: aliceblue">
                                    Quên mật khẩu
                                </a>
                            </span>
							<div class="clear"> </div>
						</div>
						<input type="submit" value="LOGIN">
					</form>
					<p>Don't have an Account? <a href="{{route('client.register')}}"> Register Now!</a></p>
				</div>
			</div>
	</div>
	<!-- //main -->
@endsection

@section('scripts')
<script type="application/x-javascript"> 
    addEventListener("load", function() { 
        setTimeout(hideURLbar, 0); }, false); 
        function hideURLbar(){ window.scrollTo(0,1); } 
</script>
@endsection