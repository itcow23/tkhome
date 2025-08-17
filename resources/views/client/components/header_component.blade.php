@php
    $total = 0;
    $num_product=count($carts);
@endphp
    <div class="dropdown-cart-header">
        <span class="total-count">{{$num_product}}</span>
        <span> Items</span>
        <a href="{{route('client.cart')}}">View Cart</a>
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
            <span>Total</span>
            <span class="total-amount">@php
                echo currency_format($total);
            @endphp</span>
        </div>
        <a href="{{route('client.checkout')}}" class="btn animate">Checkout</a>
    </div>
