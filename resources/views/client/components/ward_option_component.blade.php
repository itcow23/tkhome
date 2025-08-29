<option value=" ">Xã/Phường</option>
@foreach ($wards as $item)
    <option value="{{$item->ward_id}}">{{$item->name}}</option>
@endforeach