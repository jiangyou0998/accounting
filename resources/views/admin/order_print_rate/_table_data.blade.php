<tr bgcolor="#FFFFFF">
    <td class="data style3" align="center">
        {{$loop->iteration}}
    </td>
    <td class="data style3" align="center">{{$productArr[$data->id][0]['product_no']}}</td>
    <td class="data style3" align="center">{{$productArr[$data->id][0]['product_name']}}</td>
    @foreach($data->toArray() as $k => $v)



        @if($loop->iteration == 1)
            <td class="data style6" align="center" bgcolor="#FFFFCC">{{$v}}</td>
        @endif

        @continue($loop->iteration == 2)

        @if($loop->iteration > 2 && in_array($k,$heading_shops))
            <td class="data style6" align="center">

                @if($v != "0")
                    {{$v}}
                @endif

            </td>
        @endif
    @endforeach
</tr>
