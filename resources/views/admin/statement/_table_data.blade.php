@foreach($datas as $data)
    <tr>
        <td style="text-align: center;">{{ $data->day }}</td>
        <td style="text-align: left;">
            <a href="{{route('admin.invoice.view',['shop'=> $infos->shop,'deli_date'=> $data->day])}}"
               style="text-decoration:none;"
               target="_blank">
                {{ $infos->pocode_prefix.\Carbon\Carbon::parse($data->day)->isoFormat('YYMMDD') }}
            </a>
        </td>
        <td style="text-align: left;">Invoice</td>
        <td style="text-align: right;">{{ number_format($data->Total, 2) }}</td>
    </tr>
@endforeach


