<!doctype html>
<html lang="en">
<head>
    <title> - Ryoyu Bakery</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <link rel="stylesheet" href="/layui/css/layui.css" media="all">
    <style>
        body{
            width: 500px;
            height:600px;

        }
    </style>
</head>

<body>
<!-- BEGIN -->

<hr>

<div class="layui-form-item">
    <label class="layui-form-label">編號</label>
    <label class="layui-form-label-col">{{$itsupport->it_support_no}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">分店/部門</label>
    <label class="layui-form-label-col">{{$itsupport->users->txt_name}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">緊急性</label>
    <label class="layui-form-label-col">中</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">求助事宜</label>
    <label class="layui-form-label-col">{{$itsupport->items->name}} - {{$itsupport->details->name}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">#機器號碼</label>
    <label class="layui-form-label-col">{{$itsupport->machine_code}}</label>
</div>

<hr style="width:98%; margin:8px auto;">


<div class="layui-form-item layui-form-text">
    <label class="layui-form-label">跟進結果</label>
    <label class="layui-form-label-col">{{$itsupport->comment}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">完成時間</label>
    <label class="layui-form-label-col">{{$itsupport->complete_date}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">到店時間</label>
    <label class="layui-form-label-col">{{$itsupport->finished_start_time}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">離開時間</label>
    <label class="layui-form-label-col">{{$itsupport->finished_end_time}}</label>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">維修員</label>
    <label class="layui-form-label-col">{{$itsupport->handle_staff}}</label>
</div>


<hr style="width:98%; margin:8px auto;">

<div class="layui-form-item">
    <label class="layui-form-label">最後更新</label>
    <label class="layui-form-label-col">{{$itsupport->updated_at}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">負責人</label>
    <label class="layui-form-label-col">{{$itsupport->users->txt_name}}</label>
</div>

<!-- END  -->

</body>
</html>
