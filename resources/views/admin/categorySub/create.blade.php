@extends('admin.layouts.master')
@section('content')
<h1>Form thêm danh mục</h1>
<form action="{{route('admin.category_sub.store')}}" method="post" enctype="multipart/form-data"> 
    @csrf
    <div class="form-group">
        <label for="address">Tên</label>
        <input type="text" class="form-control" id="address" value="{{old('name')}}" name="name"  placeholder="Enter category name">
        @error('name')
            <span style="color:crimson">{{$message}}</span>
        @enderror
    </div>
    <input type="file" name="img">
    <div class="form-group">
        <label for="name">Danh mục</label>
        <select name="category_id" class="form-select form-select-lg">
            <option value="">Danh mục</option>
            @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        @error('category_id')
            <span style="color:crimson">{{$message}}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Thêm</button>
</form>
@endsection