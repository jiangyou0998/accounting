@extends('layouts.app')

@section('title')
    選擇日期
@stop

@section('js')
    <script src="/js/My97DatePicker/WdatePicker.js"></script>
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

        <input type="radio" name="dept" id="radio" value="A" @if(request()->dept == 'A') checked @endif>第一車
        <input type="radio" name="dept" id="radio" value="B" @if(request()->dept == 'B') checked @endif>第二車
        <input type="radio" name="dept" id="radio" value="C" @if(request()->dept == 'C') checked @endif>麵頭

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
                @if(request()->dept == 'A')
                    第一車
                @elseif(request()->dept == 'B')
                    第二車
                @elseif(request()->dept == 'C')
                    麵頭
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


