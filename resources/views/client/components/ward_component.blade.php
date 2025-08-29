<li data-value="" class="option selected focus">Xã/phường</li>
@foreach ($wards as $item)
    <li data-value="{{$item->ward_id}}" class="option">{{$item->name}}</li>
@endforeach