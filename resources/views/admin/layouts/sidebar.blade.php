@php
    $orderCount =  DB::table('order')->where('status', 0)->count();
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.home')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

     <!-- Nav Item - Category -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-list"></i>
            <span>Danh mục</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('admin.category.home')}}">Danh mục chính</a>
                <a class="collapse-item" href="{{route('admin.category_sub.home')}}">Danh mục con</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Product -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.product.home')}}">
            <i class="fas fa-fw fa-store"></i>
            <span>Sản Phẩm</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.user.home')}}">
            <i class="fas fa-fw fa-store"></i>
            <span>Tài khoản</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.order.home')}}">
            <i class="fas fa-fw fa-file"></i>
            <span>Đơn hàng</span>
            <span id="order-wait" class="badge badge-warning">{{$orderCount}}</span>
        </a>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">



    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>