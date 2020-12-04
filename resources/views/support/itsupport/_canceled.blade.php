<form name="form_CaseUpdate" id="form2" action="itsupport.php" method="post">


    <table border="1" bordercolor="#ccc" cellspacing="0" cellpadding="0">
        <input type="hidden" id="updateID" name="updateID" value="">
        <tbody>

        <tr bgcolor="#CCFFFF">

            <td align="center" width="3%"><b>#</b></td>
            <td align="center" width="6%"><b>編號</b></td>

            <td align="center" width="14%"><b>維修單日期</b></td>
            <td align="center" width="13%"><b>取消時間</b></td>

            <td align="center" width="10%"><b>分店/用戶</b></td>
            <td align="center" width="5%"><b>緊急性</b></td>
            <td align="center" width="12%"><b>器材</b></td>
            <td align="center" width="12%"><b>求助事宜</b></td>
            <td align="center" width="7%"><b>機器號碼#</b></td>
            <td align="center" width="10%"><b>其他資料提供</b></td>
            <td align="center" width="6%"><b>上傳文檔</b></td>


        </tr>

        @foreach($allCanceled as $canceled)
        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>{{$loop->iteration}}</b></td>
            <td align="center">{{$canceled->it_support_no}}</td>
            <td align="center" height="25">
                {{\Carbon\Carbon::parse($canceled->created_at)->toDateString()}}(<span style="color: red; ">{{\Carbon\Carbon::parse($canceled->created_at)->diffInDays(\Carbon\Carbon::now())}}</span>)
            </td>
            <td align="center" height="25">
                {{\Carbon\Carbon::parse($canceled->updated_at)->toDateString()}}
            </td>
            <td align="center" height="25">{{$canceled->users->txt_name}}</td>
            <td align="center">{{$canceled->importance}}</td>
            <td align="center">{{$canceled->items->name}}</td>
            <td align="center">{{$canceled->details->name}}</td>

            <td align="center">{{$canceled->machine_code}}</td>
            @if($canceled->other)
                <td data-toggle="popover" data-trigger="hover" title="{{$canceled->it_support_no}}" data-content="{{$canceled->other}}">
                    <span>
                    {{\Illuminate\Support\Str::limit($canceled->other,8)}}
                    </span>
                </td>
            @else
                <td></td>
            @endif

            <td bgcolor="#ffffff">
                <table>
                    <tbody>
                        <tr>
                            @if($canceled->file_path)
                                <a href="{{$canceled->file_path}}" target="_blank">附檔</a>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </td>



        </tr>
        @endforeach

        </tbody>
    </table>
</form>
