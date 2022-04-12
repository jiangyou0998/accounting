@foreach($details as $detail)
    @if($total->user_id == $detail->user_id)
        <tr>
            <td>{{ $detail->product_no }}</td>
            <td>{{ $detail->itemName }}</td>

            <td align="right">{{ $detail->CU_total != 0 ? $detail->CU_total :'/' }}</td>

            @if($detail->qty == $detail->qty_received)
                <td align="right">{{ $detail->qty_received }}</td>
            @else
                <td align="right" style="color:red;">{{ $detail->qty_received }}</td>
            @endif
            <td align="center">{{ $detail->UoM }}</td>
            <td align="right">${{ $detail->default_price }}</td>
            {{--    <td align="right">$0.00</td>--}}
            <td align="right">${{number_format($detail->qty_received * $detail->default_price, 2)}}</td>
        </tr>
    @endif
@endforeach

