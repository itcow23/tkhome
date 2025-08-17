@extends('admin.layouts.master')
@section('content')
<h1>Form sửa danh mục</h1>
<form action="{{route('admin.category.update')}}" method="post"> 
    @csrf
    <div class="form-group">
        <label for="address">Tên</label>
        <input type="text" class="form-control" id="address" name="name" value="{{$category->name}}" placeholder="Enter category name">
    </div>
    @error('name')
        <span style="color: crimson">{{$message}}</span>
    @enderror
    <button type="submit" class="btn btn-primary">Sửa</button>
</form>
@endsection