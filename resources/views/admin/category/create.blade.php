@extends('admin.layouts.master')
@section('content')
<h1>Form thêm danh mục</h1>
<form action="{{route('admin.category.store')}}" method="post"> 
    @csrf
    <div class="form-group">
        <label for="address">Tên</label>
        <input type="text" class="form-control" id="address" value="{{old('name')}}" name="name"  placeholder="Enter category name">
    </div>
    @error('name')
        <span style="color: crimson">{{$message}}</span>
    @enderror
    <button type="submit" class="btn btn-primary">Thêm</button>
</form>
@endsection