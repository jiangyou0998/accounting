@extends('layouts.app')

@section('title')
    營業數
@stop

@section('js')
    {{--    laydate--}}
    <script src="../layui/laydate/laydate.js"></script>
@endsection


@section('style')
    <style type="text/css">

        body{
            margin-left: 40px;
            margin-right: 40px;
        }

        input.qty {
            width: 40%
        }

        input[type="radio"]{
            width: 25px; /*Desired width*/
            height: 25px; /*Desired height*/
        }

        .radio{
            font-size: 30px;
            margin-bottom: 10px;
        }

        .style4 {
            color: #FF0000;
            font-size: 50px;
        }

        .style5 {
            font-size: medium;
            font-weight: bold;
        }

    </style>
@endsection

@section('content')
    <div class="container">

{{--        <div class="alert-message">--}}
{{--            <ul class="error-content">--}}

{{--            </ul>--}}
{{--        </div>--}}

        <div class="alert-message" style="display: none;">
            <div class="alert alert-danger error-content" role="alert" style="">

            </div>
        </div>

        <div class="style5" style="text-align: center;">
            <span class="style4">營業數({{$date}})</span>
{{--            <a href="{{route('sales_data_change_application.index')}}"><h3>修改申請</h3></a>--}}
        </div>

        <hr>
        <div class="row">
            <div class="col-md-12 order-md-1">

                <form class="needs-validation" novalidate>
                    <h4 class="mb-3">1.收銀機收入</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_pos_no">主機No</label>
                            <input type="text" pattern="[0-9]*" class="form-control" id="first_pos_no" placeholder="" value="{{ $sales_cal_result->first_pos_no ?? ''}}" autocomplete="off" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="firstPosIncome">主機收入</label>
                            <input type="text" pattern="[0-9]*" class="form-control pos-income" id="first_pos_income" value="{{ $sales_income_detail['12'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="second_pos_no" pattern="[0-9]*">副機No</label>
                            <input type="text" pattern="[0-9]*" class="form-control" id="second_pos_no" placeholder="" value="{{ $sales_cal_result->second_pos_no ?? ''}}" autocomplete="off" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="secondPosIncome">副機收入</label>
                            <input type="text" pattern="[0-9]*" class="form-control pos-income" id="second_pos_income" value="{{ $sales_income_detail['14'] ?? '' }}" placeholder="" min="0" autocomplete="off">
                        </div>
                        <div class="d-flex">

                        </div>
                        <h3 class="col-lg-12 p-3 text-right">收銀機總收入 : $<span id="pos_sum">0.00</span></h3>
                    </div>

{{--                    period-時段收入--}}
                    <hr>
                    <h4 class="mb-3">2.時段收入</h4>
                    <div class="alert alert-danger period-alert" role="alert" style="display: none;">
                        「時段收入」與「收銀機收入」不符，請檢查是否輸入有誤！
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="morningIncome">早更收入</label>
                            <input type="text" pattern="[0-9]*" class="form-control period-income" id="morning_income" value="{{ $sales_income_detail['21'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="afternoonIncome">午更收入</label>
                            <input type="text" pattern="[0-9]*" class="form-control period-income" id="afternoon_income" value="{{ $sales_income_detail['22'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="eveningIncome">晚更收入</label>
                            <input type="text" pattern="[0-9]*" class="form-control period-income" id="evening_income" value="{{ $sales_income_detail['23'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <h3 class="col-lg-12 p-3 text-right">時段總收入 : $<span id="period_sum">0.00</span></h3>
                    </div>
{{--                    period-時段收入--}}

