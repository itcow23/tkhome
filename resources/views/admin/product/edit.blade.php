@extends('admin.layouts.master')

@section('content')    

    <h1>Sửa thông tin sản phẩm</h1>
    <form action="{{route('admin.product.update')}}" method="POST" class="form-horizontal" enctype="multipart/form-data" role="form">
        @csrf
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Tên sản phẩm</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="name" value="{{$product->name}}"  placeholder="Tên sản phẩm">
            </div>
            @error('name')
                <span style="color: crimson">{{$message}}</span>
            @enderror
        </div> <!-- form-group // -->

        <div class="form-group">
            <label for="price" class="col-sm-3 control-label">Giá</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{$product->price}}" name="price"  placeholder="Giá">
            </div>
            @error('price')
                <span style="color: crimson">{{$message}}</span>
            @enderror
        </div> <!-- form-group // -->

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label">Discount</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" value="{{$product->discount}}" name="discount"  placeholder="Discount">
            </div>
        </div> <!-- form-group // -->

        <div class="form-group">
            <label for="about" class="col-sm-3 control-label">Mô tả</label>
            <div class="col-sm-9">
            <textarea class="form-control" name="description">{{$product->description}}</textarea>
            </div>
        </div> <!-- form-group // -->

  
        <div class="form-group">
            <input type="hidden" name="img_old" value="{{$product->img}}">
            <label for="name" class="col-sm-3 control-label">Ảnh</label>
            <div class="col-sm-3">
            <input type="file" name="img">
            </div>
        </div> <!-- form-group // -->

        <div class="form-group">
            <label for="tech" class="col-sm-3 control-label">Danh mục</label>
            <div class="col-sm-3">
                <select class="form-control" name="category_sub_id">
                    @foreach ($category_sub as $item)
                        <option value="{{$item->id}}"
                            @php
                                if ($item->id == $product->category_sub_id) {
                                    echo  'selected';
                                }
                            @endphp
                        >
                            {{$item->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('category_sub_id')
                <span style="color: crimson">{{$message}}</span>
            @enderror
        </div> <!-- form-group // -->

        <input type="hidden" name="created_at" value="{{$product->created_at}}">

        <hr>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-primary">Sửa</button>
            </div>
        </div> <!-- form-group // -->
     </form>

 @endsection