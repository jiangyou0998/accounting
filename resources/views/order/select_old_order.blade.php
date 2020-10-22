@extends('layouts.app')

@section('title')
    選擇日期
@stop

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


    @if(Auth::user()->can('workshop') or Auth::user()->can('operation'))
            <br>
            <br>
            落貨分店
        <select class="custom-select w-25" id="shop" required>
            <option value="0">請選擇分店</option>
            @foreach($shops as $shop)
                <option value="{{$shop->id}}">{{$shop->report_name}}</option>
            @endforeach
        </select>
    @endif
        <br>
        <br>

        <input type="radio" name="dept" id="radio" value="A" checked>第一車
        <input type="radio" name="dept" id="radio" value="B">第二車
        <input type="radio" name="dept" id="radio" value="C">麵頭

    </div>

    <hr>
    <div valign="middle" align="center">
        日期:
        <input type="text" name="checkDate" value="" id="datepicker"
               onclick="WdatePicker({maxDate:'',isShowClear:false})" style="width:125px" readonly>

        <button class="btn btn-primary" onclick="opensupplier()">查詢</button>
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
            var shop = $("#shop").val();
            var deli_date = $("#datepicker").val();

            // alert(deli_date);return;
            if (shop == '0') {
                Swal.fire({
                    icon: 'warning',
                    title: "請先選擇分店",
                });
                return;
            }

            if (!deli_date) {
                Swal.fire({
                    icon: 'warning',
                    title: "請先選擇日期",
                });
                return;
            }

            if (bool) {
                window.open("{{route('cart')}}"+"?shop=" + shop + "&dept=" + Obj[i].value + "&deli_date=" + deli_date);
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

@section('js')
    <script src="/js/My97DatePicker/WdatePicker.js"></script>
@endsection
