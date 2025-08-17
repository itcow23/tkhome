    @php
        $total =0;
    @endphp
    @foreach ($carts as $item)
        <tr>
            <td class="image" data-title="No"><img src="{{asset('products')}}/{{$item['img']}}" alt="#"></td>
            <td class="product-des" data-title="Description">
                <p class="product-name"><a href="#">{{$item['name']}}</a></p>
                {{-- <p class="product-des">Maboriosam in a tonto nesciung eget  distingy magndapibus.</p> --}}
            </td>
            <td class="price" data-title="Price"><span class="span-price">{{currency_format($item['price'])}}</span></td>
            <td class="qty" data-title="Qty"><!-- Input Order -->
                <div class="input-group">
                    <div class="button minus">
                        <button type="button" class="btn btn-primary btn-number btn_update_quantity" data-slug="{{$item['slug']}}" data-type="0" >
                            <i class="ti-minus"></i>
                        </button>
                    </div>
                        <input data-slug="{{$item['slug']}}" data-type="-1" type="text" name="quantity" class="input-number quantity" data-min="1" data-max="100" value="{{$item['quantity']}}">
                    <div class="button plus">
                        <button type="button" class="btn btn-primary btn-number btn_update_quantity" data-slug="{{$item['slug']}}" data-type="1" >
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>
                <!--/ End Input Order -->
            </td>
            <td class="sum" data-title="Total"><span>
                    @php
                        $sum = $item['price'] * $item['quantity'];
                        $total += $sum;
                        echo currency_format($sum);
                    @endphp
                </span></td>
            <td class="action" data-title="Remove">
                <a href="#" class="btn-delete" data-slug="{{$item['slug']}}"><i class="ti-trash remove-icon"></i></a>
            </td>
        </tr>	
    @endforeach