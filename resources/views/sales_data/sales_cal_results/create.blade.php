@extends('layouts.app')

@section('title')
    新增營業數記錄
@stop

@section('style')

    <style>
        .custom-date {
            display: inline-block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: .375rem .375rem .375rem .75rem;
            line-height: 1.5;
            color: #495057;
            vertical-align: middle;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
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

    <div class="container main">
        <div class="col-sm-12 col-md-12 col-12">


            <div class="container">


                <div align="left">
                    <a target="_top" href="{{route('sales_data.operation_index')}}" style="font-size: xx-large;">返回</a>
                </div>

                <div class="style5" style="text-align: center;">
                    <span class="style4">新增營業數記錄</span>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <div align="left" style="padding-top: 15px;">
                            <strong>
                                <span style="color: #FF0000; font-size: 172%; ">選擇分店:</span>
                            </strong>
                        </div>

                        <select class="custom-select w-100" id="shop_id" required>
                            <option value="0">請選擇分店</option>
                            @foreach($shops as $shop)
                                <option value="{{$shop->id}}">{{$shop->report_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div align="left" style="padding-top: 15px;">
                            <strong>
                                <span style="color: #FF0000; font-size: 172%; ">選擇時間:</span>
                            </strong>
                        </div>

                        <input class="custom-date w-100" type="date" id="date" autocomplete="off">
                    </div>

                    <div class="col-md-4 mb-3">
                        <button class="btncheck btn btn-danger btn-lg" id="btncheck" onclick="check();">查詢</button>
                    </div>

                </div>


                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">日期</th>
                        <th scope="col">分店名稱</th>
                        <th scope="col">存票 NO.</th>
                        <th scope="col">上日餘款</th>
                        <th scope="col">餘款</th>
                    </tr>
                    </thead>
                    <tbody class="table-striped" id="search-data" style="background-color: white">

                    </tbody>
                </table>



                <br><br>


                <div>
                    <button class="btnsubmit btn btn-primary btn-lg btn-block" id="btnsubmit" onclick="sss();" disabled>提交</button>
                </div>

                <br>

            </div>


        </div>
    </div>

@endsection

@section('script')
    <script>

        $(document).on('blur', '#date', function () {
            $("#btnsubmit").attr('disabled', true);
        });

        function check() {

            //禁止按鈕重複點擊
            $("#btncheck").attr('disabled', true);

            let shop_id = $('#shop_id option:selected').val();
            let date = $('#date').val();

            console.log(date);

            if (shop_id == null || shop_id == 0) {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分店！",
                });
                $("#btncheck").attr('disabled', false);
                return false;
            }

            if (date === "" || date === undefined) {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇時間！",
                });
                $("#btncheck").attr('disabled', false);
                return false;
            }

            let url = '{{route('sales_data.sales_cal_results.check')}}';
            let type = 'POST';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'date'  : date,
                    'shop_id': shop_id,
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

                        $.each(data.result, function( index, value ) {
                            table = '<tr>\n' +
                                '                <th scope="row">' + (index + 1) + '</th>\n' +
                                '                <td>' + value.date + '</td>\n' +
                                '                <td>' + value.user.report_name + '</td>\n' +
                                '                <td>' + value.deposit_no + '</td>\n' +
                                '                <td>' + value.last_balance + '</td>\n' +
                                '                <td>' + value.balance + '</td>\n' +
                                '            </tr>';
                            $('#search-data').append(table);
                            // console.log(value.product_name);
                        });
                        $("#btncheck").attr('disabled', false);
                        // 找不到選擇日期data才解鎖「提交」按鈕
                        if(data.can_create === 0){
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

                },
                error: function (data) {
                    errors = data.responseJSON.errors;
                    let form_errors = '';
                    $.each(errors, function(i) {
                        form_errors += '<div>' + errors[i] + '</div>';
                    });
                    Swal.fire({
                        icon: 'warning',
                        title: form_errors,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '確定',
                    });
                }
            });

            $("#btncheck").attr('disabled', false);
        }

        function sss() {
            let shop_name = $('#shop_id option:selected').html();
            let date = $('#date').val();
            let title = '<h2>確認 ' + shop_name + ' ' + date +' 新增營業數記錄？新增後將無法刪除。</h2>';
            title += '<h2>新增當日分店即可修改該日以及該日下一條記錄，無需另行申請修改。</h2>';
            title += '<h2>如確認請在下方輸入「yes」後點擊確認按鈕。</h2>';
            Swal.fire({
                html: title,
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
            })
            //     .then((result) => {
            //     if (result.isConfirmed) {
            //         Swal.fire({
            //             title: `提交成功`
            //         })
            //     }
            // })

        }

        function update_price(){
            //禁止按鈕重複點擊
            $("#btnsubmit").attr('disabled', true);

            let shop_id = $('#shop_id option:selected').val();
            let date = $('#date').val();

            if (shop_id == null || shop_id == 0) {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分店！",
                });
                $("#btncheck").attr('disabled', false);
                return false;
            }

            if (date === "" || date === undefined) {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇時間！",
                });
                $("#btncheck").attr('disabled', false);
                return false;
            }

            let url = '{{route('sales_data.sales_cal_results.store')}}';
            let type = 'POST';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'date'  : date,
                    'shop_id': shop_id,
                },
                dataType:'json',
                success: function (data) {
                    if(data.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showDenyButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '確定',
                            denyButtonText: '返回',
                        }).then((result) => {
                            if (result.isDenied) {

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

                },
                error: function (data) {
                    errors = data.responseJSON.errors;
                    let form_errors = '';
                    $.each(errors, function(i) {
                        form_errors += '<div>' + errors[i] + '</div>';
                    });
                    Swal.fire({
                        icon: 'warning',
                        title: form_errors,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '確定',
                    });
                }
            });

        }
    </script>
@endsection
