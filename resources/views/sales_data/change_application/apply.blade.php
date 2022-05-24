@extends('layouts.app')

@section('title')
    營業數申請批准
@stop

@section('content')

<div class="container">
    <div class="py-5 text-center">

        <h2>營業數申請批准</h2>
{{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
    </div>
    {{--        申請中數據--}}
    <div class="row">
        @foreach($applying_datas as $data)
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <div class="card-body">
                        <h3><p class="card-text">{{$shop_names[$data->shop_id]}}</p></h3>
                        <h4><p class="card-text">修改時間 {{ $data->date }}</p></h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-lg btn-success btn-agree" data-id="{{ $data->id }}">批准</button>
                                <button type="button" class="btn btn-lg btn-danger btn-disagree" data-id="{{ $data->id }}">拒絕</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{--            今日處理的數據--}}
    <hr>
    <h2>今日處理的申請批准</h2>
    <div class="row">
        @foreach($today_handled_datas as $data)
            <div class="col-md-4">
                <div class="card mb-4 text-white bg-secondary box-shadow">
                    <div class="card-body">
                        <h3><p class="card-text">{{$shop_names[$data->shop_id]}}</p></h3>
                        <h4><p class="card-text">修改時間 {{ $data->date }}</p></h4>
                        @if($data->status === 1)
                            <h4>
                                <p class="card-text"><i class="fa fa-circle" style="color: #21b978"></i>已批准</p>
                            </h4>
                        @elseif($data->status === 2)
                            <h4>
                                <p class="card-text "><i class="fa fa-circle" style="color: #ea5455"></i>已拒絕</p>
                            </h4>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-lg btn-success btn-agree" data-id="{{ $data->id }}">批准</button>
                                <button type="button" class="btn btn-lg btn-danger btn-disagree" data-id="{{ $data->id }}">拒絕</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    </div>

@endsection

@section('script')
    <script>
        $('.btn-agree').click(function () {

            let id = $(this).data('id');

            Swal.fire({
                title: "是否「批准」修改申請?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '同意',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('sales_data_change_application.apply' )}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : {
                            'status'    : 1,
                            'id'        : id,
                        },
                        success: function (msg) {

                            Swal.fire({
                                title: "已成功「批准」修改申請!",
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: '確定'
                            }).then((result) => {
                                window.location.reload();
                            })

                        },
                        error: function (msg) {
                            // console.log(msg);
                            Swal.fire({
                                icon: 'error',
                                title: "操作失敗!",
                            });
                        }
                    });

                }
            })
        });

        $('.btn-disagree').click(function () {

            let id = $(this).data('id');

            Swal.fire({
                title: "是否「拒絕」修改申請?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '拒絕',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('sales_data_change_application.apply' )}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : {
                            'status'    : 2,
                            'id'        : id,
                        },
                        success: function (msg) {

                            Swal.fire({
                                title: "已成功「拒絕」修改申請!",
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: '確定'
                            }).then((result) => {
                                window.location.reload();
                            })

                        },
                        error: function (msg) {
                            // console.log(msg);
                            Swal.fire({
                                icon: 'error',
                                title: "操作失敗!",
                            });
                        }
                    });

                }
            })
        });

        $('.btn-submit').click(function () {

            $('.btn-submit').attr('disabled', true);

            $.ajax({
                type: "POST",
                url: "{{route('sales_data_change_application.store')}}",
                data: { date: date },
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        title: "已提交修改申請!",
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '確定',
                    }).then((result) => {
                        window.location.reload();
                    });
                    $('.btn-submit').attr('disabled', false);
                },
                error: function(res) {
                    errors = res.responseJSON.errors;
                    message = res.responseJSON.message;
                    let form_errors = '<div>' + message + '</div>';
                    $.each(errors, function(i) {
                        form_errors += '<div>' + errors[i] + '</div>';
                    });
                    Swal.fire({
                        icon: 'warning',
                        title: form_errors,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '確定',
                    });
                    $('.btn-submit').attr('disabled', false);
                },
            });

        });
    </script>
@endsection
