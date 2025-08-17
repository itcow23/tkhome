@extends('admin.layouts.master')

@section('content')    

    <h1>Thêm sản phẩm</h1>
    <form action="{{route('admin.product.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data" role="form">
        @csrf
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Tên sản phẩm</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="name" value="{{old('name')}}"  placeholder="Tên sản phẩm"> 
                @error('name')
                    <span style="color: crimson">{{$message}}</span>
                @enderror
            </div>
        </div> <!-- form-group // -->
        

        <div class="form-group">
            <label for="price" class="col-sm-3 control-label">Giá</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="price" value="{{old('price')}}"  placeholder="Giá">
                @error('price')
                    <span style="color: crimson">{{$message}}</span>
                @enderror
            </div>
        </div> <!-- form-group // -->
       

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label">Discount</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="discount" value="{{old('discount')}}"  placeholder="Discount">
            </div>
        </div> <!-- form-group // -->

        <div class="form-group">
            <label for="about" class="col-sm-3 control-label">Mô tả</label>
            <div class="col-sm-9">
            <textarea class="form-control" name="description">{{old('description')}}</textarea>
            </div>
        </div> <!-- form-group // -->

  
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Ảnh</label>
            <div class="col-sm-3">
            <input type="file" name="img">
            </div>
        </div> <!-- form-group // -->

        <div class="form-group">
            <label for="tech" class="col-sm-3 control-label">Danh mục</label>
            <div class="col-sm-3">
        <select class="form-control" name="category_sub_id">
            <option value=" ">Danh mục</option>
            @foreach ($category_sub as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
        @error('category_sub_id')
            <span style="color: crimson">{{$message}}</span>
        @enderror
            </div>
        </div> <!-- form-group // -->
       

        <hr>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
        </div> <!-- form-group // -->
     </form>

 @endsection