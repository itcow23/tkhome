@extends('client.layouts.master')
@section('content')
<div  class="col-md-6 offset-md-3" style="margin-bottom: 5%; margin-top: 5%;">
        <div style="text-align: center; margin-bottom: 50px;">
            <h1>Đặt hàng thành công</h1>
            <i class="fa fa-check-circle" style="font-size: 40px; color:green"></i>
        </div>
        <div style="margin-bottom: 30px; text-align: center;">
            <p class="fs-3">Bạn đã đặt hàng thành công. Shop sẽ liên hệ cho bạn để xác nhận đơn hàng.</p>
            <p class="fs-3">Xin cảm ơn !!!</p>
        </div>
        <div class="row justify-content-center" style="text-align: center">
            <div class="col-4">
                <a href="{{route('client.home')}}" class="btn btn-primary" style="color: aliceblue">Trang chủ</a>
            </div>
            <div class="col-4" >
                <a href="{{route('client.order')}}" style="color: aliceblue" class="btn btn-primary">Xem đơn hàng</a>
            </div>
        </div>
    </div>
@endsection