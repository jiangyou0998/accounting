@extends('layouts.app')

@section('title')
    固定柯打
@stop

@section('js')
    <script src="/js/My97DatePicker/WdatePicker.js"></script>
@endsection

@section('style')
    <style>
        .Wdate {
            height: 35px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="py-5 text-center">

            <h2>固定柯打</h2>
            <div valign="middle" align="center">
                日期:
                <input id="start" class="Wdate" type="text" value="{{request()->start}}" onclick="WdatePicker({minDate:'%y-%M-{%d+1}',maxDate:'#F{$dp.$D(\'end\')}'})" autocomplete="off"/>到
                <input id="end" class="Wdate" type="text" value="{{request()->end}}" onclick="WdatePicker({minDate:'#F{$dp.$D(\'start\')}'})" autocomplete="off"/>
                <button class="btn btn-primary" onclick="search()">查詢</button>
                <button class="btn btn-danger" onclick="order()">批量下單</button>
            </div>

        </div>
        <div class="row">

            <div class="col-md-12 order-md-1">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        @foreach($shop_names as $shop_name)
                            <th scope="col">{{$shop_name}}</th>
                        @endforeach

                    </tr>
                    </thead>
                    <tbody class="table-striped" style="background-color: white">
                        @include('order.regular._table_data')
                    </tbody>
                </table>

            </div>
        </div>


@endsection

@section('script')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function search() {

            var start = $("#start").val();
            var end = $("#end").val();

            if(start == ""){
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇開始日期",
                });
                return;
            }

            if(end == ""){
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇結束日期",
                });
                return;
            }

            window.location.href = "{{route('order.regular')}}" + "?start=" + start + "&end=" + end;

        }

        function order() {
            var start = $("#start").val();
            var end = $("#end").val();

            if(start == ""){
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇開始日期",
                });
                return;
            }

            if(end == ""){
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇結束日期",
                });
                return;
            }

            Swal.fire({
                icon: 'warning',
                title: "確定要批量下單嗎?",
                html: "下單時間: " + start + " 到 " + end + "</br></br>" + "批量操作會為未下單日進行批量下單" + "</br>" + "已下單日將不會下單",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: '確定',
                cancelButtonText: '返回',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('order.regular.store')}}",
                        data: {
                            'start': start,
                            'end' : end
                        },
                        success: function (msg) {
                            if (msg) {
                                alert('發生錯誤!\n');
                                console.log(msg);
                            } else {
                                // alert('已確認收貨!\n');
                                window.location.href = "{{route('order.regular')}}" + "?start=" + start + "&end=" + end;
                            }
                        }
                    });
                }

            });

        }

    </script>

@endsection
