
            <li data-value="" class="option selected focus">Quận/Huyện</li>
            @foreach ($districts as $item)
                <li data-value="{{$item->district_id}}" class="option">{{$item->name}}</li>
            @endforeach
          
											

