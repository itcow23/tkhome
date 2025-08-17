@extends('client.layouts.master')
@section('content')
	<!-- main -->
	<div class="main-w3layouts wrapper" style="
    background: linear-gradient(to top, #825f35, #f7941d);
    /* background-size: cover; */
    background-attachment: fixed;
    ">
			<h1>Register</h1>
			<div class="main-agileinfo">
				<div class="agileits-top">
					<form action="{{route('client.processRegister')}}" method="post">
						@csrf
						<span style="color: azure">Username:</span>
						<input style="color: aliceblue;" class="text" type="text" name="fullname" value="{{old('fullname')}}" placeholder="Username">
						@error('fullname')
							<p style="color: rgb(255, 0, 0)">{{$message}}</p>
						@enderror

						<span style="color: azure">Email:</span>
						<input style="color: aliceblue;" class="text email" type="email" name="email" value="{{old('email')}}" placeholder="Email">
						@error('email')
							<p style="color: rgb(255, 0, 0)">{{$message}}</p>
						@enderror

						<span style="color: azure">Password:</span>
						<input style="color: aliceblue;" class="text" type="password" name="password"  placeholder="Password">
						@error('password')
							<p style="color: rgb(255, 0, 0)">{{$message}}</p>
						@enderror

						<span style="color: azure">Confirm Password:</span>
						<input style="color: aliceblue;" class="text w3lpass" type="password" name="confirm_password" placeholder="Confirm Password">
						@error('confirm_password')
							<p style="color: rgb(255, 0, 0)">{{$message}}</p>
						@enderror
						<div class="wthree-text">
							<div class="clear"> </div>
						</div>
						<input type="submit" value="REGISTER">
					</form>
					<p>You have an Account? <a href="{{route('client.login')}}"> Login Now!</a></p>
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