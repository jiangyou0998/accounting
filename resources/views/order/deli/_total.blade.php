<tr style='border-bottom:4px solid black'>
    <td></td>
    <td align='right'>總件數=</td>
    @if(request()->group === 'RB')
        <td align='right' colspan='{{ count(['RB']) + 2 }}' style='border-right:0px'>{{ $total->qty_total }}</td>
    @else
        <td align='right' colspan='{{ count(config('dept.symbol')) + 2 }}' style='border-right:0px'>{{ $total->qty_total }}</td>
    @endif


    <td align='right' colspan='1'>{{ $total->cat_name }} 金額=</td>
    <td align='right'>${{ number_format($total->total, 2) }}</td>
</tr>