{{--                    payment-支付方式收入--}}
                    <hr>
                    <h4 class="mb-3">3.支付方式收入</h4>
                    <div class="alert alert-danger payment-alert" role="alert" style="display: none;">
                        「支付方式收入」與「主機收入」不符，請檢查是否輸入有誤！
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="octopusIncome">八達通</label>
                            <input type="text" pattern="[0-9]*" class="form-control payment-income" id="octopus_income" value="{{ $sales_income_detail['31'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="alipayIncome">支付寶</label>
                            <input type="text" pattern="[0-9]*" class="form-control payment-income" id="alipay_income" value="{{ $sales_income_detail['32'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="wechatpayIncome">微信</label>
                            <input type="text" pattern="[0-9]*" class="form-control payment-income" id="wechatpay_income" value="{{ $sales_income_detail['33'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <h3 class="col-lg-12 p-3 text-right">支付方式總收入 : $<span id="payment_sum">0.00</span></h3>
                    </div>
{{--                    payment-支付方式收入--}}
                    <hr>
                    <h4 class="mb-3">4.收銀機餘款</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="posPaperMoney">紙幣</label>
                            <input type="text" pattern="[0-9]*" class="form-control pos-cash" id="pos_paper_money" value="{{ $sales_income_detail['41'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="posCoin">硬幣</label>
                            <input type="text" pattern="[0-9]*" class="form-control pos-cash" id="pos_coin" value="{{ $sales_income_detail['42'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                    </div>

                    <h3 class="col-lg-12 p-3 text-right">收銀機餘款總計 : $<span id="pos_cash_sum">0.00</span></h3>

                    <hr>
                    <h4 class="mb-3">5.夾萬餘款</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="safePaperMoney">紙幣</label>
                            <input type="text" pattern="[0-9]*" class="form-control safe-cash" id="safe_paper_money" value="{{ $sales_income_detail['51'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="safeCoin">硬幣</label>
                            <input type="text" pattern="[0-9]*" class="form-control safe-cash" id="safe_coin" value="{{ $sales_income_detail['52'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <h3 class="col-lg-12 p-3 text-right">夾萬餘款總計 : $<span id="safe_cash_sum">0.00</span></h3>
                    </div>

                    <hr>
                    <h4 class="mb-3">6.承上數</h4>
                    <div class="row">

                        <h3 class="col-lg-12 p-3 text-right">承上結存 : $<span id="last_balance">{{$last_balance}}</span></h3>
{{--                        <h3 class="col-lg-12 p-3 text-right">夾萬承上結存 : $<span id="last_safe_balance">{{$last_safe_balance}}</span></h3>--}}

                    </div>

                    <hr>
                    <h4 class="mb-3">7.存入取出數</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="depositInSafe">存入夾萬</label>
                            <input type="text" pattern="[0-9]*" class="form-control in-out" id="deposit_in_safe" value="{{ $sales_income_detail['71'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="depositInBank">存入銀行</label>
                            <div class="form-inline row">
                                <select class="form-control form-inline col-md-4" name="deposit_bank" id="deposit_bank">
                                    <option value="">-選擇銀行-</option>
                                    <option value="東亞" @if($bank === '東亞') selected @endif>東亞</option>
                                    <option value="HSBC" @if($bank === 'HSBC') selected @endif>HSBC</option>
                                    <option value="中銀" @if($bank === '中銀') selected @endif>中銀</option>
                                    <option value="創興" @if($bank === '創興') selected @endif>創興</option>
                                </select>
                                <input class="form-control form-inline col-md-8" type="text" pattern="[0-9]*" class="form-control in-out" id="deposit_in_bank" value="{{ $sales_income_detail['72'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                            </div>
                        </div>

{{--                        慧霖取銀可以輸入負數--}}
                        <div class="col-md-6 mb-3">
                            <label for="kellyOut">慧霖取銀</label>
                            <input type="text" pattern="[0-9]*" class="form-control in-out" id="kelly_out" value="{{ $sales_income_detail['73'] ?? '' }}" placeholder="" required>
                        </div>
                    </div>

                    <hr>
                    <h4 class="mb-3">8.支單</h4>
                    <div class="row">
                        @for($i=1; $i<=10; $i++)
                            <div class="col-md-6 mb-3">
                                <label for="billPaid">支單({{$i}})</label>
                                <input type="text" pattern="[0-9]*" class="form-control bill-paid" placeholder="" value="{{ $bills[$i] ?? '' }}" required>
                            </div>
                        @endfor
                        <h3 class="col-lg-12 p-3 text-right">支單總計 : $<span id="bill_paid_sum">{{ $sales_cal_result->bill_paid_sum ?? '0.00'}}</span></h3>
                    </div>


