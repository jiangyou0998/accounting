<tr bgcolor="#CCFFFF">
    <th align="center" style="width:30px; height:40px;"><strong>#</strong></th>
    <th align="center" style="width:90px"><strong>編號</strong></th>
    <th align="center" style="width:90px"><strong>名稱</strong></th>
    @foreach($headings as $key => $v)
        @if(in_array($key,$heading_shops) || $key === 'Total' )
            <th align="center" style="width:90px"><strong>{{$key}}</strong></th>
        @endif
    @endforeach

</tr>
