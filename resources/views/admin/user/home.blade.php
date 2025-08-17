@extends('admin.layouts.master')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Quản lý sản phẩm</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            {{$users->links()}}
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Quyền hạn</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$item->fullname}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone_number}}</td>
                            <td>{{$item->role_name}}</td>
                            <th><a class="btn btn-primary" href="{{route('admin.user.edit',['id'=>$item->id, 'last_page' => $users->currentPage()])}}"><i class="fas fa-fw fa-pen-square"></a></i></th>
                            <th>
                                <form action="{{route('admin.user.delete',['id'=>$item->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirm('Bạn có chắc muốn xóa tài khoản này ?')" class="btn btn-danger">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$users->links()}}
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