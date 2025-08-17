@extends('admin.layouts.master')

@section('content')    

    <h1>Sửa thông tin tài khoản</h1>
    <form action="{{route('admin.user.update')}}" method="POST" class="form-horizontal" enctype="multipart/form-data" role="form">
        @csrf
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Họ tên</label>
            <div class="col-sm-3">
                <input type="text" readonly class="form-control" name="fullname" value="{{$user->fullname}}"  placeholder="Họ tên">
            </div>
        </div> <!-- form-group // -->

        <div class="form-group">
            <label for="price" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-3">
                <input type="text" readonly class="form-control" value="{{$user->email}}" name="email"  placeholder="Email">
            </div>
        </div> <!-- form-group // -->

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label">Số điện thoại</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" readonly value="{{$user->phone_number}}" name="discount"  placeholder="Số điện thoại">
            </div>
        </div> <!-- form-group // -->
 
        <div class="form-group">
            <label for="tech" class="col-sm-3 control-label">Quyền hạn</label>
            <div class="col-sm-3">
                <select class="form-control" name="role_id">
                    @foreach ($role as $item)
                        <option value="{{$item->id}}"
                            @php
                                if ($item->id == $user->role_id) {
                                    echo  'selected';
                                }
                            @endphp
                        >
                            {{$item->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div> <!-- form-group // -->

        <hr>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-primary">Sửa</button>
            </div>
        </div> <!-- form-group // -->
     </form>

 @endsection