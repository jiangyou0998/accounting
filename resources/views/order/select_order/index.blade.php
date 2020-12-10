@extends('layouts.app')

@section('title')
    選擇日期
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
    <style type="text/css">

        body {
            background-color: #FFFFCC;
        }

        .style4 {
            font-size: 300%;
            color: red;
        }

        .red-font{
            color: #FF0000;
        }

    </style>

    <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
    <div class="style5" style="text-align: center;">
        <span class="style4">按日期修改訂單</span>

        <br>
        <br>

        <input type="radio" name="dept" id="radio" value="R" @if(request()->dept == 'R') checked @endif>烘焙
        <input type="radio" name="dept" id="radio" value="B" @if(request()->dept == 'B') checked @endif>水吧
        <input type="radio" name="dept" id="radio" value="K" @if(request()->dept == 'K') checked @endif>廚房
        <input type="radio" name="dept" id="radio" value="F" @if(request()->dept == 'F') checked @endif>樓面


    </div>

    <hr>
    <div valign="middle" align="center">
        日期:
        {{--        <input type="text" name="checkDate" value="" id="datepicker"--}}
        {{--               onclick="WdatePicker({maxDate:'',isShowClear:false})" style="width:125px" readonly>--}}
        <input id="start" class="Wdate" type="text" value="{{request()->start}}" onclick="WdatePicker({maxDate:'#F{$dp.$D(\'end\')}'})" autocomplete="off"/>到
        <input id="end" class="Wdate" type="text" value="{{request()->end}}" onclick="WdatePicker({minDate:'#F{$dp.$D(\'start\')}'})" autocomplete="off"/>
        <button class="btn btn-primary" onclick="opensupplier()">查詢</button>
    </div>

    {{--    查詢內容--}}
    <div class="container">
        <div class="py-5 text-center">

            <h2>
                @if(request()->dept == 'R')
                    烘焙
                @elseif(request()->dept == 'B')
                    水吧
                @elseif(request()->dept == 'K')
                    廚房
                @elseif(request()->dept == 'F')
                    樓面
                @endif

            </h2>
            {{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
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
                    @include('order.select_order._table_data')
                    </tbody>
                </table>

            </div>
        </div>


        @endsection

        @section('script')
            <script>
                function opensupplier() {
                    var Obj = document.getElementsByName("dept");
                    var bool = false;
                    for (var i = 0; i < Obj.length; i++) {
                        if (Obj[i].checked == true) {
                            bool = true;
                            break;
                        }
                    }

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

                    if (bool) {
                        window.location.href = "{{route('order.select_old_order')}}"+"?dept=" + Obj[i].value + "&start=" + start + "&end=" + end ;
                        //this.close();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: "請先選擇部門",
                        });
                    }

                }

            </script>

        @endsection


