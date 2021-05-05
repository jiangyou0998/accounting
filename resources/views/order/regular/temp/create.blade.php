@extends('layouts.app')

@section('title')
    臨時加單
@stop

@section('js')
    <script src="/js/My97DatePicker/WdatePicker.js"></script>
@endsection

@section('style')
    <style type="text/css">

        body{
            margin-left: 40px;
            margin-right: 40px;
        }

        input.qty {
            width: 40%
        }

        input[type="checkbox"]{
            width: 30px; /*Desired width*/
            height: 30px; /*Desired height*/
        }

        .checkbox{
            font-size: 30px;
            margin-bottom: 10px;
        }

        .container {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
            width: 100%;
            max-width: 2000px;      // 隨螢幕尺寸而變，當螢幕尺寸 ≥ 1200px 時是 1140px。
        }

        .Wdate {
            height: 35px;
        }

        .style4 {
            color: #FF0000;
            font-size: 50px;
        }

        .style5 {
            font-size: medium;
            font-weight: bold;
        }

    </style>
@endsection

@section('content')
    <div class="container">


        <div align="left">
            <a target="_top" href="{{route('order.regular.sample', ['shop_group_id' => request()->shop_group_id])}}" style="font-size: xx-large;">返回</a>
        </div>

        <div class="style5" style="text-align: center;">
            <span class="style4">{{ \App\Models\ShopGroup::getShopGroupName(request()->shop_group_id) }}</span>
        </div>

        <div align="middle">
            <strong>
                <span style="color: #FF0000; font-size: xx-large">
                    {{$info->product_no}}&nbsp&nbsp{{$info->product_name}}&nbsp&nbsp臨時加單
                </span>
            </strong>
        </div>

        <div class="alert alert-warning" role="alert">
            點擊「提交」按鈕後，將替換現有下單數量，請確認無誤後再提交！<br>
            輸入數量必須大於0，數量小於等於0提交後不作修改！
        </div>

        <div align="left" style="padding-top: 15px;">
            <strong>
                <span style="color: #FF0000; font-size: 172%; ">選擇時間:</span>
            </strong>
            <div valign="middle" align="center">
                日期:
                {{--        <input type="text" name="checkDate" value="" id="datepicker"--}}
                {{--               onclick="WdatePicker({maxDate:'',isShowClear:false})" style="width:125px" readonly>--}}
                <input id="start" class="Wdate" type="text" value="{{request()->start}}" onclick="WdatePicker({maxDate:'#F{$dp.$D(\'end\')}'})" autocomplete="off"/>到
                <input id="end" class="Wdate" type="text" value="{{request()->end}}" onclick="WdatePicker({minDate:'#F{$dp.$D(\'start\')}'})" autocomplete="off"/>
            </div>
        </div>



        <br><br>
        <table class="table table-bordered table-hover">
            <h4>請填寫固定柯打內容</h4>

            @foreach($shops->chunk(20) as $chunk)
                <thead class="thead-dark">
                <tr>
                    @foreach($chunk as $shop)
                        <th>{{$shop->report_name}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody style="background-color: white">
                <tr>
                    @foreach($chunk as $shop)
                        <td><input class="qty" type="tel" style="width:50px;" data-id="{{$shop->id}}" value="{{$itemsArr[$shop->id][0]['qty'] ?? '' }}"></td>
                    @endforeach
                </tr>

                </tbody>
            @endforeach
        </table>

        <div>
            <button class="btnsubmit btn btn-primary btn-lg btn-block" id="btnsubmit" onclick="sss();">提交</button>
        </div>

        <br>

        @if(request()->shop_group_id == 1)
            <input id="dept" name="dept" type="hidden" value="F"/>
        @elseif(request()->shop_group_id == 5)
            <input id="dept" name="dept" type="hidden" value="RB"/>
        @else
            <input id="dept" name="dept" type="hidden" value="CU"/>
        @endif

        <input id="shopgroupid" name="shopgroupid" type="hidden" value="{{request()->shop_group_id}}">

    </div>



    <script>

        function sss() {

            //禁止按鈕重複點擊
            // $("#btnsubmit").attr('disabled', true);

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

            var insertarray = [];
            $(".qty").each(function () {
                var userid = $(this).data('id');
                var qty = $(this).val();
                // console.log($qty);
                if (qty > 0 && qty){
                    var item = {'userid': userid, 'qty': qty};
                    insertarray.push(item);
                }

            });

            // console.log(insertarray);
            // $("#btnsubmit").attr('disabled', false);
            // return false;

            var productid = {{request()->product_id ?? 0}};
            var type = 'POST';
            var url = '{{ route('order.regular.temp.store') }}';

            $.ajax({
                type: type,
                url: url,
                data: {
                    'start': start,
                    'end' : end,
                    'shop_group_id' : shop_group_id,
                    'dept' : dept,
                    'productid' : productid,
                    'insertData': JSON.stringify(insertarray)
                },
                success: function (msg) {
                    Swal.fire({
                        icon: 'success',
                        title: "臨時加單成功!",
                        showDenyButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '查看柯打',
                        denyButtonText: '返回',
                    }).then((result) => {
                        if (result.isDenied) {
                            //返回
                            window.location.href = '/order/regular/sample?shop_group_id=' + shop_group_id;
                        } else {
                            if(shop_group_id == 1){
                                window.open('/order/regular?start=' + start + '&end=' + end + '&dept=' + dept);
                            }else if(shop_group_id == 5){

                            }else{
                                window.open('/customer/order/select_old_order?start=' + start + '&end=' + end + '&dept=' + dept + '&shop_group_id=' + shop_group_id);
                            }

                        }

                    });
                }
            });

            // $("#btnsubmit").attr('disabled', false);


        }
    </script>





@endsection
