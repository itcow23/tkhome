@extends('admin.layouts.master')
@section('content')
<h1>Form sửa danh mục</h1>
<form action="{{route('admin.category_sub.update')}}" method="post" enctype="multipart/form-data"> 
    @csrf
    <div class="form-group">
        <label for="address">Tên</label>
        <input type="text" class="form-control" id="address" name="name" value="{{$category_sub->name}}" placeholder="Enter category name">
        @error('name')
            <span style="color:crimson">{{$message}}</span>
        @enderror
    </div>
    <input hidden type="file" name="old_img" value="{{$category_sub->img}}">
    <input type="file" name="img">
    <div class="form-group">
        <label for="name">Danh mục</label>
        <select name="category_id" class="form-select form-select-lg">
            @foreach ($categories as $category)
                <option value="{{$category->id}}" 
                    @php
                        if($category->id == $category_sub->category_id)
                        {
                            echo 'selected';
                        }
                    @endphp
                >{{$category->name}}</option>
            @endforeach
        </select>
        @error('category_id')
            <span style="color:crimson">{{$message}}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Sửa</button>
</form>
@endsection