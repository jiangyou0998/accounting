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
        }

        .red-font{
            color: #FF0000;
        }

    </style>

    <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
    <div class="style5" style="text-align: center;">
        <span class="style4">請選</span>
        <span class="style4 red-font">送貨日</span>
        <span class="style4">及</span>
        <span class="style4 red-font">部門</span>

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


        <input type="radio" name="dept" id="radio" value="B" checked>蛋撻王工場


    </div>
    <table class="table table-bordered border-dark" width="100%" border="2" align="center" cellpadding="3" cellspacing="0">
        @foreach($dayArray as $key => $day)
        <tr class="daylist" >
            <td align="right" width="48%"><strong>{{$day['desc']}}</strong></td>
            <td align="left" width="52%">
                <div>

                </div>
                <a
                    href="javascript:opencart('{{$day['deli_date']}}');"><strong>{{$day['dayStr']}}</strong></a>
            </td>
        </tr>
        @endforeach
    </table>
    <br>
    <div class="style3" style="text-align: center;">
        <span class="style4">不同送貨日</span>
        <span class="style4 red-font">必須</span>
        <span class="style4">分單</span>
    </div>

@endsection

@section('script')
    <script>
        function opencart(deli_date) {
            // console.log(deli_date);return;
            var Obj = document.getElementsByName("dept");
            var bool = false;
            for (var i = 0; i < Obj.length; i++) {
                if (Obj[i].checked == true) {
                    bool = true;
                    break;
                }
            }
            var shop = 0;

            @if(Auth::user()->can('workshop') or Auth::user()->can('operation'))
            if ((shop = $("#shop").val()) == '0') {
                // alert("請先選擇分店");
                Swal.fire({
                    icon: 'warning',
                    title: "請先選擇分店",
                });
                return;
            }
            @endif

            if (bool) {
                location.href = "{{route('kb.cart')}}"+"?shop=" + shop + "&dept=" + Obj[i].value + "&deli_date=" + deli_date;
                //this.close();
            } else {
                // alert("請先選擇部門");
                Swal.fire({
                    icon: 'warning',
                    title: "請先選擇部門",
                });
            }

        }

    </script>

@endsection
