@extends('layouts.app')

@section('content')

    <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
    <center class="style5">
        請選<span class="style4">送貨日</span>及<span class="style4">部門</span>



        @if(Auth::user()->can('workshop') or Auth::user()->can('operation'))
            <br>
            <br>
            落貨分店
        <select class="custom-select d-block w-25" id="shop" required>
            <option value="0">請選擇分店</option>
            @foreach($shops as $shop)
                <option value="{{$shop->id}}">{{$shop->report_name}}</option>
            @endforeach
        </select>
        @endif
        <br>
        <br>

        <input type="radio" name="dept" id="radio" value="R" checked>烘焙
        <input type="radio" name="dept" id="radio" value="B">水吧
        <input type="radio" name="dept" id="radio" value="K">廚房
        <input type="radio" name="dept" id="radio" value="F">樓面
    </center>
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
    <center class="style3">不同送貨日<span class="style4">必須</span>分單</center>

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
                alert("請先選擇分店");
                return;
            }
            @endif

            if (bool) {
                location.href = "{{route('cart')}}"+"?shop=" + shop + "&dept=" + Obj[i].value + "&deli_date=" + deli_date;
                //this.close();
            } else {
                alert("請先選擇部門");
            }

        }

    </script>

@endsection
