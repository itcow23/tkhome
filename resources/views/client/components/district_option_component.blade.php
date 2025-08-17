<option value=" ">Quận/Huyện</option>
@foreach ($districts as $item)
    <option value="{{$item->district_id}}">{{$item->name}}</option>
@endforeach