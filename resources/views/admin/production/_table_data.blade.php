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
             onclick="viewPrint({{$cat->id}},2)"
             style="cursor:pointer;"></td>
    <td><input class="downselect" type="checkbox" value="7" style="zoom:180%;"></td>
</tr>

