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
@foreach($allData as $checkdatas)
    @foreach($checkdatas as $datas)
        @foreach($datas as $data)
            {{--    每13個一頁,生成表頭和頂部--}}
            @if(($loop->index % 13) == 0)

                <div class="page">
                    <div width="100%">


                        <div width="100%">
                            <div width="50%" align="left">列印時間: {{\Carbon\Carbon::now()->toDateTimeString()}}</div>
                            <div width="50%" align="right">{{$datas->page}}</div>
                        </div>

                        <br/>
                        <div class="box">

                            <span class="style1">{{$datas->title}}</span>
                            <span class="style1"
                            >出貨日期：
                            {{$datas->deli_date}} ({{\Carbon\Carbon::parse($datas->deli_date)->isoFormat('dd')}})
                        </span>
                        </div>


                        <hr/>

                        <table border="1" cellpadding="0" cellspacing="0">
                            @include('admin.order_print._table_head')
                            @endif
                            {{--    加載數據--}}
                            @include('admin.order_print._table_data')

                            {{--    第14個,生成打印分頁div--}}
                            @if(($loop->index % 13) == 12 || $loop->last)
                        </table>
                        <div style="page-break-after:always;"></div>
                    </div>
                </div>
            @endif
        @endforeach

    @endforeach

@endforeach


</body>
