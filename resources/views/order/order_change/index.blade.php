@extends('layouts.app')

@section('title')
    柯打改期
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

    </style>
@endsection

@section('content')
    <div class="container">


        <div align="left">
            <a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a>
        </div>



        <div align="left" style="padding-top: 15px;">
            <strong>
                <span style="color: #FF0000; font-size: 172%; ">選擇分店:</span>
            </strong>
        </div>

        {!! $checkHtml !!}

        <div class="row">

            <div class="col-md-4 mb-3">
                <label for="original_date">修改前日期</label>

                <input type="text" class="form-control layui-input d-block w-100" name="original_date" id="original_date" value="" autocomplete="off" required="">

                <div class="invalid-feedback">
                    請填寫「修改前日期」
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="target_date">修改後日期</label>

                <input type="text" class="form-control layui-input d-block w-100" name="target_date" id="target_date" value="" autocomplete="off" required="">

                <div class="invalid-feedback">
                    請填寫「修改後日期」
                </div>
            </div>

            <div class="col-md-4 mb-3">
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
            <button class="btnsubmit btn btn-primary btn-lg btn-block" id="btnsubmit" onclick="sss();">提交</button>
        </div>

        <br>

    </div>



    <script>

        // laydate初始化
        laydate.render({
            elem: '#original_date' //指定元素
        });

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
            let id = $(obj).data('id');
            if($(obj).prop("checked")){    //判斷check_all是否被選中
                $("input[class='shop']").prop("checked",true);//全選
                $("#spanss").html("取消");
            }else{
                $("input[class='shop']").prop("checked",false); //反選
                $("#spanss").html("全选");
            }
        }

        function sss() {

            //禁止按鈕重複點擊
            $("#btnsubmit").attr('disabled', true);

            var shopstr = $('#shopstr').val();
            var original_date = $('#original_date').val();
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

            if (original_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇修改前時間！",
                });
                $("#btnsubmit").attr('disabled', false);
                return false;
            }

            if (target_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇修改後時間！",
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

            let url = '{{route('order.change.modify')}}';
            let type = 'PUT';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'original_date'  : original_date,
                    'target_date'  : target_date,
                    'reason' : reason,
                    'shops': shopstr,
                },
                success: function (msg) {
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
                }
            });

            // $("#btnsubmit").attr('disabled', false);
        }
    </script>

@endsection
