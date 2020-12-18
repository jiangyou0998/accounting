<tr bgcolor="#FFFFFF">
    <td class="data style3" align="center">
        {{$loop->iteration}}
    </td>
    @foreach($data->toArray() as $k => $v)

        @if($loop->iteration == 1)
            <td class="data style3" align="center">{{$v}}</td>
        @endif

        @if($loop->iteration == 2)
            <td class="data style3" align="center" style="max-width:130px; min-width:130px; width:130px;">{{$v}}</td>
        @endif

        @if($loop->iteration == 3)
            <td class="data style6" align="center" bgcolor="#FFFFCC">{{$v}}</td>
        @endif

        @if($loop->iteration > 3)
            <td class="data style6" align="center">

{{--                @if($v != "0")--}}
{{--                    {{$v}}--}}
{{--                @endif--}}
                {{$v !== "0" ? $v : ""}}

            </td>
        @endif
    @endforeach
</tr>
