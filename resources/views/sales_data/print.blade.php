<html>
<head>
    <title> - Ryoyu Bakery</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">

    {{--    標題欄： --}}
    <link rel="icon" href="/images/ryoyu_title_logo.ico" type="image/x-icon" />
    {{--    收藏夾：--}}
    <link rel="shortcut icon" href="/images/ryoyu_title_logo.ico" type="image/x-icon" />

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

{{--                日報表摘要--}}
                <div class="col-md-12 order-md-1 customize-border" >
                    <h4 class="mb-3 text-center customize-border-bottom" style="padding: 4px;"><b>日報表摘要</b></h4>

                        <div class="row">
                            <div class="col-md-2 mb-3 text-center">
                                <label for="firstName">承上結存</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="${{$sales_table_data['data']['last_balance']}}" required="" readonly>
                            </div>
                            <div class="col-md-2 mb-3 text-center">
                                <label for="firstName">清機金額</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="${{$sales_table_data['data']['pos_income']}}" required="" readonly>
                            </div>
                            <div class="col-md-2 mb-3 text-center">
                                <label for="firstName">+/-差額</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="{{$sales_table_data['data']['difference']}}" required="" readonly>
                            </div>

                            <div class="col-md-3 mb-3 text-center">
                                <label for="firstName">營業額</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="${{$sales_table_data['data']['income_sum']}}" required="" readonly>
                            </div>

                            <div class="col-md-3 mb-3 text-center">
                                <label for="firstName">存店結餘</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="${{$sales_table_data['data']['balance']}}" required="" readonly>
                            </div>

                        </div>

                        <div class="row customize-border" style="margin: 10px">
                            <div class="col-md-4 mb-3 form-inline">
                                <label for="username">早市 : ${{$sales_table_data['data']['morning_income']}}</label>

                            </div>

                            <div class="col-md-4 mb-3 form-inline">
                                <label for="username">午市 : ${{$sales_table_data['data']['afternoon_income']}}</label>


                            </div>

                            <div class="col-md-4 mb-3 form-inline">
                                <label for="username">晚市 : ${{$sales_table_data['data']['evening_income']}}</label>


                            </div>
                        </div>



                </div>

