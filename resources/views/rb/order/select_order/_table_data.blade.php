@foreach($countArr as $deli_date => $countItems)
<tr class="bg-blue">
    <td width="15%">{{\Carbon\Carbon::parse($deli_date)->isoFormat('M月DD日(dd)')}}</td>
    @foreach($countItems as $key =>$count)
        <td @if($count != 0) class="bg-warning" @endif>
            <a href="{{route('cart',['shop' => $key,'dept' => request()->dept,'deli_date' => $deli_date])}}"
            target="_blank">
                @if($count == 0)
                    未下單
                @else
                    {{$count}}
                @endif
            </a>
            <div>

                <small>{{$shop_names[$key]}} {{\Carbon\Carbon::parse($deli_date)->day}}</small>
            </div>
        </td>
    @endforeach
<tr>
@endforeach
