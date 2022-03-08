{{--<th scope="col">#</th>--}}
{{--<th scope="col">日期</th>--}}
{{--<th scope="col">位置</th>--}}
{{--<th scope="col">維修項目</th>--}}
{{--<th scope="col">求助事宜</th>--}}
{{--<th scope="col">跟進結果</th>--}}
{{--<th scope="col">完成進度</th>--}}

<!doctype html>
<html lang="en">
<head>
    <title> 維修下單 - King Bakery</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="/layui/css/layui.css" media="all">
    <style>
        body {
            width: 500px;
            height: 600px;

        }
    </style>
</head>

<body>
<!-- BEGIN -->

<hr>

<div class="layui-form-item">
    <label class="layui-form-label">編號</label>
    <label class="layui-form-label-col"></label>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">分店/用戶</label>
    <label class="layui-form-label-col"></label>
</div>


<hr style="width:98%; margin:8px auto;">

<!-- 表單開始 -->
<form class="layui-form" action="" method="POST">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">跟進結果</label>
        <div class="layui-input-block">
            <textarea name="comment" placeholder="请输入内容" class="layui-textarea"></textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">完成時間</label>
        <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
            <input readonly type="text" class="layui-input" id="cDate" name="cDate" autocomplete="off"
                   value="">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">到店時間</label>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" class="layui-input"
                       id="start_hour" name="start_hour" value=""
                       min="0" max="23"
                       autocomplete="off" required lay-verify="required|number|hour">
            </div>
            <div class="layui-form-mid">時</div>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" class="layui-input"
                       id="start_minute" name="start_minute" value=""
                       min="0" max="59"
                       autocomplete="off" required lay-verify="required|number|minute">
            </div>
            <div class="layui-form-mid">分</div>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">離開時間</label>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" class="layui-input"
                       id="end_hour" name="end_hour" value=""
                       min="0" max="23"
                       autocomplete="off" required lay-verify="required|number|hour">
            </div>
            <div class="layui-form-mid">時</div>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" class="layui-input"
                       id="end_minute" name="end_minute" value=""
                       min="0" max="59"
                       autocomplete="off" required lay-verify="required|number|minute">
            </div>
            <div class="layui-form-mid">分</div>
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">維修員</label>
        <div class="layui-input-block">
            <input type="text" name="staff" value="" required lay-verify="required"
                   placeholder="維修員" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">維修費用</label>
        <div class="layui-input-block">
            <input type="number" name="fee" value="" min="0" required lay-verify="required"
                   placeholder="$" autocomplete="off" class="layui-input">
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

{{--<div class="layui-form-item">--}}
{{--    <label class="layui-form-label">最後更新</label>--}}
{{--    <label class="layui-form-label-col">{{$repair->updated_at}}</label>--}}
{{--</div>--}}

{{--<div class="layui-form-item">--}}
{{--    <label class="layui-form-label">最後操作</label>--}}
{{--    <label class="layui-form-label-col">{{$repair->users->txt_name}}</label>--}}
{{--</div>--}}

<script src="/layui/layui.js"></script>
<script>
    layui.use(['form', 'laydate'], function () {
        var form = layui.form
            , laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#cDate' //指定元素
        });

        form.verify({
            hour: function (value, item) { //value：表单的值、item：表单的DOM对象

                if (/^(0?[0-9]|1[0-9]|2[0-3])$/.test(value) === false) {
                    return '小時數輸入格式不正確';
                }

            }

            , minute: function (value, item) { //value：表单的值、item：表单的DOM对象

                if (/^(0?[0-9]|[1-5][0-9])$/.test(value) === false) {
                    return '分鐘數輸入格式不正確';
                }

            }
        });

    });
</script>

<!-- END  -->

</body>
</html>
