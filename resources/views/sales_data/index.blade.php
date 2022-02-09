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


        <div class="style5" style="text-align: center;">
            <span class="style4">營業數({{now()->toDateString()}})</span>

        </div>

        <hr>
        <div class="row">
            <div class="col-md-12 order-md-1">

                <form class="needs-validation" novalidate>
                    <h4 class="mb-3">1.收銀機收入</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">主機No</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hostIncome">主機收入</label>
                            <input type="number" class="form-control pos-income" id="first_pos_income" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="firstName">副機No</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="firstName">副機收入</label>
                            <input type="number" class="form-control pos-income" id="second_pos_income" placeholder="" min="0">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
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
                            <input type="number" class="form-control period-income" id="morning_income" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="afternoonIncome">午更收入</label>
                            <input type="number" class="form-control period-income" id="afternoon_income" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="eveningIncome">晚更收入</label>
                            <input type="number" class="form-control period-income" id="evening_income" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
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
                            <input type="number" class="form-control payment-income" id="octopus_income" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="alipayIncome">支付寶</label>
                            <input type="number" class="form-control payment-income" id="alipay_income" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="wechatpayIncome">微信</label>
                            <input type="number" class="form-control payment-income" id="wechatpay_income" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <h3 class="col-lg-12 p-3 text-right">支付方式總收入 : $<span id="payment_sum">0.00</span></h3>
                    </div>
{{--                    payment-支付方式收入--}}

                    <hr>
                    <h4 class="mb-3">4.收銀機餘款</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="posPaperMoney">紙幣</label>
                            <input type="number" class="form-control pos-cash" id="pos_paper_money" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="posCoin">硬幣</label>
                            <input type="number" class="form-control pos-cash" id="pos_coin" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                    </div>

                    <h3 class="col-lg-12 p-3 text-right">收銀機餘款總計 : $<span id="pos_cash_sum">0.00</span></h3>

                    <hr>
                    <h4 class="mb-3">5.夾萬餘款</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="safePaperMoney">紙幣</label>
                            <input type="number" class="form-control safe-cash" id="safe_paper_money" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="safeCoin">硬幣</label>
                            <input type="number" class="form-control safe-cash" id="safe_coin" placeholder="" min="0" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <h3 class="col-lg-12 p-3 text-right">夾萬餘款總計 : $<span id="safe_cash_sum">0.00</span></h3>
                    </div>

                    <hr>
                    <h4 class="mb-3">6.承上數</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lastBalance">承上結存</label>
                            <input type="number" class="form-control" id="last_balance" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastSafeBalance">夾萬承上結存</label>
                            <input type="number" class="form-control" id="last_safe_balance" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                    </div>

                    <hr>
                    <h4 class="mb-3">7.存入取出數</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="depositInSafe">存入夾萬</label>
                            <input type="number" class="form-control in-out" id="deposit_in_safe" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="depositInBank">存入銀行</label>
                            <input type="number" class="form-control in-out" id="deposit_in_bank" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kellyOut">慧霖取銀</label>
                            <input type="number" class="form-control in-out" id="kelly_out" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h4 class="mb-3">8.支單</h4>
                    <div class="row">
                        @for($i=1; $i<=10; $i++)
                            <div class="col-md-6 mb-3">
                                <label for="billPaid">支單({{$i}})</label>
                                <input type="number" class="form-control bill-paid" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                        @endfor
                        <h3 class="col-lg-12 p-3 text-right">支單總計 : $<span id="bill_paid_sum">0.00</span></h3>
                    </div>

                    <br>
                    <br>

                    <hr>
                    <h4 class="mb-3">9.總計</h4>
                    <div class="row">
                        <h3 class="col-lg-12 p-3 text-right">收入 : $<span id="income_sum">0.00</span></h3>
                        <h3 class="col-lg-12 p-3 text-right">差額 : $<span id="difference">0.00</span></h3>
                    </div>

                    </form>
            </div>

    <script>


        //鉤選或取消時,修改shopstr(隱藏)的值
        // $(document).on('change', 'input[type=checkbox]', function () {
        //     var shopstr = $('input[type=checkbox][class=\'shop\']:checked').map(function () {
        //         return this.value
        //     }).get().join(',');
        //     $('#shopstr').val(shopstr);
        //     // alert(shopstr);
        // });

        $(document).on('change', 'input[type=radio]', function () {
            $("#btnsubmit").attr('disabled', true);
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
            // if((morning_income.length > 0)
            //     && (afternoon_income.length > 0)
            //     && (evening_income.length > 0)){
            //     period_sum = parseFloat(morning_income) + parseFloat(afternoon_income) + parseFloat(evening_income);
            // }

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
            let input_value = $('#last_balance').val();
            if((input_value.length > 0)){
                last_balance += parseFloat(input_value);
            }
            return last_balance.toFixed(2);
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

        function check() {

            //禁止按鈕重複點擊
            $("#btncheck").attr('disabled', true);

            var shopstr = $('input:radio[name="shop"]:checked').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            console.log(shopstr);
            if (shopstr == null) {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分組！",
                });
                $("#btncheck").attr('disabled', false);
                return false;
            }

            if (start_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇開始時間！",
                });
                $("#btncheck").attr('disabled', false);
                return false;
            }

            if (end_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇結束時間！",
                });
                $("#btncheck").attr('disabled', false);
                return false;
            }

            let url = '{{route('order.update_price.check')}}';
            let type = 'POST';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'start'  : start_date,
                    'end'  : end_date,
                    'shop_group_id': shopstr,
                },
                dataType:'json',
                success: function (data) {
                    // console.log(data);
                    if(data.status === 'success'){

                        {{--Swal.fire({--}}
                        {{--    icon: 'success',--}}
                        {{--    title: data.count,--}}
                        {{--    showDenyButton: true,--}}
                        {{--    confirmButtonColor: '#3085d6',--}}
                        {{--    confirmButtonText: '確定',--}}
                        {{--    denyButtonText: '返回',--}}
                        {{--}).then((result) => {--}}
                        {{--    if (result.isDenied) {--}}
                        {{--        --}}{{--window.location.href = '{{route('order.regular.sample',['shop_group_id' => $shop_group_id])}}';--}}
                        {{--    } else {--}}
                        {{--        window.location.reload();--}}
                        {{--    }--}}

                        {{--});--}}

                        let title = '';
                        if(data.count > 0){
                            title = '共找到' + data.count + '條數據';
                        }else{
                            title = '未找到數據';
                        }

                        Swal.fire({
                            // icon: 'success',
                            title: title,
                            showDenyButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '確定',
                            denyButtonText: '返回',
                        });

                        $('#search-data').empty();

                        $.each(data.different_item, function( index, value ) {
                            table = '<tr>\n' +
                                '                <th scope="row">' + (index + 1) + '</th>\n' +
                                '                <td>' + value.deli_date + '</td>\n' +
                                '                <td>' + value.shop_name + '</td>\n' +
                                '                <td>' + value.product_name + '</td>\n' +
                                '                <td>' + value.old_price + '</td>\n' +
                                '                <td>' + value.new_price + '</td>\n' +
                                '            </tr>';
                            $('#search-data').append(table);
                            // console.log(value.product_name);
                        });
                        $("#btncheck").attr('disabled', false);
                        // 找到data才解鎖「提交」按鈕
                        if(data.count > 0){
                            $("#btnsubmit").attr('disabled', false);
                        }
                    }else if(data.status === 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            showDenyButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '確定',
                            denyButtonText: '返回',
                        });
                        $("#btncheck").attr('disabled', false);
                    }

                }
            });

            // $("#btnsubmit").attr('disabled', false);
        }

        function sss() {

            let shopstr = $('input:radio[name="shop"]:checked').next('span').text();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();

            let text = '修改分組 : ' + shopstr + '\n'
                + start_date + ' 到 ' + end_date + '\n\n'
                + '請輸入「yes」確認';

            Swal.fire({
                title: text,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '確認',
                cancelButtonText: '取消',
                showLoaderOnConfirm: true,
                preConfirm: (comfirm) => {
                    if ( comfirm === 'yes' ){
                        update_price();
                        return true;
                    }else{
                        Swal.showValidationMessage(
                            '請輸入「yes」確認'
                        )
                    }
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: `提交成功`
                    })
                }
            })



            // $("#btnsubmit").attr('disabled', false);
        }

        function update_price(){
            //禁止按鈕重複點擊
            $("#btnsubmit").attr('disabled', true);

            let shopstr = $('input:radio[name="shop"]:checked').val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            console.log(shopstr);
            if (shopstr == null) {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分組！",
                });
                $("#btnsubmit").attr('disabled', false);
                return false;
            }

            if (start_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇開始時間！",
                });
                $("#btnsubmit").attr('disabled', false);
                return false;
            }

            if (end_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇結束時間！",
                });
                $("#btnsubmit").attr('disabled', false);
                return false;
            }

            let url = '{{route('order.update_price.modify')}}';
            let type = 'PUT';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'start'  : start_date,
                    'end'  : end_date,
                    'shop_group_id': shopstr,
                },
                dataType:'json',
                success: function (data) {
                    console.log(data);
                    if(data.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: "柯打改期成功!",
                            showDenyButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '確定',
                            denyButtonText: '返回',
                        }).then((result) => {
                            if (result.isDenied) {
                                {{--window.location.href = '{{route('order.regular.sample',['shop_group_id' => $shop_group_id])}}';--}}
                            } else {
                                window.location.reload();
                            }

                        });
                    }else if(data.status === 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            showDenyButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '確定',
                            denyButtonText: '返回',
                        });
                    }

                }
            });

        }
    </script>

@endsection
