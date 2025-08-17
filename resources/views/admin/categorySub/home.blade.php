@extends('admin.layouts.master')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Quản lý danh mục con</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <a class="btn btn-primary" href="{{route('admin.category_sub.create')}}">Thêm danh mục</a>

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Tên danh mục chính</th>
                        <th>Ảnh</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories_sub as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->category_name}}</td>
                            <td><img src="{{asset('categorySubs')}}/{{$item->img}}" alt="img" style="max-height: 100px"></td>
                            <th><a class="btn btn-primary" href="{{route('admin.category_sub.edit',['id'=>$item->id])}}"><i class="fas fa-fw fa-pen-square"></a></i></th>
                            <th>
                                <form action="{{route('admin.category_sub.delete',['id'=>$item->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirm('Bạn có chắc muốn xóa danh mục này ?')" class="btn btn-danger">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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