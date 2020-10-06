
<html>
<head>
    <META name="ROBOTS" content="NOINDEX,NOFOLLOW">
        <title>內聯網</title>
{{--        <link href="/js/My97DatePicker/skin/WdatePicker.css" rel="stylesheet" type="text/css">--}}
{{--        <script src="/js/jquery.min.js"></script>--}}
{{--        <script src="/js/My97DatePicker/WdatePicker.js"></script>--}}
{{--        <script src="/js/parser.js"></script>--}}
        <style>
            <!--
            .style1 {
                font-size: 34px
            }

            .style3 {
                font-size: 16px;
            }

            .style6 {
                font-size: 22px;
                font-weight: bold;
            }

            .data {
                max-height: 32px;
                height: 32px;
                min-height: 32px;
                vertical-align: middle;
                padding: 4px;
            }

            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #FAFAFA;
            }

            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }

            .page {
                width: 297mm;
                min-height: 203mm;
                padding: 4mm;
                background: white;
            }

            .box {
                width: 100%;
                /* 因为 content 会另起一行，影响样式的话，height 设置为具体的值可以避免高度变高的情况 */
                /* 设置元素两端对齐 */
                text-align: justify;
            }

            /* 这里的伪元素一定要加上，不然span元素不能两端对齐 */
            .box:after {
                content: "";
                display: inline-block;
                overflow: hidden;
                width: 100%;
            }

            .box span {
                height: 50px;
                /* 设置盒子为行内块 */
                display: inline-block;
                /* 设置盒子内元素水平居中 */
                text-align: center;
                /* 设置盒子内容垂直居中 */
                line-height: 50px;
            }

            -->
        </style>

<body>

<div class="page">
    <div width="100%">



        <div width="100%">
            <div width="50%" align="left">列印時間: {{\Carbon\Carbon::now()->toDateTimeString()}}</div>
            <div width="50%" align="right">1/2</div>
        </div>

        <br/>
        <div class="box">

            <span class="style1">{{$checkInfos->title}}</span>
            <span class="style1"
>出貨日期：
                            {{$checkInfos->deli_date}} ({{\Carbon\Carbon::parse($checkInfos->deli_date)->isoFormat('dd')}})
                        </span>
        </div>



        <hr/>
        <table border="1" cellpadding="0" cellspacing="0">
            @include('admin.order_print._table_head')

                @foreach($datas as $data)

                    @include('admin.order_print._table_data')

                @endforeach




{{--        <div style="page-break-after:always;"></div>--}}
{{--    </div>--}}

{{--    <div class="page">--}}
{{--        <div width="100%">--}}



{{--            <div width="100%">--}}
{{--                <div width="50%" align="left">列印時間: 2020-08-12 10:30</div>--}}
{{--                <div width="50%" align="right">2/2</div>--}}
{{--            </div>--}}

{{--            <br/>--}}
{{--            <span class="style1">麵包部 - 生包 - 麵粒、酥 </span>--}}
{{--            <span class="style1"--}}
{{--                  style="margin-left:400px;">出貨日期：--}}
{{--                            1/8/2020 (六)--}}
{{--                        </span>--}}
{{--            <hr/>--}}
{{--            <table border="1" cellpadding="0" cellspacing="0">--}}

            </table>
            <div style="page-break-after:always;"></div>
        </div>
</body>
