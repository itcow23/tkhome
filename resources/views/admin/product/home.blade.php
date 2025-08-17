@extends('admin.layouts.master')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Quản lý sản phẩm</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form action="{{route('admin.product.home')}}">
                Tìm kiếm
                <input type="search" value="{{@$search}}" name="search"> 
            </form>
            {{$products->links()}}
            <a class="btn btn-primary" href="{{route('admin.product.create')}}">Thêm sản phẩm</a>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phầm</th>
                        <th>Giá sản phẩm</th>
                        <th>Discount</th>
                        <th>Mô tả</th>
                        <th>Ảnh</th>
                        <th>Danh mục</th>
                        <th>Ngày tạo</th>
                        <th>Cập nhật</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        @php
                            $img = $item->img;
                        @endphp
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{currency_format($item->price)}}</td>
                            <td>{{$item->discount}}</td>
                            <td>{{$item->description}}</td>
                            <td><img src="{{asset('products')}}/{{$item->img}}" alt="Ảnh" style="max-height: 100px;"></td>
                            <td>{{$item->category_sub_name}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->updated_at}}</td>
                            <th><a class="btn btn-primary" href="{{route('admin.product.edit',['id'=>$item->id, 'last_page' => $products->currentPage()])}}"><i class="fas fa-fw fa-pen-square"></a></i></th>
                            <th>
                                <form action="{{route('admin.product.delete',['id'=>$item->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này ?')" class="btn btn-danger">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$products->links()}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @if($message = session()->get('success'))
    <script>
            toastr.success("{{$message}}");
    </script>
    @endif;
@endsection