{{--表頭--}}
<tr>
    <td width="125px" align="center" bgcolor="#CCCCCC"><strong>貨品</strong></td>
    <td width="75px" align="center" bgcolor="#CCCCCC"><strong>單價($)</strong></td>
    <td width="75px" align="center" bgcolor="#CCCCCC"><strong>落單</strong></td>
    <td width="75px" align="center" bgcolor="#CCCCCC"><strong>派貨</strong></td>
    <td width="434px" align="center" bgcolor="#CCCCCC">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td width="24%" align="center"><strong>實收</strong></td>
                @foreach($deptArrWithName as $dept => $name)
                    <td width="15%" align="center">{{$name}}</td>
                @endforeach

{{--                <td width="19%" align="center">樓面</td>--}}
            </tr>
            </tbody>
        </table>
    </td>
    <td width="160px" align="center" bgcolor="#CCCCCC">差異原因</td>
</tr>
