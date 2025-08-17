@extends('client.layouts.master')
@section('content')

    <!-- Slider Area -->
    <section class="hero-slider">
        <!-- Single Slider -->
        <div class="single-slider">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-9 offset-lg-3 col-12">
                        <div class="text-inner">
                            <div class="row">
                                <div class="col-12">
                                    <div class="hero-text">
                                        <h1 style="color: #ffffff">Nội thất Trung Kiên</h1>
                                        <p style="color: #ffffff">Truy cập ngay shop Nội thất Trung Kiên lựa chọn được những sản phẩm tốt nhất để hoàn thiện nội thất cho ngôi nhà của bạn.</p>
                                        <div class="button">
                                            <a href="{{route('client.product')}}" class="btn">Shop Now!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Single Slider -->
    </section>
    <!--/ End Slider Area -->

    <!-- Start Small Banner  -->
    <section class="small-banner section" style="padding: 100px 0px;">
        <div class="container-fluid">
            <div class="row">
                <!-- Single Banner  -->
                @foreach ($category_sub3 as $item)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-banner">
                            <img src="{{asset('categorySubs')}}/{{$item->img}}" alt="#">
                            <div class="content">
                                <h3 style="color: #ffffff">{{$item->name}}</h3>
                                <a style="color: #ffffff" href="{{route('client.product',['category_sub_id'=>$item->id])}}">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                <!-- /End Single Banner  -->
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Small Banner -->

    <!-- Start Midium Banner  -->
    <section class="midium-banner">
        <div class="container">
            <div class="row">
                @foreach ($category_sub2 as $item)
                    <!-- Single Banner  -->
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="single-banner">
                            <img src="{{asset('categorySubs')}}/{{$item->img}}" alt="#">
                            <div class="content">
                                <h3 style="color: #ffffff">{{$item->name}}</h3>
                                <a style="color: #ffffff" href="{{route('client.product',['category_sub_id'=>$item->id])}}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- /End Single Banner  --> 
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Midium Banner -->

    <!-- Start Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title" style="text-align: left;">
                        <h2>New Item</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="tab-content" id="myTabContent">
                            <!-- Start Single Tab -->
                            <div class="tab-pane fade show active" id="man" role="tabpanel">
                                <div class="tab-single">
                                    <div class="row">
                                        @foreach ($newproducts as $item)
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                                <div class="single-product">
                                                    <div class="product-img">
                                                        <a href="{{route('client.product_details',$item->slug)}}">
                                                            <img class="default-img" src="{{asset('products')}}/{{$item->img}}" alt="#">
                                                            <img class="hover-img" src="{{asset('products')}}/{{$item->img}}" alt="#">
                                                            @if(isset($item->discount))
                                                                @php
                                                                    $percent= ceil((($item->price - $item->discount) / $item->price) * 100); 
                                                                
                                                                @endphp
                                                                <span class="price-dec">{{$percent}}% OFF</span>
                                                            @else
                                                                <span class="new">New</span>
                                                            @endif
                                                        </a>
                                                        <div class="button-head">
                                                            <div class="product-action">
                                                                <a data-toggle="modal" data-target="#newid{{$item->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                                <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                                                <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                                                            </div>
                                                            <div class="product-action-2">
                                                                <a class="btn_add_to_cart" data-url="{{route('client.add_to_cart',['slug'=>$item->slug])}}" title="Add to cart" href="#">Thêm vào giỏ hàng</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        <h3><a href="{{route('client.product_details', $item->slug)}}">{{$item->name}}</a></h3>
                                                        <div class="product-price">
                                                            @if(isset($item->discount))
                                                                <span>{{currency_format($item->discount)}}</span>
                                                                <span class="old">{{currency_format($item->price)}}</span>
                                                            @else
                                                                <span>{{currency_format($item->price)}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--/ End Single Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Area -->



    <!-- Start Hot -->
    <div class="product-area most-popular section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title" style="text-align: left;">
                        <h2>Hot Item</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        <!-- Start Single Product -->
                        @foreach ($hotproducts as $item)
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('client.product_details',$item->slug)}}">
                                    <img class="default-img" src="{{asset('products')}}/{{$item->img}}" alt="#">
                                    <img class="hover-img" src="{{asset('products')}}/{{$item->img}}" alt="#">
                                    @if(isset($item->discount))
                                        @php
                                            $percent= ceil((($item->price - $item->discount) / $item->price) * 100); 
                                           
                                        @endphp
                                        <span class="price-dec">{{$percent}}% OFF</span>
                                    @else
                                        <span class="out-of-stock">Hot</span>
                                    @endif
                                    
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a data-toggle="modal" data-target="#hotid{{$item->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                        <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                        <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                                    </div>
                                    <div class="product-action-2">
                                        <a class="btn_add_to_cart" data-url="{{route('client.add_to_cart',['slug'=>$item->slug])}}" title="Add to cart" href="#">Thêm vào giỏ hàng</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{route('client.product_details', $item->slug)}}">{{$item->name}}</a></h3>
                                <div class="product-price">
                                    @if(isset($item->discount))
                                        <span>{{currency_format($item->discount)}}</span>
                                        <span class="old">{{currency_format($item->price)}}</span>
                                    @else
                                        <span>{{currency_format($item->price)}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>   
                        @endforeach
                        <!-- End Single Product -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Most Popular Area -->

    <!-- Start Shop Services Area -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shiping</h4>
                        <p>Orders over $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Sucure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Peice</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services Area -->

    <!-- Start Shop Newsletter  -->
    <section class="shop-newsletter section">
        <div class="container">
            <div class="inner-top">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <!-- Start Newsletter Inner -->
                        <div class="inner">
                            <h4>Newsletter</h4>
                            <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="EMAIL" placeholder="Your email address" required="" type="email">
                                <button class="btn">Subscribe</button>
                            </form>
                        </div>
                        <!-- End Newsletter Inner -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->

    <!-- Modal new -->
    @foreach ($newproducts as $item)
        <div class="modal fade" id="newid{{$item->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            <div class="single-slider">
                                                <img src="{{asset('products')}}/{{$item->img}}" alt="#">
                                            </div>
                                            <div class="single-slider">
                                                <img src="{{asset('products')}}/{{$item->img}}" alt="#">
                                            </div>
                                            <div class="single-slider">
                                                <img src="{{asset('products')}}/{{$item->img}}" alt="#">
                                            </div>
                                            <div class="single-slider">
                                                <img src="{{asset('products')}}/{{$item->img}}" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                <!-- End Product slider -->
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="quickview-content">
                                    <h2>{{$item->name}}</h2>
                                    <div class="quickview-ratting-review">
                                        <div class="quickview-ratting-wrap">
                                            <div class="quickview-ratting">
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <a href="#"> (1 customer review)</a>
                                        </div>
                                        <div class="quickview-stock">
                                            <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                        </div>
                                    </div>
                                    @if(isset($item->discount))
                                        <h3>{{currency_format($item->discount)}}</h3>
                                    @else
                                        <h3>{{currency_format($item->price)}}</h3>
                                    @endif
                                    <div class="quickview-peragraph">
                                        <p>{{$item->description}}</p>
                                    </div>
                                    <div class="quantity">
                                        <!-- Input Order -->
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number btn_quantity" data-slug="{{$item->slug}}" data-type="0" >
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                                <input data-slug="{{$item->slug}}" data-type="-1" type="text" name="add_quantity" class="input-number add_quantity" data-min="1" data-max="100" value="1">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number btn_quantity" data-slug="{{$item->slug}}" data-type="1" >
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--/ End Input Order -->
                                    </div>
                                    <div class="add-to-cart">
                                        <a href="#" class="btn btn_add_to_cart_quantity" data-url="{{route('client.add_to_cart',['slug'=>$item->slug])}}">Thêm vào giỏ hàng</a>
                                        <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                        <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                                    </div>
                                    <div class="default-social">
                                        <h4 class="share-now">Share:</h4>
                                        <ul>
                                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                            <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Modal end -->

     <!-- Modal hot -->
     @foreach ($hotproducts as $item)
     <div class="modal fade" id="hotid{{$item->id}}" tabindex="-1" role="dialog">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                 </div>
                 <div class="modal-body">
                     <div class="row no-gutters">
                         <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                             <!-- Product Slider -->
                                 <div class="product-gallery">
                                     <div class="quickview-slider-active">
                                         <div class="single-slider">
                                             <img src="{{asset('products')}}/{{$item->img}}" alt="#">
                                         </div>
                                         <div class="single-slider">
                                             <img src="{{asset('products')}}/{{$item->img}}" alt="#">
                                         </div>
                                         <div class="single-slider">
                                             <img src="{{asset('products')}}/{{$item->img}}" alt="#">
                                         </div>
                                         <div class="single-slider">
                                             <img src="{{asset('products')}}/{{$item->img}}" alt="#">
                                         </div>
                                     </div>
                                 </div>
                             <!-- End Product slider -->
                         </div>
                         <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                             <div class="quickview-content">
                                 <h2>{{$item->name}}</h2>
                                 <div class="quickview-ratting-review">
                                     <div class="quickview-ratting-wrap">
                                         <div class="quickview-ratting">
                                             <i class="yellow fa fa-star"></i>
                                             <i class="yellow fa fa-star"></i>
                                             <i class="yellow fa fa-star"></i>
                                             <i class="yellow fa fa-star"></i>
                                             <i class="fa fa-star"></i>
                                         </div>
                                         <a href="#"> (1 customer review)</a>
                                     </div>
                                     <div class="quickview-stock">
                                         <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                     </div>
                                 </div>
                                 @if(isset($item->discount))
                                    <h3>{{currency_format($item->discount)}}</h3>
                                 @else
                                    <h3>{{currency_format($item->price)}}</h3>
                                @endif
                                 <div class="quickview-peragraph">
                                     <p>{{$item->description}}</p>
                                 </div>
                                 <div class="quantity">
                                     <!-- Input Order -->
                                     <div class="input-group">
                                         <div class="button minus">
                                             <button type="button" class="btn btn-primary btn-number btn_quantity" data-slug="{{$item->slug}}" data-type="0" >
                                                 <i class="ti-minus"></i>
                                             </button>
                                         </div>
                                             <input data-slug="{{$item->slug}}" data-type="-1" type="text" name="add_quantity" class="input-number add_quantity" data-min="1" data-max="100" value="1">
                                         <div class="button plus">
                                             <button type="button" class="btn btn-primary btn-number btn_quantity" data-slug="{{$item->slug}}" data-type="1" >
                                                 <i class="ti-plus"></i>
                                             </button>
                                         </div>
                                     </div>
                                     <!--/ End Input Order -->
                                 </div>
                                 <div class="add-to-cart">
                                     <a href="#" class="btn btn_add_to_cart_quantity" data-url="{{route('client.add_to_cart',['slug'=>$item->slug])}}">Thêm vào giỏ hàng</a>
                                     <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                     <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                                 </div>
                                 <div class="default-social">
                                     <h4 class="share-now">Share:</h4>
                                     <ul>
                                         <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                         <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                         <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                         <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endforeach
 <!-- Modal end -->
@endsection

@section('scripts')
@if(!empty(session()->get('success')))
<script>
        toastr.success("{{session()->get('success')}}");

</script>
@endif
@endsection