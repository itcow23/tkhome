<option value=" ">Xã/Phường</option>
@foreach ($wards as $item)
    <option value="{{$item->wards_id}}">{{$item->name}}</option>
@endforeach