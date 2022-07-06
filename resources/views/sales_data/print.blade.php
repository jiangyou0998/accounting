<html>
<head>
    <title> 2Cafe </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">

    {{--    標題欄： --}}
    <link rel="icon" href="/images/2cafe_title_logo.png" type="image/x-icon" />
    {{--    收藏夾：--}}
    <link rel="shortcut icon" href="/images/2cafe_title_logo.png" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap-4.1.2.min.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="/css/sweetalert2.min.css" id="theme-styles">

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/js/sweetalert2.min.js"></script>
    <script src="/js/jquery-3.3.1.min.js" ></script>
    <script src="/js/TweenMax.min.js"></script>

    {{--<script src="/js/custom.js"></script>--}}
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

</head>

<style>
    <!--
    .style1 {
        font-size: 34px
    }

    .style3 {
        font-size: 16px;
    }

    .style6 {
        font-size: 21px;
        /*font-weight: bold;*/
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

    .customize-border{
        border: 2px solid black;
    }

    .customize-border-top {
        border-top: 3px solid;
    }

    .sign-border-top {
        border-top: 3px solid;
    }

    .customize-border-bottom {
        border-bottom: 3px solid;
    }

    th td {
        border: 2px solid black;
    }

    .page{
        padding: 5px;
    }

    .footer {
        page-break-after:always;
        bottom : 0;
    }

</style>

<body>

@foreach($all_sales_table_data as $sales_table_data_by_group)
    @foreach($sales_table_data_by_group as $sales_table_data)
        <div class="page">
            <div width="100%">


                <div width="100%">
                    <div width="50%" align="left">列印時間: {{\Carbon\Carbon::now()->toDateTimeString()}}</div>
                    <div width="50%" align="right">(存票 NO. {{ $sales_table_data['print_info']->deposit_no ?? '' }})</div>
                </div>

                <br/>

{{--                頂部分店,時間--}}
                <div class="row">
                    <div class="col-md-4"></div>
                    <h3 class="col-md-4 text-center"><b><u>分店名稱&nbsp;：&nbsp;{{ $sales_table_data['print_info']->shop_name ?? '' }}</u></b></h3>
                    <div class="col-md-4 text-right">{{ $sales_table_data['print_info']->date ?? '' }}</div>
                </div>

{{--                表格內容--}}
                <div class="row col-md-12">
                    <table class="table table-bordered customize-border" style="margin: 10px;">

                        <col style="width: 25%">
                        <col style="width: 25%">
                        <col style="width: 25%">
                        <col style="width: 25%">

                        <tbody>

                        <tr>
                            <td>營業機數</td>
                            <td colspan="3">${{$sales_table_data['data']['income_sum']}}</td>
                        </tr>
                        <tr>
                            <td>八達通</td>
                            <td colspan="3">${{$sales_table_data['data']['octopus_income']}}</td>
                        </tr>
                        <tr>
                            <td>現金(押運公司)</td>
                            <td>上日餘款 ${{$sales_table_data['data']['last_balance']}}</td>
                            <td>今日押運上期 ${{$sales_table_data['data']['escort_cash']}}</td>
                            <td>餘款 ${{$sales_table_data['data']['balance']}}</td>
                        </tr>

                        <tr>
                            <td>支付寶</td>
                            <td colspan="3">${{$sales_table_data['data']['alipay_income']}}</td>
                        </tr>

                        {{--                            其他收款方式--}}
                        <tr>
                            <td rowspan="2">其他收款方式</td>
                            <td>Foodpanda</td>
                            <td colspan="2">${{$sales_table_data['data']['foodpanda_income']}}</td>
                        </tr>

                        <tr>
                            <td>微信支付</td>
                            <td colspan="2">${{$sales_table_data['data']['wechatpay_income']}}</td>
                        </tr>

                        {{--                            時段收入--}}
                        <tr>
                            <td rowspan="6">時段收入</td>
                            <td>早市營業額</td>
                            <td colspan="2">${{$sales_table_data['data']['morning_income']}}</td>
                        </tr>

                        <tr>
                            <td>午市營業額</td>
                            <td colspan="2">${{$sales_table_data['data']['noon_income']}}</td>
                        </tr>

                        <tr>
                            <td>下午茶營業額</td>
                            <td colspan="2">${{$sales_table_data['data']['afternoon_tea_income']}}</td>
                        </tr>

                        <tr>
                            <td>晚市營業額</td>
                            <td colspan="2">${{$sales_table_data['data']['evening_income']}}</td>
                        </tr>

                        <tr>
                            <td>宵夜營業額</td>
                            <td colspan="2">${{$sales_table_data['data']['night_snack_income']}}</td>
                        </tr>

                        <tr>
                            <td>麵包營業額</td>
                            <td colspan="2">${{$sales_table_data['data']['bread_income']}}</td>
                        </tr>

                        </tbody>
                    </table>

                </div>


                <div class="row ">
                    <div class="col-md-6 mb-3">

                        <div class="col-md-12 mb-3">
                            <div style="height: 100px;"></div>

                            <div class="sign-border-top w-100 text-center text-lg">分店負責人簽署</div>

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="col-md-12 mb-3">
                            <div style="height: 100px;"></div>

                            <div class="sign-border-top w-100 text-center text-lg">收銀負責人簽署</div>

                        </div>


                    </div>
                </div>

{{--                分頁用--}}
                <footer class="footer"></footer>

            </div>
        </div>
    @endforeach
@endforeach


</body>
