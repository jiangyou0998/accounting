@extends('layouts.app')

@section('title')
    柯打全單刪除
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

        input[type="checkbox"]{
            width: 30px; /*Desired width*/
            height: 30px; /*Desired height*/
        }

        .checkbox{
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
            <span class="style4">柯打批量<span class="style6">全單刪除</span></span>
        </div>

        <div align="left" style="padding-top: 15px;">
            <strong>
                <span style="color: #FF0000; font-size: 172%; ">選擇分店:</span>
            </strong>
        </div>

        {!! $checkHtml !!}

        <div class="row">

            <div class="col-md-6 mb-3">
                <label for="target_date">刪除日期</label>

                <input type="text" class="form-control layui-input d-block w-100" name="target_date" id="target_date" value="" autocomplete="off" required="">

                <div class="invalid-feedback">
                    請填寫「刪除日期」
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="reason">原因</label>
                <input type="text" class="form-control" name="reason" id="reason" value="" autocomplete="off" placeholder="" required="">
                <div class="invalid-feedback">
                    請填寫「原因」
                </div>
            </div>

        </div>

        <input type="hidden" name="shopstr" id="shopstr" value=""/>

        <br><br>

        <div>
            <button class="btnsubmit btn btn-danger btn-lg btn-block" id="btnsubmit" onclick="sss();">批量全單刪除</button>
        </div>

        <br>
        <div>
            <button class="btnsubmit btn btn-primary btn-lg btn-block" id="btnrollback" onclick="rollback();">批量全單恢復</button>
        </div>

        <br>

    </div>



    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // laydate初始化
        laydate.render({
            elem: '#target_date' //指定元素
        });

        //鉤選或取消時,修改shopstr(隱藏)的值
        $(document).on('change', 'input[type=checkbox]', function () {
            var shopstr = $('input[type=checkbox][class=\'shop\']:checked').map(function () {
                return this.value
            }).get().join(',');
            $('#shopstr').val(shopstr);
            // alert(shopstr);
        });

        //全選/反選
        function checkAll(obj){
            let group = $(obj).data('group');
            if($(obj).prop("checked")){    //判斷check_all是否被選中
                $("input[class='shop'][data-group=" + group +"]").prop("checked",true);//全選
                $("#spanss").html("取消");
            }else{
                $("input[class='shop'][data-group=" + group +"]").prop("checked",false); //反選
                $("#spanss").html("全选");
            }
        }

        function sss() {

            //禁止按鈕重複點擊
            $("#btnsubmit").attr('disabled', true);

            var shopstr = $('#shopstr').val();
            var target_date = $('#target_date').val();
            var reason = $('#reason').val();
            if (shopstr == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分店！",
                });
                $("#btnsubmit").attr('disabled', false);
                return false;
            }

            if (target_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇刪除時間！",
                });
                $("#btnsubmit").attr('disabled', false);
                return false;
            }

            if (reason == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請填寫原因！",
                });
                $("#btnsubmit").attr('disabled', false);
                return false;
            }

            let url = '{{route('order.order_delete.delete')}}';
            let type = 'DELETE';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'target_date'  : target_date,
                    'reason' : reason,
                    'shops': shopstr,
                },
                dataType:'json',
                success: function (data) {
                    if(data.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: "柯打刪除成功!",
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
                        $("#btnsubmit").attr('disabled', false);
                    }

                },
                error:function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: '出現錯誤，請嘗試刷新頁面！',
                        showDenyButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '確定',
                        denyButtonText: '返回',
                    });
                    $("#btnsubmit").attr('disabled', false);
                }
            });

            // $("#btnsubmit").attr('disabled', false);
        }

        function rollback() {

            //禁止按鈕重複點擊
            $("#btnrollback").attr('disabled', true);

            var shopstr = $('#shopstr').val();
            var target_date = $('#target_date').val();
            var reason = $('#reason').val();
            if (shopstr == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分店！",
                });
                $("#btnrollback").attr('disabled', false);
                return false;
            }

            if (target_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇刪除時間！",
                });
                $("#btnrollback").attr('disabled', false);
                return false;
            }

            if (reason == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請填寫原因！",
                });
                $("#btnrollback").attr('disabled', false);
                return false;
            }

            let url = '{{route('order.order_delete.rollback')}}';
            let type = 'POST';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'target_date'  : target_date,
                    'reason' : reason,
                    'shops': shopstr,
                },
                dataType:'json',
                success: function (data) {
                    if(data.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: "柯打恢復成功!",
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
                        $("#btnrollback").attr('disabled', false);
                    }

                },
                error:function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: '出現錯誤，請嘗試刷新頁面！',
                        showDenyButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '確定',
                        denyButtonText: '返回',
                    });
                    $("#btnsubmit").attr('disabled', false);
                }
            });

            // $("#btnsubmit").attr('disabled', false);
        }
    </script>

@endsection
