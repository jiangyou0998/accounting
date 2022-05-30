@extends('layouts.app')

@section('title')
    營業數修改申請
@stop

@section('content')

<div class="container">
    <div class="py-5 text-center">
        <div align="left"><a target="_top" href="{{route('sales_data')}}" style="font-size: xx-large;">返回今天營業數錄入</a></div>

        <h2>營業數修改申請</h2>
{{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
    </div>
    <div class="row">
        <div class="col-md-12 order-md-1" id="page-wrapper">

                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="country">申請時間</label>
                        <input class="custom-select d-block w-100" type="date" max="{{\Carbon\Carbon::now()->subDay()->toDateString()}}" name="date" id="date" required="">

                    </div>

                </div>
                <hr class="mb-4">

                <div class="row">
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block btn-submit" id="submit">提交申請</button>
                    <hr class="mb-4">
                </div>

        </div>

        <div class="col-md-12 order-md-1" style="padding-top: 30px">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">申請日期</th>
{{--                    <th scope="col">編號</th>--}}
                    <th scope="col">處理日期</th>
                    <th scope="col">申請狀態</th>
                    <th scope="col">修改</th>
                </tr>
                </thead>
                <tbody class="table-striped" style="background-color: white">
                @foreach($datas as $data)
                <tr>
                    <td>{{$data->date}}</td>
                    <td>{{$data->handle_date}}</td>
                    @if($data->status === 0)
                        <td>
                            <i class="fa fa-circle" style="font-size: 13px;color: #dda451"></i>&nbsp;&nbsp;申請中
                        </td>
                    @elseif($data->status === 1)
                        <td>
                            <i class="fa fa-circle" style="font-size: 13px;color: #21b978"></i>&nbsp;&nbsp;已批准
                        </td>
                    @elseif($data->status === 2)
                        <td>
                            <i class="fa fa-circle" style="font-size: 13px;color: #ea5455"></i>&nbsp;&nbsp;未批准
                        </td>
                    @endif

                    <td>
                        @if($data->status === 1)
                            <a href="{{route('sales_data', ['date' => $data->date])}}">前往修改</a>
                        @endif
                    </td>
                </tr>

                @endforeach
                </tbody>
            </table>
{{--            {{$notices->appends(['dept' => request()->dept ,'search' => $search])->links()}}--}}
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('.btn-submit').click(function () {

            let date = $('#date').val();
            //存入銀行填寫後必須選擇銀行
            if(date === ''){
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇「申請時間」!",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: '確定',
                })
                return;
            }

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
                    if (errors){
                        form_errors = '';
                    }
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
