@extends('client.layouts.master')
@section('content')
	<!-- main -->
	<div class="main-w3layouts wrapper" style="
    background: linear-gradient(to top, #825f35, #f7941d);
    /* background-size: cover; */
    background-attachment: fixed;
    ">
			<h1>Re-Password</h1>
			<div class="main-agileinfo">
				<div class="agileits-top">
                    <div>
                        @if ($message = session()->get('error'))
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @endif
                    </div>
					<form action="{{route('client.processRePassword')}}" method="post">
                        @csrf
						<input type="text" hidden name="email" value="{{session()->get('email')}}" id="">
						<span style="color: azure">New Password:</span>
						<input style="color: aliceblue;" class="text" type="password" name="password"  placeholder="Password">
						@error('password')
							<p style="color: rgb(255, 0, 0)">{{$message}}</p>
						@enderror

						<span style="color: azure">Confirm Password:</span>
						<input style="color: aliceblue;" class="text w3lpass" type="password" name="confirm_password" placeholder="Confirm Password">
						@error('confirm_password')
							<p style="color: rgb(255, 0, 0)">{{$message}}</p>
						@enderror
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