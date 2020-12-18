<tr bgcolor="#CCFFFF">
    <th align="center" style="width:30px; height:40px;"><strong>#</strong></th>
    @foreach($data->toArray() as $key => $v)
        <th align="center" style="width:90px"><strong>{{$key}}</strong></th>
    @endforeach

</tr>