{{--                現金點算表--}}
                <div class="col-md-12 order-md-1 customize-border" style="margin-top: 15px;">
                    <h4 class="mb-3 text-center customize-border-bottom" style="padding: 4px;"><b>現金點算表</b></h4>

                    <div class="row col-md-12">
                        <table class="table table-bordered customize-border" style="margin: 10px;">

                            <thead>
                            <tr>
                                <th>紙幣面值</th>
                                <th>紙幣金額</th>
                                <th>紙幣面值</th>
                                <th>紙幣金額</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>$1,000</td>
                                <td>${{$sales_table_data['data']['pos_money_1000']}}</td>
                                <td>$50</td>
                                <td>${{$sales_table_data['data']['pos_money_50']}}</td>
                            </tr>
                            <tr>
                                <td>$500</td>
                                <td>${{$sales_table_data['data']['pos_money_500']}}</td>
                                <td>$20</td>
                                <td>${{$sales_table_data['data']['pos_money_20']}}</td>
                            </tr>
                            <tr>
                                <td>$100</td>
                                <td>${{$sales_table_data['data']['pos_money_100']}}</td>
                                <td>$10</td>
                                <td>${{$sales_table_data['data']['pos_money_10']}}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="row ">
                        <div class="col-md-3 mb-3">
                            <div style="height: 150px;"></div>

                            <div class="sign-border-top w-100 text-center align-bottom text-lg">現金點算員</div>

                        </div>

                        <div class="col-md-3 mb-3">
                            <div style="height: 150px;"></div>

                            <div class="sign-border-top w-100 text-center text-lg">覆核人員</div>

                        </div>

                        <div class="col-md-6 mb-3">
                            <table class="table table-bordered customize-border-all" style="margin: 10px;">

                                <tbody>
                                <tr>
                                    <td class="w-50">(一)紙幣總額</td>
                                    <td class="w-50">${{$sales_table_data['data']['pos_paper_money']}}</td>
                                </tr>
                                <tr>
                                    <td class="w-50">(二)輔幣總額</td>
                                    <td class="w-50">${{$sales_table_data['data']['pos_coin']}}</td>
                                </tr>
                                <tr>
                                    <td class="w-50">(三)未存入現金</td>
                                    <td class="w-50">${{$sales_table_data['data']['pos_cash_not_deposited']}}</td>
                                </tr>

                                </tbody>
                            </table>


                        </div>
                    </div>



                </div>

                <div class="col-md-12 order-md-1" style="margin-top: 15px">


                    <div class="row ">
                        <div class="col-md-6 mb-3">

                        </div>

                        <div class="col-md-6 mb-3">
                            <table class="col-md-12 mb-3 customize-border align-left">
                                <td class="col-md-6">(一)+(二)+(三)=現金總額:</td>
                                <td class="col-md-6">${{$sales_table_data['data']['balance']}}</td>
                            </table>

                            <table class="col-md-12 mb-3 customize-border">
                                <td class="col-md-6">+ 存入({{$sales_table_data['data']['bank']}}):</td>
                                <td class="col-md-6">${{$sales_table_data['data']['deposit_in_bank']}}</td>
                            </table>

                            <table class="col-md-12 mb-3 customize-border">
                                <td class="col-md-6">+ 八達通存款:</td>
                                <td class="col-md-6">${{$sales_table_data['data']['octopus_income']}}</td>
                            </table>

                            <table class="col-md-12 mb-3 customize-border">
                                <td class="col-md-6">+ ALIPAY:</td>
                                <td class="col-md-6">${{$sales_table_data['data']['alipay_income']}}</td>
                            </table>

                            <table class="col-md-12 mb-3 customize-border">
                                <td class="col-md-6">+ WECHAT:</td>
                                <td class="col-md-6">${{$sales_table_data['data']['wechatpay_income']}}</td>
                            </table>

                            <table class="col-md-12 mb-3 customize-border">
                                <td class="col-md-6">+ 現金券:</td>
                                <td class="col-md-6">${{$sales_table_data['data']['coupon_income']}}</td>
                            </table>

                            <table class="col-md-12 mb-3 customize-border">
                                <td class="col-md-6">+ 信用卡:</td>
                                <td class="col-md-6">${{$sales_table_data['data']['credit_card_income']}}</td>
                            </table>

                            <table class="col-md-12 mb-3 customize-border">
                                <td class="col-md-6">- 承上結存:</td>
                                <td class="col-md-6">${{$sales_table_data['data']['last_balance']}}</td>
                            </table>

                            <table class="col-md-12 mb-3 customize-border">
                                <td class="col-md-6">= 是日營業額:</td>
                                <td class="col-md-6">${{$sales_table_data['data']['income_sum']}}</td>
                            </table>
{{--                            <div class="col-md-12 mb-3 customize-border">(一)+(二)=現金總額:</div>--}}
{{--                            <div class="col-md-12 mb-3 customize-border">+存入(匯豐):</div>--}}
{{--                            <div class="col-md-12 mb-3 customize-border">+八達通存款:</div>--}}
{{--                            <div class="col-md-12 mb-3 customize-border">+ALIPAY / WECHAT:</div>--}}
{{--                            <div class="col-md-12 mb-3 customize-border">+現金券:</div>--}}
{{--                            <div class="col-md-12 mb-3 customize-border">+信用卡:</div>--}}
{{--                            <div class="col-md-12 mb-3 customize-border">-承上結存:</div>--}}
{{--                            <div class="col-md-12 mb-3 customize-border">=是日營業額:</div>--}}
                        </div>
                    </div>

                </div>

                <div class="col-md-12 order-md-1" style="margin-top: 15px">


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

                                <div class="sign-border-top w-100 text-center text-lg">會計</div>

                            </div>


                        </div>
                    </div>

                    {{--                分頁用--}}
                    <footer class="footer"></footer>

                </div>
            </div>
        </div>
    @endforeach
@endforeach


</body>
