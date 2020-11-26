<!doctype html>
<html lang="en">
<head>
    <title> - Ryoyu Bakery</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>

    {{--<script src="/js/custom.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<!-- BEGIN -->
<table style="width:100%" cellpadding="4px">
    <tr>
        <td style="width:30%">編號</td>
        <td>{{$itsupport->it_support_no}}</td>
    </tr>
    <tr>
        <td>報告日期</td>
        <td>{{$itsupport->created_at}}</td>
    </tr>
    <tr>
        <td>分店/部門</td>
        <td>{{$itsupport->users->txt_name}}</td>
    </tr>
    <tr>
        <td>緊急性</td>
        <td>中        </td>
    </tr>
    <tr>
        <td>求助事宜</td>
        <td>{{$itsupport->items->name}} - {{$itsupport->details->name}}</td>
    </tr>
    <tr>
        <td>#機器號碼</td>
        <td>{{$itsupport->machine_code}}</td>
    </tr>
</table>
<hr style="width:98%; margin:8px auto;">
<form action="{{route('itsupport.update',$itsupport->id)}}" method="POST">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    <input type="hidden" name="id" value="101"/>
    <input type="hidden" name="action" value="update"/>
    <table style="width:100%" cellpadding="4px">
        <tr>
            <td style="width:30%; vertical-align:top;">跟進結果</td>
        </tr>

        <tr>
            <td colspan="2"><textarea style="margin: 0px; width: 100%; height: 100px; resize: none;"
                                      name="comment">{{$itsupport->comment}}</textarea></td>
        </tr>

        <tr>
            <td style="width:30%">完成日期</td>
            <td>
                <input name="cDate" onclick="WdatePicker();" size="10"
                       value="{{\Carbon\Carbon::now()->toDateString()}}"/>
            </td>
        </tr>

        <tr>
            <td style="width:30%">到店日期</td>
            <td>
                <input name="start" onclick="WdatePicker({dateFmt:'H:mm'});" size="13"
                       autocomplete="off" value="{{$itsupport->finished_start_time}}"/>-
                <input name="end" onclick="WdatePicker({dateFmt:'H:mm'});" size="13"
                       autocomplete="off" value="{{$itsupport->finished_end_time}}"/>
            </td>
        </tr>

        <tr>
            <td style="width:30%">維修員</td>
            <td>
                <input name="staff" size="10" value="{{$itsupport->handle_staff}}"/>
            </td>
        </tr>

        <tr>
            <td style="width:30%">已完成</td>
            <td>
                <input type="hidden" name="complete" value="0">
                <input type="checkbox" name="complete" value="1">
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2"><input type="submit" value="提交" style="font-size:18px;"></td>
        </tr>
    </table>
</form>
<hr style="width:98%; margin:8px auto;">
<table style="width:100%" cellpadding="4px">
    <tr>
        <td style="width:30%">最後更新</td>
        <td></td>
    </tr>
    <tr>
        <td style="width:30%">負責人</td>
        <td></td>
    </tr>
</table>

<!-- END  -->

</body>
</html>
