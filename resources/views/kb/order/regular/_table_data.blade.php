@foreach($countArr as $deli_date => $countItems)
<tr class="bg-blue">
    <td width="15%">
        <a href="/admin/production_order/print?cat_id=3&deli_date={{$deli_date}}" target="_blank">
        {{\Carbon\Carbon::parse($deli_date)->isoFormat('M月DD日(dd)')}}
        </a>
    </td>
    @foreach($countItems as $key =>$count)
        <td @if($count != 0) class="bg-warning" @endif>
            <a href="{{route('cart',['shop' => $key,'dept' => 'D','deli_date' => $deli_date])}}"
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
