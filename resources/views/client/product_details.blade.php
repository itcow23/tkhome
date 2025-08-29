@extends('client.layouts.master')
@section('content')
@php
    use Carbon\Carbon;
@endphp
    		<!-- Product Style -->
		<section class="product-area shop-sidebar shop section">
			<div class="container">
				<div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <!-- Product Slider -->
                            <div class="product-gallery">
                                <div class="quickview-slider-active">
                                    <div class="single-slider">
                                        <img src="{{asset('products')}}/{{$product->img}}" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="{{asset('products')}}/{{$product->img}}" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="{{asset('products')}}/{{$product->img}}" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="{{asset('products')}}/{{$product->img}}" alt="#">
                                    </div>
                                </div>
                            </div>
                        <!-- End Product slider -->
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-content">
                            <h2>{{$product->name}}</h2>
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
                            @if(isset($product->discount))
                                <h3>{{currency_format($product->discount)}}</h3>
                            @else
                                <h3>{{currency_format($product->price)}}</h3>
                            @endif
                            <div class="quickview-peragraph">
                                <p>{{$product->description}}</p>
                            </div>
                            <div class="quantity">
                                <!-- Input Order -->
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button" class="btn btn-primary btn-number btn_quantity" data-slug="{{$product->slug}}" data-type="0" >
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                        <input data-slug="{{$product->slug}}" data-type="-1" type="text" name="add_quantity" class="input-number add_quantity" data-min="1" data-max="100" value="1">
                                    <div class="button plus">
                                        <button type="button" class="btn btn-primary btn-number btn_quantity" data-slug="{{$product->slug}}" data-type="1" >
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!--/ End Input Order -->
                            </div>
                            <div class="add-to-cart">
                                <a href="#" class="btn btn_add_to_cart_quantity" data-url="{{route('client.add_to_cart',['slug'=>$product->slug])}}">Thêm vào giỏ hàng</a>
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
		</section>
		<!--/ End Product Style 1  -->	

  <!-- Start Most Popular -->
  <div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title" style="text-align: left;">
                    <h2>Sản phẩm tương tự</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    <!-- Start Single Product -->
                    @foreach ($sameproducts as $item)
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
                                        <span class="new" 
                                            @php
                                                $current = Carbon::now('Asia/Ho_Chi_Minh');
                                                $created = $item->created_at;
                                                if($current->diffInDays($created) <= 7){
                                                    echo 'style="display:block;"';
                                                }else {
                                                    echo 'style="display:none;"';
                                                }
                                                
                                            @endphp
                                        >
                                        New
                                        </span>
                                    @endif
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a data-toggle="modal" data-target="#id{{$item->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                        <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                        <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                                    </div>
                                    <div class="product-action-2">
                                            <a class="btn_add_to_cart" data-url="{{route('client.add_to_cart',['slug'=>$item->slug])}}" title="Add to cart" href="#">Thêm vào giỏ hàng</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{route('client.product_details',$item->slug)}}">{{$item->name}}</a></h3>
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

        
        @foreach ($sameproducts as $item)
        <!-- Modal -->
            <div class="modal fade" id="id{{$item->id}}" tabindex="-1" role="dialog">
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
            <!-- Modal end -->
        
        @endforeach
@endsection