<form name="form_CaseUpdate" id="form2" action="itsupport.php" method="post">


    <table border="1" bordercolor="#ccc" cellspacing="0" cellpadding="0">
        <input type="hidden" id="updateID" name="updateID" value="">
        <tbody>

        <tr bgcolor="#CCFFFF">

            <td align="center" width="3%"><b>#</b></td>
            <td align="center" width="6%"><b>編號</b></td>

            <td align="center" width="10%"><b>維修單日期</b></td>

            <td align="center" width="8%"><b>分店/部門</b></td>
            <td align="center" width="5%"><b>緊急性</b></td>
            <td align="center" width="12%"><b>器材</b></td>
            <td align="center" width="14%"><b>求助事宜</b></td>
            <td align="center" width="7%"><b>機器號碼#</b></td>
            <td align="center" width="10%"><b>其他資料提供</b></td>
            <td align="center" width="6%"><b>上傳文檔</b></td>


            <td align="center" width="18%"><b></b></td>


        </tr>

        @foreach($unfinisheds as $unfinished)
        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>{{$loop->iteration}}</b></td>
            <td align="center">{{$unfinished->it_support_no}}</td>
            <td align="center" height="25">
                {{$unfinished->created_at}}                    (<font color="red">6</font>)
            </td>
            <td align="left" height="25">{{$unfinished->users->txt_name}}</td>
            <td align="center">高                </td>
            <td align="center">{{$unfinished->items->name}}</td>
            <td align="center">{{$unfinished->details->name}}</td>

            <td align="center">{{$unfinished->machine_code}}</td>
            @if($unfinished->other)
                <td data-toggle="popover" data-trigger="hover" title="{{$unfinished->it_support_no}}" data-content="{{$unfinished->other}}">
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
                <button type="button" class="open-modal" data-toggle="modal" data-target="#exampleModal" data-id="{{$unfinished->id}}" style="background-color:#ADFFAD;">補充資料
                </button>

                <button type="button" data-id="{{$unfinished->id}}" style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>
        @endforeach

        </tbody>
    </table>
</form>
