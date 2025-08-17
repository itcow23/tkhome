<li data-value="" class="option selected focus">Xã/phường</li>
@foreach ($wards as $item)
    <li data-value="{{$item->wards_id}}" class="option">{{$item->name}}</li>
@endforeach