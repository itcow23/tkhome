<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Tag  -->
    <title>TKHome</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favi.png">
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- StyleSheet -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{asset('css/magnific-popup.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Fancybox -->
    <link rel="stylesheet" href="{{asset('css/jquery.fancybox.min.css')}}">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="{{asset('css/themify-icons.css')}}">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{asset('css/niceselect.css')}}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- Flex Slider CSS -->
    <link rel="stylesheet" href="{{asset('css/flex-slider.min.css')}}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('css/owl-carousel.css')}}">
    <!-- Slicknav -->
    <link rel="stylesheet" href="{{asset('css/slicknav.min.css')}}">

    {{--Login --}}
    <link rel="stylesheet" href="{{asset('css/login.css')}}">

    <!-- Eshop StyleSheet -->
    <link rel="stylesheet" href="{{asset('css/reset.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">

    {{-- Toast --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('css')


</head>

<body class="js">

    <!-- Preloader -->
        @include('client.layouts.preloader')
    <!-- End Preloader -->


    <!-- Header -->
        @include('client.layouts.header')
    <!--/ End Header -->

    @yield('content')

    <!-- Modal notification login -->
    <div class="modal fade" id="notificationLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document" style="margin-top: 2%">
        <div class="modal-content col-md-4 offset-md-4" >
            <div class="modal-header">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                </div>
            </div>
            <div class="modal-body" style="max-height: 100px;">
                <div class="row no-gutters">
                        <h2 style="margin: 10% auto;">Vui lòng đăng nhập để mua hàng !!!</h2>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center">
            <a style="color: #ffffff" href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
            <a style="color: #ffffff" class="btn btn-secondary" href="{{route('client.login')}}">Đăng nhập</a>
            </div>
        </div>
        </div>
    </div>
 <!-- Modal end -->

    <!-- Start Footer Area -->
        @include('client.layouts.footer')
    <!-- /End Footer Area -->

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <!-- Jquery -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery-migrate-3.0.0.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>

    {{-- Toast --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Popper JS -->
    <script src="{{asset('js/popper.min.js')}}"></script>
    <!-- Bootstrap JS -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- Color JS -->
    <script src="{{asset('js/colors.js')}}"></script>
    <!-- Slicknav JS -->
    <script src="{{asset('js/slicknav.min.js')}}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{asset('js/owl-carousel.js')}}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{asset('js/magnific-popup.js')}}"></script>
    <!-- Waypoints JS -->
    <script src="{{asset('js/waypoints.min.js')}}"></script>
    <!-- Countdown JS -->
    <script src="{{asset('js/finalcountdown.min.js')}}"></script>
    <!-- Nice Select JS -->
    <script src="{{asset('js/nicesellect.js')}}"></script>
    <!-- Flex Slider JS -->
    <script src="{{asset('js/flex-slider.js')}}"></script>
    <!-- ScrollUp JS -->
    <script src="{{asset('js/scrollup.js')}}"></script>
    <!-- Onepage Nav JS -->
    <script src="{{asset('js/onepage-nav.min.js')}}"></script>
    <!-- Easing JS -->
    <script src="{{asset('js/easing.js')}}"></script>
    <!-- Active JS -->
    <script src="{{asset('js/active.js')}}"></script>

    <script>
        Pusher.logToConsole = true;
    
        var pusher = new Pusher('fa96417cb58987caef94', {
          cluster: 'ap1'
        });
    </script>
    
    @yield('scripts')
    <script>
        $(document).on('click','.btn-delete',function(){
            let btn = $(this);
                let slug = btn.data('slug');
                let li = btn.parents('li');
                $.ajax({
                        url: "{{route('client.destroyCart')}}",
                        type: 'POST',
                        data:{
                            slug: slug,
                            _token: "{{csrf_token()}}"
                        },
                    })
                    .done(function(res){
                        li.remove();
                        $('.shopping-item .total > span.total-amount').html(res.total);
                        $('.shopping-item .dropdown-cart-header > span.total-count').html(res.num_product);
                        $('div.sinlge-bar.shopping > a.single-icon > span.total-count').html(res.num_product);
                });
        })
		function addToCart(event) {
			event.preventDefault();
			let urlCart = $(this).data('url');
			
			$.ajax({
				type: 'GET',
				url: urlCart,
				dataType: 'json',
				success: function(data) {
					if(data.code === 200){
						toastr.success(data.message);
					}
				},
				error: function() {

				}
			}).done(function(res){
                $('.shopping-item').html(res.header_component);
                $('div.sinlge-bar.shopping > a.single-icon > span.total-count').html(res.num_product);
            })
		}
        function addToCartQuantity(event) {
			event.preventDefault();
			let urlCart = $(this).data('url');
            let parent = $('div.quickview-content div.quantity')
            let addquantity = parent.find('input.add_quantity').val();
			
            
			$.ajax({
				type: 'GET',
				url: urlCart,
				dataType: 'json',
                data: {addquantity: addquantity},
				success: function(data) {
					if(data.code === 200){
						toastr.success(data.message);
					}
				},
				error: function() {

				}
			}).done(function(res){
                $('.shopping-item').html(res.header_component);
                $('div.sinlge-bar.shopping > a.single-icon > span.total-count').html(res.num_product);
            })
		}

		$(function(){
			$('.btn_add_to_cart').on('click', addToCart);
			$('.btn_add_to_cart_quantity').on('click', addToCartQuantity);
		});
	</script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".btn_update_quantity").click(function(e){
                let slug = $(this).data('slug');
                let type = parseInt($(this).data('type'));
                let tr = $(this).closest('tr');
                onChangeQuantity(slug, type, tr);
            });

            $("input.quantity").on('input', function() {
                let slug = $(this).data('slug');
                let type = parseInt($(this).data('type'));
                let tr = $(this).closest('tr');
                const value = $(this).val();

                if (value <= 0) {
                    $(this).val(1);
                }

                onChangeQuantity(slug, -1, tr, $(this).val());
            });

            $(".btn-delete-cart").click(function(){
                let btn = $(this);
                let slug = btn.data('slug');
                let tr = btn.parents('tr');
                $.ajax({
                        url: "{{route('client.destroyCart')}}",
                        type: 'POST',
                        data:{
                            slug: slug,
                            _token: "{{csrf_token()}}"
                        },
                    })
                    .done(function(res){
                        tr.remove();
                        $('.shopping-cart .total > span').html(res.total);
                        $('.shopping-item').html(res.header_component);
                        $('div.sinlge-bar.shopping > a.single-icon > span.total-count').html(res.num_product);
                        //$('tbody').html(res.cart_component);
                });
            });

            function onChangeQuantity(slug, type, tr, value = "") {
                const parent = tr;
                $.ajax({
                        url: "{{route('client.updateCart')}}",
                        type: 'GET',
                        data:{
                            slug: slug,
                            type: parseInt(type),
                            value: value,
                        },
                    })
                    .done(function(res){
                        parent.find('input.quantity').val(res.cart.quantity);
                        parent.find('td.sum').html(res.cart.sum_price);
                        $('.shopping-cart .total > span').html(res.total);
                        $('.shopping-item').html(res.header_component);
                });
            }

            $(".btn_quantity").click(function(e){
                let slug = $(this).data('slug');
                let type = parseInt($(this).data('type'));
                let parent = $('div.quickview-content div.quantity')
                let quantity = parent.find('input.add_quantity').val();

                switch (type) {
                    case 0:
                        quantity--;
                        if (quantity <= 0) {
                           quantity = 1;
                        }
                        break;
                    case 1:
                        quantity++;
                        if (quantity >= 100) {
                           quantity = 100;
                        }
                        break;
                }
                parent.find('input.add_quantity').val(quantity);
            });


        });
    </script>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
        <df-messenger
        intent="WELCOME"
        chat-title="ChatBoxTKhome"
        agent-id="6b092ba0-efdc-4a9a-9c26-92c3cc710272"
        language-code="vi"
        ></df-messenger>
</body>

</html>

