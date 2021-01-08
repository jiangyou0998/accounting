<tr>
    <td>{{ $detail->product_no }}</td>
    <td>{{ $detail->itemName }}</td>

    <td align="right">{{ $detail->RB_total != 0 ? $detail->RB_total :'/' }}</td>

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
