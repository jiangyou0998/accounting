
    <table border="1" bordercolor="#ccc" cellspacing="0" cellpadding="0">
        <input type="hidden" id="updateID" name="updateID" value="">
        <tbody>

        <tr bgcolor="#CCFFFF">

            <td align="center" width="3%"><b>#</b></td>
            <td align="center" width="6%"><b>編號</b></td>

            <td align="center" width="14%"><b>最近更新日期</b></td>

            <td align="center" width="10%"><b>分店/用戶</b></td>
            <td align="center" width="5%"><b>緊急性</b></td>
            <td align="center" width="12%"><b>器材</b></td>
            <td align="center" width="12%"><b>求助事宜</b></td>
            <td align="center" width="7%"><b>機器號碼#</b></td>
            <td align="center" width="10%"><b>其他資料提供</b></td>
            <td align="center" width="6%"><b>上傳文檔</b></td>


            <td align="center" width="15%"><b></b></td>


        </tr>

        @foreach($allFinished as $finished)
        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>{{$loop->iteration}}</b></td>
            <td align="center">{{$finished->it_support_no}}</td>
            <td align="center" height="25">
                {{\Carbon\Carbon::parse($finished->updated_at)->toDateString()}}(<span style="color: red; ">{{\Carbon\Carbon::parse($finished->updated_at)->diffInDays(\Carbon\Carbon::now())}}</span>)
            </td>
            <td align="center" height="25">{{$finished->users->txt_name}}</td>
            <td align="center">{{$finished->importance}}</td>
            <td align="center">{{$finished->items->name}}</td>
            <td align="center">{{$finished->details->name}}</td>

            <td align="center">{{$finished->machine_code}}</td>
            @if($finished->other)
                <td data-toggle="popover" data-trigger="hover" title="{{$finished->it_support_no}}" data-content="{{$finished->other}}">
                    <span>
                    {{\Illuminate\Support\Str::limit($finished->other,8)}}
                    </span>
                </td>
            @else
                <td></td>
            @endif

            <td bgcolor="#ffffff">
                <table>
                    <tbody>
                        <tr>
                            @if($finished->file_path)
                                <a href="{{$finished->file_path}}" target="_blank">附檔</a>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" class="open-layui-finish" data-id="{{$finished->id}}" style="background-color:#FFFFAD;">跟進資料
                </button>
            </td>

        </tr>
        @endforeach

        </tbody>
    </table>

