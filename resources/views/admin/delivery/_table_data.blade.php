{{--@foreach($details as $detail)--}}
{{--    @if($total->cat_id == $detail->cat_id)--}}
        <tr>
            <td align="left">{{ $detail->product_no }}</td>
            <td align="left">{{ $detail->itemName }}</td>

            @if($detail->qty == $detail->qty_received)
                <td align="right">{{ number_format($detail->qty_received,0) }}&nbsp;{{ $detail->UoM }}</td>
            @else
                <td align="right" style="color:red;">{{ number_format($detail->qty_received,0) }}&nbsp;{{ $detail->UoM }}</td>
            @endif

        </tr>
{{--    @endif--}}
{{--@endforeach--}}


