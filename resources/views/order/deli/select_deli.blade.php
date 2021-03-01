@extends('layouts.app')

@section('content')
    <style type="text/css">

        body {
            background-color: #FFFFCC;
        }

        .style4 {
            color: #FF0000;
            font-size: 300%;
        }

        .style5 {
            font-size: 160%;
            align-self: center;
        }

    </style>

    <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
    <div class="" style="text-align: center;">
        <span class="style4">送貨單查詢</span>
        <br>
        <br>

            <span class="style5">蛋撻王:</span>
            <select class="custom-select w-25" id="shop" required>
                <option value="0">請選擇分店</option>
                @foreach($shops as $shop)
                    <option value="{{$shop->id}}">{{$shop->report_name}}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" onclick="opensupplier()">查詢</button>

        <br>
        <br>

        <span class="style5">糧友:</span>
        <select class="custom-select w-25" id="rbshop" required>
            <option value="0">請選擇分店</option>
            @foreach($rbshops as $shop)
                <option value="{{$shop->id}}">{{$shop->report_name}}</option>
            @endforeach
        </select>
        <button class="btn btn-primary" onclick="openrbsupplier()">查詢</button>

    </div>


@endsection

@section('script')
    <script>
        function opensupplier() {

            var shop = $("#shop").val();
            if (shop == '0') {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分店",
                });
                return;
            }

            window.open("/order/deli?shop=" + shop);

        }

        function openrbsupplier() {

            var shop = $("#rbshop").val();
            if (shop == '0') {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分店",
                });
                return;
            }

            window.open("/order/deli?shop=" + shop + "&group=rb");

        }
    </script>
@endsection
