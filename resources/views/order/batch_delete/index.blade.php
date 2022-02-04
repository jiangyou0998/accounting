@extends('layouts.app')

@section('title')
    更新價錢
@stop

@section('js')
    {{--    laydate--}}
    <script src="../layui/laydate/laydate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection


@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


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

        .container {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
            width: 100%;
            max-width: 2000px;      // 隨螢幕尺寸而變，當螢幕尺寸 ≥ 1200px 時是 1140px。
        }

        .style4 {
            color: #FF0000;
            font-size: 50px;
        }

        .style5 {
            font-size: medium;
            font-weight: bold;
        }

        .style6 {
            color: #FF0000;
            font-size: 80px;
        }

    </style>
@endsection

@section('content')
    <div class="container">


        <div align="left">
            <a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a>
        </div>

        <div class="style5" style="text-align: center;">
            <span class="style4">批量<span class="style6">刪除</span>已落單產品</span>
        </div>

        <hr>
        <div align="middle">
            <select class="product" id="product" name="product" style="min-width: 30%">
                <option value="">-- 請選擇貨品 --</option>
                @foreach($codeProductArr as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
{{--            @if(request()->shop_group_id != 5)--}}
{{--                <button class="btn btn-primary" onclick="addsample()">新增</button>--}}
{{--            @endif--}}
{{--            <button class="btn btn-danger" onclick="addtemp()">臨時加單</button>--}}
        </div>
        <hr>



        <div align="left" style="padding-top: 15px;">
            <strong>
                <span style="color: #FF0000; font-size: 172%; ">選擇分組:</span>
            </strong>
        </div>

        @foreach($shop_group_ids as $id => $name)
        <label style="padding-right:15px;">
            <input type="radio" name="shop" value="{{ $id }}"><span class="radio">{{ $name }}</span>
        </label>
        @endforeach

        <hr>


        <div class="row">

            <div class="col-md-4 mb-3">
                <label for="start_date">開始日期</label>

                <input type="text" class="form-control layui-input d-block w-100" name="start_date" id="start_date" value="" autocomplete="off" required="">

                <div class="invalid-feedback">
                    請填寫「開始日期」
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="end_date">結束日期</label>

                <input type="text" class="form-control layui-input d-block w-100" name="end_date" id="end_date" value="" autocomplete="off" required="">

                <div class="invalid-feedback">
                    請填寫「結束日期」
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <button class="btnsubmit btn btn-danger btn-lg" id="btncheck" onclick="check();">查詢</button>
            </div>

        </div>

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">送貨日期</th>
                <th scope="col">分店</th>
                <th scope="col">產品名</th>
                <th scope="col">數量</th>
            </tr>
            </thead>
            <tbody class="table-striped" id="search-data" style="background-color: white">

            </tbody>
        </table>

{{--        <input type="hidden" name="shopstr" id="shopstr" value=""/>--}}

        <br><br>


        <div>
            <button class="btnsubmit btn btn-primary btn-lg btn-block" id="btnsubmit" onclick="sss();" disabled>提交</button>
        </div>

        <br>

    </div>



    <script>

        //product下拉選擇框初始化
        $(document).ready(function() {
            $('.product').select2();
        });

        // laydate初始化
        laydate.render({
            elem: '#start_date' //指定元素
        });

        laydate.render({
            elem: '#end_date' //指定元素
        });

        $(document).on('change', 'input[type=radio]', function () {
            $("#btnsubmit").attr('disabled', true);
        });

        $(document).on('blur', '#start_date, #end_date', function () {
            $("#btnsubmit").attr('disabled', true);
        });

        function check() {

            //禁止按鈕重複點擊
            $("#btncheck").attr('disabled', true);

            var product = $('#product').val();
            var shopstr = $('input:radio[name="shop"]:checked').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            // console.log(shopstr);
            if (product == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇產品！",
                });
                $("#btncheck").attr('disabled', false);
                return false;
            }

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

            let url = '{{route('order.batch_delete.check')}}';
            let type = 'POST';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'start'  : start_date,
                    'end'  : end_date,
                    'shop_group_id': shopstr,
                    'product_id': product,
                },
                dataType:'json',
                success: function (data) {
                    // console.log(data);
                    if(data.status === 'success'){

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

                        $.each(data.search_items, function( index, value ) {
                            table = '<tr>\n' +
                                '                <th scope="row">' + (index + 1) + '</th>\n' +
                                '                <td>' + value.deli_date + '</td>\n' +
                                '                <td>' + value.shop_name + '</td>\n' +
                                '                <td>' + value.product_name + '</td>\n' +
                                '                <td>' + value.qty + '</td>\n' +
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

            let product = $('#product option:selected').text();
            let shopstr = $('input:radio[name="shop"]:checked').next('span').text();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();

            let text = '修改分組 : ' + shopstr + '\n'
                + '刪除產品 : ' + product + '\n'
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
                        batch_delete();
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

        function batch_delete(){
            //禁止按鈕重複點擊
            $("#btnsubmit").attr('disabled', true);

            let product = $('#product').val();
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

            let url = '{{route('order.batch_delete.delete')}}';
            let type = 'DELETE';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'start'  : start_date,
                    'end'  : end_date,
                    'shop_group_id': shopstr,
                    'product_id': product,
                },
                dataType:'json',
                success: function (data) {
                    console.log(data);
                    if(data.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: "批量刪除成功!",
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
