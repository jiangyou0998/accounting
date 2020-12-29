<!doctype html>
<html lang="en">
<head>
    <title> - King Bakery</title>
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
    <label class="layui-form-label-col">{{$repair->repair_project_no}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">分店/部門</label>
    <label class="layui-form-label-col">{{$repair->users->txt_name}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">緊急性</label>
    <label class="layui-form-label-col">{{$repair->importance}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">求助事宜</label>
    <label class="layui-form-label-col">{{$repair->items->name}} - {{$repair->details->name}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">#機器號碼</label>
    <label class="layui-form-label-col">{{$repair->machine_code}}</label>
</div>

<hr style="width:98%; margin:8px auto;">

<!-- 表單開始 -->
<form class="layui-form" action="{{route('repair.update',$repair->id)}}" method="POST">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">跟進結果</label>
        <div class="layui-input-block">
            <textarea name="comment" placeholder="请输入内容" class="layui-textarea">{{$repair->comment}}</textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">完成時間</label>
        <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
            <input readonly type="text" class="layui-input" id="cDate" name="cDate" autocomplete="off" value="{{$repair->complete_date}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">到店時間</label>
        <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
            <input type="text" class="layui-input" id="start" name="start" value="{{$repair->finished_start_time}}" autocomplete="off"  required lay-verify="required">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">離開時間</label>
        <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
            <input type="text" class="layui-input" id="end" name="end" value="{{$repair->finished_end_time}}" autocomplete="off" required lay-verify="required">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">維修員</label>
        <div class="layui-input-block">
            <input type="text" name="staff" value="{{$repair->handle_staff}}" required lay-verify="required" placeholder="維修員" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">已完成</label>
        <div class="layui-input-block">
            <input type="checkbox" name="complete" lay-skin="switch" lay-filter="switchTest" lay-text="已完成|未完成">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>


</form>
<!-- 表單結束 -->

<hr style="width:98%; margin:8px auto;">

<div class="layui-form-item">
    <label class="layui-form-label">最後更新</label>
    <label class="layui-form-label-col">{{$repair->updated_at}}</label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">負責人</label>
    <label class="layui-form-label-col">{{$repair->users->txt_name}}</label>
</div>

<script src="/layui/layui.js"></script>
<script>
    layui.use(['form', 'laydate'], function(){
        var form = layui.form
            ,laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#cDate' //指定元素
        });

        //时间选择器
        laydate.render({
            elem: '#start'
            ,format: 'HH:mm'
            ,type: 'time'
        });

        laydate.render({
            elem: '#end'
            ,format: 'HH:mm'
            ,type: 'time'
        });
    });
</script>

<!-- END  -->

</body>
</html>
