<tr bgcolor="#CCFFFF">
    <th align="center" style="width:30px; height:40px;"><strong>#</strong></th>
    @foreach($headings as $key => $v)
        @if(in_array($key,$heading_shops) || $loop->iteration < 4)
            <th align="center" style="width:90px"><strong>{{$key}}</strong></th>
        @endif
    @endforeach

</tr>
