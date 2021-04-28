{{--@foreach($details as $detail)--}}
{{--    @if($total->cat_id == $detail->cat_id)--}}
        <tr>
            <td align="left">{{ $detail->product_no }}</td>
            <td align="left">{{ $detail->itemName }}</td>

            @if($detail->qty == $detail->qty_received)
                <td align="right">{{ number_format($detail->qty_received,0) }}&nbsp;{{ $detail->UoM }}</td>
            @else
                {{-- R單--}}
                <td align="right" style="color:red;">{{ number_format($detail->qty_received,2) }}&nbsp;{{ $detail->UoM }}</td>
            @endif
{{--            <td align="center">{{ $detail->UoM }}</td>--}}
            <td align="right">${{ $detail->default_price }}</td>
            {{--    <td align="right">$0.00</td>--}}
            <td align="right">
                @if(request()->type == 'CUR')
                    ${{number_format(abs($detail->qty_received * $detail->default_price), 2)}}
                @else
                    ${{number_format($detail->qty_received * $detail->default_price, 2)}}
                @endif
            </td>
        </tr>
{{--    @endif--}}
{{--@endforeach--}}


