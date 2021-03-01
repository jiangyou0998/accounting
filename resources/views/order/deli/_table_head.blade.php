<tr align="center">
    <th style="font-weight:bold;" width="12%">編號</th>
    <th style="font-weight:bold;" width="18%">貨名</th>
{{--    <th style="font-weight:bold;" width="12%" align="center">下單數量</th>--}}
{{--    <th style="font-weight:bold;" width="12%" align="center">數量</th>--}}

    @if(strtolower(request()->group) === 'rb')
        @foreach(['RB'] as $dept)
            <th style="font-weight:bold;" width="18%" align="center">蛋撻王工場</th>
        @endforeach
    @else
        @foreach(config('dept.symbol_and_name') as $dept => $name)
            <th style="font-weight:bold;" width="8%" align="center">{{$name}}</th>
        @endforeach
    @endif


{{--    <th style="font-weight:bold;" width="8%" align="center">烘焙</th>--}}
{{--    <th style="font-weight:bold;" width="8%" align="center">水吧</th>--}}
{{--    <th style="font-weight:bold;" width="8%" align="center">廚房</th>--}}
{{--    <th style="font-weight:bold;" width="8%" align="center">樓面</th>--}}

    <th style="font-weight:bold;" width="8%" align="center">收貨</th>
    <th style="font-weight:bold;" width="6%" align="center">單位</th>
    <th style="font-weight:bold;" width="20%" align="center">單價</th>
{{--    <th style="font-weight:bold;" width="10%" align="center">折扣</th>--}}
    <th style="font-weight:bold;" width="12%" align="center">實額</th>
</tr>
