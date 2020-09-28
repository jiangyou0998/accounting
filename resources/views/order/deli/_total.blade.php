<tr style='border-bottom:4px solid black'>
    <td></td>
    <td align='right'>總件數=</td>
    <td align='right' colspan='3' style='border-right:0px'>{{ $total->qty_total }}</td>

    <td align='right' colspan='2'>{{ $total->cat_name }} 金額=</td>
    <td align='right'>${{ number_format($total->total, 2) }}</td>
</tr>
