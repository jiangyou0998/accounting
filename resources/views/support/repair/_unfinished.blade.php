


    <table border="1" bordercolor="#ccc" cellspacing="0" cellpadding="0">
        <input type="hidden" id="updateID" name="updateID" value="">
        <tbody>

        <tr bgcolor="#CCFFFF">

            <td align="center" width="3%"><b>#</b></td>
            <td align="center" width="7%"><b>編號</b></td>

            <td align="center" width="13%"><b>最近更新日期</b></td>

            <td align="center" width="10%"><b>分店/用戶</b></td>
            <td align="center" width="5%"><b>緊急性</b></td>
            <td align="center" width="7%"><b>位置</b></td>
            <td align="center" width="7%"><b>維修項目</b></td>
            <td align="center" width="7%"><b>求助事宜</b></td>
            <td align="center" width="7%"><b>機器號碼#</b></td>
            <td align="center" width="6%"><b>負責人</b></td>
            <td align="center" width="10%"><b>其他資料提供</b></td>
            <td align="center" width="6%"><b>上傳文檔</b></td>


            <td align="center" width="15%"><b></b></td>


        </tr>

        @foreach($allUnfinished as $unfinished)
        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>{{$loop->iteration}}</b></td>
            <td align="center">{{$unfinished->repair_project_no}}</td>
            <td align="center" height="25">
                {{\Carbon\Carbon::parse($unfinished->updated_at)->toDateString()}}(<span style="color: red; ">{{\Carbon\Carbon::parse($unfinished->updated_at)->diffInDays(\Carbon\Carbon::now())}}</span>)
            </td>
            <td align="center" height="25">{{$unfinished->users->txt_name ?? ''}}</td>
            <td align="center">{{$unfinished->importance}}</td>
            <td align="center">{{$unfinished->locations->name ?? ''}}</td>
            <td align="center">{{$unfinished->items->name ?? ''}}</td>
            <td align="center">{{$unfinished->details->name ?? ''}}</td>

            <td align="center">{{$unfinished->machine_code}}</td>
            <td align="center">{{$unfinished->contact_person}}</td>
            @if($unfinished->other)
                <td data-toggle="popover" data-trigger="hover" title="{{$unfinished->repair_project_no}}" data-content="{{$unfinished->other}}">
                    <span>
                    {{\Illuminate\Support\Str::limit($unfinished->other,8)}}
                    </span>
                </td>
            @else
                <td></td>
            @endif

            <td bgcolor="#ffffff">
                <table>
                    <tbody>
                        <tr>
                            @if($unfinished->file_path)
                                <a href="{{$unfinished->file_path}}" target="_blank">附檔</a>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </td>

            <td align="center" style="padding:5px;">
{{--                <button type="button" class="open-layui" data-id="{{$unfinished->id}}" style="background-color:#ADFFAD;">補充資料--}}
{{--                </button>--}}

                <button type="button" class="delete-btn" data-id="{{$unfinished->id}}" data-no="{{$unfinished->repair_project_no}}" style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>
        @endforeach

        </tbody>
    </table>

