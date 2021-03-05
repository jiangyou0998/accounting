@foreach($details as $detail)
    @if($total->cat_id == $detail->cat_id)
        <tr>
            <td>{{ $detail->product_no }}</td>
            <td>{{ $detail->itemName }}</td>

            @if(strtolower(request()->group) === 'rb')
                @foreach(['RB'] as $dept)
                    <td align="right">{{ $detail->{$dept.'_total'} != 0 ? $detail->{$dept.'_total'} :'/' }}</td>
                @endforeach
            @else
                @foreach(config('dept.symbol') as $dept)
                    <td align="right">{{ $detail->{$dept.'_total'} != 0 ? $detail->{$dept.'_total'} :'/' }}</td>
                @endforeach
            @endif

            {{--    <td align="right">{{ $detail->R_total != 0 ? $detail->R_total :'/' }}</td>--}}
            {{--    <td align="right">{{ $detail->B_total != 0 ? $detail->B_total :'/' }}</td>--}}
            {{--    <td align="right">{{ $detail->K_total != 0 ? $detail->K_total :'/' }}</td>--}}
            {{--    <td align="right">{{ $detail->F_total != 0 ? $detail->F_total :'/' }}</td>--}}

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


