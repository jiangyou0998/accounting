@extends('layouts.app')

@section('js')
    <link href="https://cdn.bootcss.com/bootstrap-switch/4.0.0-alpha.1/css/bootstrap-switch.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.min.js"></script>
    <script src="../layui/layui.all.js"></script>
@endsection

@section('content')

    <div class="alert-message">
        <ul class="error-content">

        </ul>
    </div>

    <div class="container">
        <div class="py-5 text-center">
            <h2>維修員開單</h2>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">分店/用戶</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $shop_name  }}">
            </div>
        </div>

        <hr>

        <div id="row">
            <form class="form-horizontal" role="form" id="order-form">
                {{ csrf_field() }}
                <div class="col-md-12 order-md-1">

                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">日期</th>
                            <th scope="col">位置</th>
                            <th scope="col">維修項目</th>
                            <th scope="col">求助事宜</th>
                            <th scope="col">跟進結果</th>
                            <th scope="col">完成進度</th>

                        </tr>
                        </thead>
                        <tbody class="table-striped" style="background-color: white">

                        @foreach($order_items as $value)
                            <tr data-id="{{ $value->id }}">
                                <td width="10%">{{ $loop->iteration }}</td>
                                <td scope="row" width="20%">{{ $value->created_at }}</td>
                                <td width="10%">{{ $value->locations->name ?? '' }}</td>
                                <td width="10%">{{ $value->items->name ?? '' }}</td>
                                <td width="10%">{{ $value->details->name ?? '' }}</td>
                                <td width="10%">
                                    <textarea type="textarea" name="comment" cols="20" row="20"></textarea>
                                </td>
                                <td width="15%">
                                    <input style="margin-right: 5px;" name="status" type="checkbox" checked>
                                </td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>

                <hr>

                <input type="text" class="form-control" id="shop_id" name="shop_id" value="{{ $shop_id }}" hidden>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">完成日期</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="complete_date" name="complete_date"
                               autocomplete="off" placeholder="請選擇日期" value="{{ old('complete_date') }}"
                               style="background-color:white;" readonly required>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">到店時間(24小時制)</label>
                    <div class="col">

                        <input type="number" class="form-control"
                               id="start_hour" name="start_hour"
                               min="0" max="23"
                               autocomplete="off" value="{{ old('start_hour') }}" required>
                    </div>
                    時
                    <div class="col">
                        <input type="number" class="form-control"
                               id="start_minute" name="start_minute"
                               min="0" max="59"
                               autocomplete="off" value="{{ old('start_minute') }}" required>
                    </div>
                    分
                </div>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">離開時間(24小時制)</label>
                    <div class="col">
                        <input type="number" class="form-control"
                               id="end_hour" name="end_hour"
                               min="0" max="23"
                               autocomplete="off" value="{{ old('end_hour') }}" required>
                    </div>
                    時
                    <div class="col">
                        <input type="number" class="form-control"
                               id="end_minute" name="end_minute"
                               min="0" max="59"
                               autocomplete="off" value="{{ old('end_minute') }}" required>
                    </div>
                    分
                </div>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">維修員</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="handle_staff" name="handle_staff" autocomplete="off"
                               placeholder="維修員" value="{{ old('handle_staff') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">維修費用</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="fee" name="fee" autocomplete="off"
                               placeholder="$" min="0" value="{{ old('fee') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <button type="button" class="btn btn-primary btn-block btn-create-order">提交</button>

                </div>

            </form>

        </div>

@endsection

@section('script')
    <script>
        layui.use(['laydate'], function () {

            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#complete_date' //指定元素
            });

        });

        //完成進度Switch實例化
        $('[name="status"]').bootstrapSwitch({    //初始化按钮
            onText:"已完成",
            offText:"未完成",
            onColor:"success",
            offColor:"info",
            size:"small",
            onSwitchChange:function(event,state){
                if(state==true){
                    console.log("开启");
                }else{
                    console.log("关闭");
                }
            }
        });

        // 监听创建订单按钮的点击事件
        // $(document).on('click', '.btn-create-order', function () {
        $('.btn-create-order').click(function () {

            // 构建请求参数，将用户选择的維修項目 ,維修員 和 維修費用 写入请求参数
            var req = {
                items: [],
                shop_id : $('#shop_id').val(),
                complete_date: $('#complete_date').val(),
                start_hour: $('#start_hour').val(),
                start_minute: $('#start_minute').val(),
                end_hour: $('#end_hour').val(),
                end_minute: $('#end_minute').val(),
                handle_staff: $('#handle_staff').val(),
                fee: $('#fee').val(),
            };

            // 遍历 <table> 标签内所有带有 data-id 属性的 <tr> 标签，也就是每一個維修項目
            $('table tr[data-id]').each(function () {
                // 获取当前行中数量输入框
                var $comment = $(this).find('textarea[name=comment]');
                var $status = $(this).find('input[name=status]');

                // 把 SKU id 和数量存入请求参数数组中
                req.items.push({
                    id: $(this).data('id'),
                    comment: $comment.val(),
                    status: $status.bootstrapSwitch('state'),
                })
            });

            // console.log(req);return;
            {{--axios.post('{{ route('repair_order.store') }}', req)--}}
            {{--    .then(function (response) {--}}
            {{--        swal('订单提交成功', '', 'success')--}}
            {{--            .then(() => {--}}
            {{--                // location.href = '/orders/' + response.data.id;--}}
            {{--            });--}}
            {{--    }, function (error) {--}}
            {{--        // if (error.response.status === 422) {--}}
            {{--        //     // http 状态码为 422 代表用户输入校验失败--}}
            {{--        //     var html = '<div>';--}}
            {{--        //     _.each(error.response.data.errors, function (errors) {--}}
            {{--        //         _.each(errors, function (error) {--}}
            {{--        //             html += error+'<br>';--}}
            {{--        //         })--}}
            {{--        //     });--}}
            {{--        //     html += '</div>';--}}
            {{--        //     swal({content: $(html)[0], icon: 'error'})--}}
            {{--        // } else if (error.response.status === 403) { // 这里判断状态 403--}}
            {{--        //     swal(error.response.data.msg, '', 'error');--}}
            {{--        // } else {--}}
            {{--        //     // 其他情况应该是系统挂了--}}
            {{--        //     swal('系统错误', '', 'error');--}}
            {{--        // }--}}
            {{--    });--}}

            $.ajax({
                type: "POST",
                url: "{{route('repair_order.store')}}",
                data: req,
                success: function() {
                    $('.error-content').html('');
                    $('<div>').appendTo('.error-content').addClass('form_alert alert-success').html('保存成功').show().delay(1000).fadeOut();
                    window.location.href = '{{ route('repair.phone') }}';
                },
                error: function(res) {
                    errors = res.responseJSON.errors;
                    var form_errors = '';
                    $.each(errors, function(i) {
                        form_errors += '<div>' + errors[i] + '</div>';
                    });
                    $('.error-content').html('');
                    $('<div>').appendTo('.error-content').addClass('form_alert alert-danger').html(form_errors).show();
                },
            });

        });
    </script>
@endsection
