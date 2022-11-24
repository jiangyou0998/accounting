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
            font-size: 250%;
            align-self: center;
        }

    </style>

    <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
    <div class="" style="text-align: center;">
        <span class="style4">選擇外客分組</span>
        <br>
        <br>
            @foreach($shop_groups as $shop_group)
                <div>
                    <span class="style5">
                        <a href="{{route('customer.order.select_old_order' , ['dept' => 'CU', 'shop_group_id' => $shop_group->id])}}">{{$shop_group->name}}</a>
                        <a class="btn btn-danger" href="{{ route('order.regular.sample',['shop_group_id' => $shop_group->id]) }}">固定柯打</a>
                        <a class="btn btn-success" href="{{ route('order.order_import',['shop_group_id' => $shop_group->id]) }}">EXCEL落單</a>
                    </span>
                    <hr>
                </div>
            @endforeach
        <br>
        <br>

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
