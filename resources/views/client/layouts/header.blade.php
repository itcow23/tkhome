@php
    $category = DB::table('category')
                ->orderBy('name', 'ASC')
                ->get();

    $carts = session()->get('cart', []);
    $total = 0;
    $num_product = count($carts);
@endphp
<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            <li><i class="ti-headphone-alt"></i> +060 (800) 801-582</li>
                            <li><i class="ti-email"></i> noithattrungkien@shop.com</li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar">
                            <a href="https://maps.app.goo.gl/76Dtd38fwggxNZN39" target="_blank" class="single-icon"><i class="ti-location-pin" aria-hidden="true"> Địa chỉ</i></a>
                        </div>
                        <div class="sinlge-bar">
                            <a href="#" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <div class="sinlge-bar shopping">
                            <a href="{{route('client.cart')}}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{$num_product}}</span></a>
                            <!-- Shopping Item -->
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span class="total-count">{{$num_product}}</span>
                                    <span> Sản Phẩm</span>
                                    <a href="{{route('client.cart')}}">Giỏ hàng</a>
                                </div>
                                <ul class="shopping-list">
                                    @foreach ($carts as $item)
                                        <li>
                                            <a href="#" class="remove btn-delete" data-slug="{{$item['slug']}}" title="Remove this item"><i class="fa fa-remove"></i></a>
                                            <a class="cart-img" href="{{route('client.product_details',$item['slug'])}}"><img src="{{asset('products')}}/{{$item['img']}}" alt="#"></a>
                                            <h4><a href="{{route('client.product_details',$item['slug'])}}">{{$item['name']}}</a></h4>
                                            <span class="quantity">{{$item['quantity']}}</span>
                                            <span class="amount"> - {{currency_format($item['price'])}}</span>
                                        </li>
                                        @php
                                            $sum = $item['price'] * $item['quantity'];
                                            $total += $sum;
                                        @endphp  
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Tỏng tiền: </span>
                                        <span class="total-amount">@php
                                            echo currency_format($total);
                                        @endphp</span>
                                    </div>
                                    @if(Auth::guard('client')->check())
                                        <a href="{{route('client.checkout')}}" class="btn animate">Thanh toán</a>
                                    @else
                                        <a class="btn" data-toggle="modal" data-target="#notificationLogin" title="Checkout" href="#">Thanh Toán</a>
                                    @endif
                                    
                                </div>
                            </div>
                            <!--/ End Shopping Item -->
                        </div>
                        <div class="sinlge-bar">
                            @if(Auth::guard('client')->check())
                                <div class="dropdown show">
                                        <a style="font-size: 150%;" class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 {{Auth::guard('client')->user()->fullname}}
                                        </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" >
                                        <a class="dropdown-item" href="{{route('client.changePassword')}}">Đổi mật khẩu</a>
                                    <a class="dropdown-item" href="{{route('client.order')}}">Đơn hàng</a>
                                    <a class="dropdown-item" href="{{route('client.logout')}}">Đăng xuất</a>
                                    </div>
                                </div>
                            @else
                            <a title="Login" href="{{route('client.login')}}" class="single-icon">Login <i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
  
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-2">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="{{route('client.home')}}"><img src="{{asset('images/LOGO3.png')}}" alt="logo"></a>
                        </div>
                    <!--/ End Logo -->
                    </div>
                    <div class="col-lg-3">
                        <div class="all-category">
                            <h3 class="cat-heading"><i class="fa fa-bars" aria-hidden="true"></i>DANH MỤC</h3>
                            <ul class="main-category">
                                @foreach ($category as $item)
                                    @php
                                        $category_sub = DB::table('category_sub')
                                                            ->where('category_id', $item->id)
                                                            ->orderBy('name', 'ASC')
                                                            ->get();
                                        $num_sub = count($category_sub);
                                    @endphp     
                                    <li><a href="{{route('client.productCategory',$item->slug)}}">{{$item->name}} 
                                            <i class="fa fa-angle-right" aria-hidden="true"  
                                                @php
                                                    if($num_sub <= 0)
                                                    echo 'style="display:none"';
                                                @endphp
                                            ></i>
                                        </a>
                                        <ul class="sub-category" 
                                            @php
                                                if($num_sub <= 0)
                                                echo 'style="display:none"';
                                            @endphp
                                        >
                                            @foreach ($category_sub as $item)
                                                <li><a href="{{route('client.productCategory',$item->slug)}}">{{$item->name}}</a></li>  
                                            @endforeach
                                        </ul>
                                    </li> 
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 col-12" style="padding-right: 0px;">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">	
                                    <div class="nav-inner">	
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li><a href="{{route('client.home')}}">Trang chủ</a></li>
                                            <li><a href="{{route('client.product')}}">Sản Phẩm</a></li>	
                                            <li><a href="{{route('client.cart')}}">Giỏ hàng</a></li>																			
                                            <li><a href="{{route('client.contact')}}">Liên hệ</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->	
                        </div>
                    </div>
                    <div class="col-lg-2" style="padding: 15px 0 0;position:relative;">
                            <form method="get" action="{{ route('client.product') }}">
                                <input name="search" value="{{ @$search }}" placeholder="Search Here....." type="search" style="border-radius:10px; outline:none;">
                                <button style="position: absolute; background:none; border:none; top:24px;right:24px;">
                                    <i class="ti-search" ></i>
                                </button>  
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>

 <!-- Modal login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 500px;">
        <div class="modal-content" style="border-radius: 40px;">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body" style="max-height: 600px;">
                 <div class="row no-gutters">
                    <div class="col-md-8 offset-md-2" style="margin: 60px auto;">
                        <ul class="nav nav-pills">
                            <li class="nav-item" style="width: 50%;"><a style="text-align: center;" class="nav-link active" data-toggle="tab" href="#signin">Sign in</a></li>
                            <li class="nav-item" style="width: 50%;"><a style="text-align: center;" class="nav-link" data-toggle="tab" href="#signup">Sign up</a></li>
                        </ul>
                         
                        <div class="tab-content">
                             <div id="signin" class="tab-pane fade active show">
                               <div class="card">
                                   <article class="card-body">
                                       <h4 class="card-title text-center mb-4 mt-1">Sign in</h4>
                                       <hr>
                                       <p class="text-success text-center">Some message goes here</p>
                                       <form>
                                       <div class="form-group">
                                       <div class="input-group">
                                           <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                               <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                            </div>
                                           <input name="" class="form-control" placeholder="Email or login" type="email">
                                       </div> <!-- input-group.// -->
                                       </div> <!-- form-group// -->
                                       <div class="form-group">
                                       <div class="input-group">
                                           <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                               <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                            </div>
                                           <input class="form-control" placeholder="******" type="password">
                                       </div> <!-- input-group.// -->
                                       </div> <!-- form-group// -->
                                       <div class="form-group">
                                       <button type="submit" class="btn btn-primary btn-block"> Login  </button>
                                       </div> <!-- form-group// -->
                                       <p class="text-center"><a href="#">Forgot password?</a></p>
                                       <div class="text-center" style="margin-top: 10px;">
                                         <a href="#" style="font-size: 20px; margin-right:20px;"><i class="fa fa-google"></i></a>
                                         <a href="#" style="font-size: 20px;"><i class="fa fa-facebook"></i></a>
                                       </div>
                                       </form>
                                   </article>
                               </div>
                             </div>
                             <div id="signup" class="tab-pane fade">
                                 <div class="card">
                                     <article class="card-body">
                                         <h4 class="card-title text-center mb-4 mt-1">Sign up</h4>
                                         <hr>
                                         <p class="text-success text-center">Some message goes here</p>
                                         <form>
                                         <div class="form-group">
                                             <div class="input-group">
                                                 <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                                     <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                 </div>
                                                 <input name="" class="form-control" placeholder="Name" type="text">
                                             </div> <!-- input-group.// -->
                                         </div> <!-- form-group// -->
                                         <div class="form-group">
                                             <div class="input-group">
                                                 <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                                     <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                                 </div>
                                                 <input class="form-control" placeholder="Phone number" type="text">
                                             </div> <!-- input-group.// -->
                                         </div> <!-- form-group// -->
                                         <div class="form-group">
                                             <div class="input-group">
                                                 <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                                     <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                                 </div>
                                                 <input class="form-control" placeholder="Email" type="email">
                                             </div> <!-- input-group.// -->
                                         </div> <!-- form-group// -->
                                         <div class="form-group">
                                             <div class="input-group">
                                                 <div class="input-group-prepend" style="margin-right: 6px; margin-top: 4px; ">
                                                     <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                 </div>
                                                 <input class="form-control" placeholder="******" type="password">
                                             </div> <!-- input-group.// -->
                                         </div> <!-- form-group// -->
                                         <div class="form-group">
                                         <button type="submit" class="btn btn-primary btn-block"> Sign up  </button>
                                         </div> <!-- form-group// -->
                                         </form>
                                     </article>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
<!-- Modal end -->
