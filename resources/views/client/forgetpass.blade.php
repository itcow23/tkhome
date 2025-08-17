@extends('client.layouts.master')
@section('content')
	<!-- main -->
	<div class="main-w3layouts wrapper" style="
    background: linear-gradient(to top, #825f35, #f7941d);
    /* background-size: cover; */
    background-attachment: fixed;
    ">
			<h1>Forget Password</h1>
			<div class="main-agileinfo">
				<div class="agileits-top">
                    <div>
                        @if ($message = session()->get('error'))
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @endif
                    </div>
					<form action="{{route('client.processForgetPassword')}}" method="post">
                        @csrf
						<h2 style="color: azure">Nhập email để đặt lại mật khẩu</h2>
						<input style="color: aliceblue;" class="text email" type="email" name="email" placeholder="Email">
							<div class="clear"> </div>
						</div>
						<input type="submit" value="Send">
					</form>
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