{{--                    2022-05-19 新增時節數--}}
                    <hr>
                    <h4 class="mb-3">9.時節數</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="seasonalIncome">時節數</label>
                            <input type="text" pattern="[0-9]*" class="form-control seasonal-income" id="seasonal_income" value="{{ $sales_income_detail['91'] ?? '' }}" placeholder="" min="0" autocomplete="off" required>
                        </div>
                    </div>

                    <br>
                    <br>

                    <hr>
                    <h4 class="mb-3">10.總計</h4>
                    <div class="row">
                        <h3 class="col-lg-12 p-3 text-right">收入 : $<span id="income_sum">{{ $sales_cal_result->income_sum ?? '0.00'}}</span></h3>
                        <h3 class="col-lg-12 p-3 text-right">差額 : $<span id="difference">{{ $sales_cal_result->difference ?? '0.00'}}</span></h3>
                    </div>

                    <div class="form-group row">
                        <button type="button" class="btn btn-primary btn-block btn-submit">提交</button>
                        <a href="{{ route('sales_data.print', ['date' => request()->date]) }}" class="btn btn-danger btn-block" target="_blank">打印預覽</a>

                    </div>

                    </form>
            </div>
@endsection

@section('script')
    <script>

        $(document).ready(function(){
            $('.form-control').trigger("blur");
        });

        //
        $(document).on('blur', '.pos-income', function () {
            let pos_sum = getPosIncomeSum();
            let period_sum = getPeriodIncomeSum();
            $('#pos_sum').html(pos_sum);

            if(pos_sum !== period_sum){
                console.log('不一樣');
                $('.period-alert').show();
            }else{
                console.log('一樣');
                $('.period-alert').hide();
            }
        });

        //
        $(document).on('blur', '.period-income', function () {
            let pos_sum = getPosIncomeSum();
            let period_sum = getPeriodIncomeSum();
            $('#period_sum').html(period_sum);

            if(pos_sum !== period_sum){
                $('.period-alert').show();
            }else{
                $('.period-alert').hide();
            }
        });

        //
        $(document).on('blur', '.payment-income', function () {
            let payment_sum = getPaymentIncomeSum();
            $('#payment_sum').html(payment_sum);
        });

        //
        $(document).on('blur', '.pos-cash', function () {
            let pos_cash_sum = getPosCashSum();
            $('#pos_cash_sum').html(pos_cash_sum);
        });

        //
        $(document).on('blur', '.safe-cash', function () {
            let safe_cash_sum = getSafeCashSum();
            $('#safe_cash_sum').html(safe_cash_sum);
        });

        //
        $(document).on('blur', '.bill-paid', function () {
            let bill_paid_sum = getBillPaidSum();
            $('#bill_paid_sum').html(bill_paid_sum);
        });

        //計算收入,差額
        $(document).on('blur', '.form-control', function () {
            let income_sum = getIncomeSum();
            $('#income_sum').html(income_sum);
            let difference = getDifference();
            $('#difference').html(difference);
        });

        //獲取收銀機收入總數
        function getPosIncomeSum(){
            let first_pos_income = $('#first_pos_income').val();
            let second_pos_income = $('#second_pos_income').val();
            let pos_sum = 0;

            if((first_pos_income.length > 0)){
                pos_sum += parseFloat(first_pos_income);
            }

            if((second_pos_income.length > 0)){
                pos_sum += parseFloat(second_pos_income);
            }

            return pos_sum.toFixed(2);
        }

        //獲取時段收入總數
        function getPeriodIncomeSum(){
            let morning_income = $('#morning_income').val();
            let afternoon_income = $('#afternoon_income').val();
            let evening_income = $('#evening_income').val();
            let period_sum = 0;

            if((morning_income.length > 0)){
                period_sum += parseFloat(morning_income);
            }

            if((afternoon_income.length > 0)){
                period_sum += parseFloat(afternoon_income);
            }

            if((evening_income.length > 0)){
                period_sum += parseFloat(evening_income);
            }

            return period_sum.toFixed(2);
        }

        //獲取支付方式收入總數
        function getPaymentIncomeSum(){
            let octopus_income = $('#octopus_income').val();
            let alipay_income = $('#alipay_income').val();
            let wechatpay_income = $('#wechatpay_income').val();
            let payment_sum = 0;

            if((octopus_income.length > 0)){
                payment_sum += parseFloat(octopus_income);
            }

            if((alipay_income.length > 0)){
                payment_sum += parseFloat(alipay_income);
            }

            if((wechatpay_income.length > 0)){
                payment_sum += parseFloat(wechatpay_income);
            }

            return payment_sum.toFixed(2);
        }

        //獲取收銀機餘款總數
        function getPosCashSum(){
            let pos_paper_money = $('#pos_paper_money').val();
            let pos_coin = $('#pos_coin').val();
            let pos_cash_sum = 0;

            if((pos_paper_money.length > 0)){
                pos_cash_sum += parseFloat(pos_paper_money);
            }

            if((pos_coin.length > 0)){
                pos_cash_sum += parseFloat(pos_coin);
            }

            return pos_cash_sum.toFixed(2);
        }

        //獲取夾萬餘款總數
        function getSafeCashSum(){
            let safe_paper_money = $('#safe_paper_money').val();
            let safe_coin = $('#safe_coin').val();
            let safe_cash_sum = 0;

            if((safe_paper_money.length > 0)){
                safe_cash_sum += parseFloat(safe_paper_money);
            }

            if((safe_coin.length > 0)){
                safe_cash_sum += parseFloat(safe_coin);
            }

            return safe_cash_sum.toFixed(2);
        }

        // //獲取夾萬餘款總數(有可能計算公式不對)
        // function getSafeBalance(){
        //     let safe_cash_sum = getSafeCashSum();
        //     let safe_balance = 0;
        //
        //     let deposit_in_safe = $('#deposit_in_safe').val();
        //     let deposit_in_bank = $('#deposit_in_bank').val();
        //
        //     safe_balance = safe_cash_sum + deposit_in_safe - deposit_in_bank;
        //
        //     return safe_balance.toFixed(2);
        // }

        //獲取支單總數
        function getBillPaidSum(){
            let bill_paid_sum = 0;

            $('.bill-paid').each(function (){
                let bill_paid = $(this).val();
                if((bill_paid.length > 0)){
                    bill_paid_sum += parseFloat(bill_paid);
                }
            });

            return bill_paid_sum.toFixed(2);
        }

        //獲取承上結存
        function getLastBalance(){
            let last_balance = 0;
            let input_value = $('#last_balance').text();
            if((input_value.length > 0)){
                last_balance += parseFloat(input_value);
            }
            return last_balance.toFixed(2);
        }

        //獲取今日結存
        function getBalance(){
            let balance = 0;
            let pos_cash_sum = getPosCashSum();
            let safe_cash_sum = getSafeCashSum();

            balance = parseFloat(pos_cash_sum) + parseFloat(safe_cash_sum);

            return balance.toFixed(2);
        }

        //獲取夾萬承上結存
        function getLastSafeBalance(){
            let last_safe_balance = 0;
            let input_value = $('#last_safe_balance').val();
            if((input_value.length > 0)){
                last_safe_balance += parseFloat(input_value);
            }
            return last_safe_balance.toFixed(2);
        }

        //獲取存入夾萬數
        function getDepositInSafe(){
            let deposit_in_safe = 0;
            let input_value = $('#deposit_in_safe').val();
            if((input_value.length > 0)){
                deposit_in_safe += parseFloat(input_value);
            }
            return deposit_in_safe.toFixed(2);
        }

        //獲取存入銀行數
        function getDepositInBank(){
            let deposit_in_bank = 0;
            let input_value = $('#deposit_in_bank').val();
            if((input_value.length > 0)){
                deposit_in_bank += parseFloat(input_value);
            }
            return deposit_in_bank.toFixed(2);
        }

        //獲取慧霖取銀數
        function getKellyOut(){
            let kelly_out = 0;
            let input_value = $('#kelly_out').val();
            if((input_value.length > 0)){
                kelly_out += parseFloat(input_value);
            }
            return kelly_out.toFixed(2);
        }

        //獲取收入
        function getIncomeSum(){
            //收銀機餘款總計
            let pos_cash_sum = getPosCashSum();
            //夾萬餘款總計
            let safe_cash_sum = getSafeCashSum();
            //支付方式收入總計
            let payment_sum = getPaymentIncomeSum();
            //支單總計
            let bill_paid_sum = getBillPaidSum();
            //存入銀行
            let deposit_in_bank = getDepositInBank();
            //承上結存
            let last_balance = getLastBalance();
            //慧霖取銀
            let kelly_out = getKellyOut();

            let income_sum = 0;
            income_sum += parseFloat(pos_cash_sum);
            income_sum += parseFloat(safe_cash_sum);
            income_sum += parseFloat(payment_sum);
            income_sum += parseFloat(bill_paid_sum);
            income_sum += parseFloat(deposit_in_bank);
            income_sum -= parseFloat(last_balance);
            income_sum -= parseFloat(kelly_out);
            return income_sum.toFixed(2);
        }

        //獲取差額
        function getDifference(){
            //收入
            let income_sum = getIncomeSum();
            //收銀機收入
            let pos_income_sum = getPosIncomeSum();

            let difference = 0;
            difference += parseFloat(income_sum);
            difference -= parseFloat(pos_income_sum);

            return difference.toFixed(2);
        }

        $('.btn-submit').click(function () {

            //存入銀行填寫後必須選擇銀行
            if($('#deposit_in_bank').val() && !$('#deposit_bank option:selected').val()){
                // alert('請選擇銀行');
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇銀行!",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: '確定',
                })
                return;
            }

            $('.btn-submit').attr('disabled', true);

            // 构建请求参数，将用户选择的維修項目 ,維修員 和 維修費用 写入请求参数
            var req = {
                inputs: [],
                bills : [],
                first_pos_no : $('#first_pos_no').val(),
                second_pos_no : $('#second_pos_no').val(),
                deposit_bank : $('#deposit_bank option:selected').val(),
                kelly_out: $('#kelly_out').val(),
                balance: getBalance(),
                safe_balance: getSafeCashSum(),
                bill_paid_sum: getBillPaidSum(),
                income_sum: getIncomeSum(),
                difference: getDifference(),
            };

            req.inputs.push({
                first_pos_income: $('#first_pos_income').val(),
                second_pos_income: $('#second_pos_income').val(),
                morning_income: $('#morning_income').val(),
                afternoon_income: $('#afternoon_income').val(),
                evening_income: $('#evening_income').val(),
                octopus_income: $('#octopus_income').val(),
                alipay_income: $('#alipay_income').val(),
                wechatpay_income: $('#wechatpay_income').val(),
                pos_paper_money: $('#pos_paper_money').val(),
                pos_coin: $('#pos_coin').val(),
                safe_paper_money: $('#safe_paper_money').val(),
                safe_coin: $('#safe_coin').val(),
                deposit_in_safe: $('#deposit_in_safe').val(),
                deposit_in_bank: $('#deposit_in_bank').val(),
                seasonal_income: $('#seasonal_income').val(),
            });

            let $bill_no = 1;
            $('.bill-paid').each(function (){
                let bill_paid = $(this).val();
                if((bill_paid.length > 0)){
                    req.bills.push({
                        bill_no: $bill_no,
                        outlay: bill_paid,
                    })
                    $bill_no ++ ;
                }
            });

            $.ajax({
                type: "POST",
                url: "{{route('sales_data.store', ['date' => request()->date])}}",
                data: req,
                success: function() {
                    $('.alert-message').hide();
                    $('.error-content').html('');
                    $('<div>').appendTo('.error-content').addClass('form_alert alert-success').html('保存成功').show().delay(1000).fadeOut();
                    Swal.fire({
                        icon: 'success',
                        title: "已提交營業數!",
                        showDenyButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '確定',
                        denyButtonText: '打印預覽',
                    }).then((result) => {
                        if (result.isDenied) {
                            let url = '{{ route('sales_data.print', ['date' => request()->date]) }}'
                            // window.location.href = url;
                            window.open(url);
                        }
                    });
                    $('.btn-submit').attr('disabled', false);
                },
                error: function(res) {
                    errors = res.responseJSON.errors;
                    var form_errors = '';
                    $.each(errors, function(i) {
                        form_errors += '<div>' + errors[i] + '</div>';
                    });
                    $('.alert-message').show();
                    $('.error-content').html('');
                    $('<div>').appendTo('.error-content').addClass('form_alert alert-danger').html(form_errors).show();
                    $('body,html').animate({
                            scrollTop: 0
                        },
                        500);
                    $('.btn-submit').attr('disabled', false);
                },
            });

        });

    </script>
@endsection

