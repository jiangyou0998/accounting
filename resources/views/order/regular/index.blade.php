@extends('layouts.app')

@section('title')
    批量下單
@stop

@section('js')
    <script src="/js/My97DatePicker/WdatePicker.js"></script>
@endsection

@section('style')
    <style>
        .Wdate {
            height: 35px;
        }

        .container {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
            width: 100%;
            max-width: 2000px;      // 隨螢幕尺寸而變，當螢幕尺寸 ≥ 1200px 時是 1140px。
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
            <h2>批量下單</h2>
            <input type="radio" name="dept" id="dept" value="F" @if(request()->dept == 'F') checked @endif>樓面
            <div class="alert alert-danger" role="alert">
                批量操作會為未下單日進行批量下單<br>
                已下單日將不會下單
            </div>
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

        <input id="shopgroupid" name="shopgroupid" type="hidden" value="{{request()->shop_group_id}}">
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
            var shop_group_id = $("#shopgroupid").val();
            var dept = $("#dept").val();

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

            if(dept == ""){
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇部門",
                });
                return;
            }

            window.location.href = "{{route('order.regular')}}" + "?start=" + start + "&end=" + end + "&dept=" + dept + "&shop_group_id=" + shop_group_id;

        }

        function order() {
            var start = $("#start").val();
            var end = $("#end").val();
            var shop_group_id = $("#shopgroupid").val();
            var dept = $("#dept").val();

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

            if(dept == ""){
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇部門",
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
                            'end' : end,
                            'shop_group_id' : shop_group_id,
                            'dept' : dept
                        },
                        success: function (msg) {
                            if (msg) {
                                alert('發生錯誤！請關閉頁面重新進入\n');
                                console.log(msg);
                            } else {
                                // alert('已確認收貨!\n');
                                window.location.href = "{{route('order.regular')}}" + "?start=" + start + "&end=" + end + "&dept=" + dept+ "&shop_group_id=" + shop_group_id;
                            }
                        }
                    });
                }

            });

        }

    </script>

@endsection
