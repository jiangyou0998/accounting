<tr>
    <td>{{$loop->iteration}}</td>
    <!--                報告名稱-->
    <td>{{$cat->cat_name}}</td>
{{--    <!--                相隔日數-->--}}
{{--    <td>2日</td>--}}
{{--    <!--                報表時間-->--}}
{{--    <td>12:00</td>--}}
{{--    <!--				查看-->--}}
{{--    <td><img src="../images/clipboard.png"--}}
{{--             onclick="viewReport(7,2)"--}}
{{--             style="cursor:pointer;"></td>--}}
{{--    <!--               查看-->--}}
    <td><img src="../images/print.png"
             onclick="viewPrint({{$cat->id}})"
             style="cursor:pointer;">
    </td>
{{--    按比例--}}
    <td>
        @if($cat->cat_name == '方包')
            <img src="../images/print.png"
                 onclick="viewPrintRate({{$cat->id}})"
                 style="cursor:pointer;">
        @endif
    </td>
{{--    一車--}}
    <td>
        @if(in_array($cat->cat_name,['熟細包','熟大包']))
            <img src="../images/print.png"
                 onclick="viewPrint({{$cat->id}},1)"
                 style="cursor:pointer;">
        @endif
    </td>
{{--    二車--}}
    <td>
        @if(in_array($cat->cat_name,['熟細包','熟大包']))
            <img src="../images/print.png"
                 onclick="viewPrint({{$cat->id}},2)"
                 style="cursor:pointer;">
        @endif
    </td>

</tr>

