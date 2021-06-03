@extends('layouts.app')

@section('title')
    @if(request()->shop_group_id == 5)
        臨時加單
    @else
        固定柯打
    @endif
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


@section('content')

    <style type="text/css">
        <!--
        body {
            background-color: #FFFFCC;
        }

        .style4 {
            color: #FF0000;
            font-size: 50px;
        }

        .style5 {
            font-size: medium;
            font-weight: bold;
        }

        .sizefont {
            font-size: 130%;
        }

        -->
    </style>



    @if(in_array($shop_group_id, [1,5]))
        <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
    @else
        <div align="left"><a target="_top" href="{{route('customer.select_group')}}" style="font-size: xx-large;">返回</a></div>
    @endif

    <div class="style5" style="text-align: center;">
        <span class="style4">{{ \App\Models\ShopGroup::getShopGroupName(request()->shop_group_id) }}</span>
    </div>

    <div class="style5" style="text-align: center;">
        <span class="style4">
            @if(request()->shop_group_id == 5)
                臨時加單
            @else
                固定柯打
            @endif
        </span>
    </div>

    <hr>
    <div align="middle">
        <select class="product" id="product" name="product" style="min-width: 30%">
            <option value="">-- 請選擇貨品 --</option>
            @foreach($codeProductArr as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        @if(request()->shop_group_id != 5)
        <button class="btn btn-primary" onclick="addsample()">新增</button>
        @endif
        <button class="btn btn-danger" onclick="addtemp()">臨時加單</button>
    </div>
    <hr>

{{--固定柯打部分--}}

    @foreach($samples as $key => $items)
        @if(isset($productArr[$key]))
        <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
            <div class="style5" style="text-align: center;">
                <span class="style4">{{$productArr[$key]}}</span>
            </div>
            <div style="margin-bottom: 10px;">
                <button class="sizefont"><a class="btn btn-primary" href="{{route('order.regular.sample.create',['product_id'=> $key , 'shop_group_id' => $shop_group_id])}}">新建「{{$productArr[$key]}}」固定柯打</a></button>
            </div>
            @foreach($items as $sample)

                <tr style="margin-top: 60px" class="sizefont">
                    <td align="right" width="4%"><strong>#</strong></td>

                    <td align="left"><a
                            href="{{route('order.regular.sample.edit',$sample->id)}}"><strong>{{$sample->orderdates}}</strong></a>
                    </td>
                    <td align="middle" width="10%"><strong>
                            <button onclick="delsample({{$sample->id}});">刪除範本</button>
                        </strong></td>
                </tr>

            @endforeach
        </table>
        @endif
    @endforeach


    <br>
    {{--固定柯打部分--}}

    <script>
        $(document).ready(function() {
            $('.product').select2();
        });

        function addsample(){
            // alert($('#product').val());
            let shop_group_id = {{ $shop_group_id ?? 0 }};
            if($('#product').val()){
                window.location.href = "/order/regular/sample/create?product_id=" + $('#product').val() + "&shop_group_id=" + shop_group_id;
            }else{
                Swal.fire({
                    icon: 'error',
                    title: "請選擇貨品！",
                });
            }
        }

        //臨時加單
        function addtemp(){
            // alert($('#product').val());
            let shop_group_id = {{ $shop_group_id ?? 0 }};
            if($('#product').val()){
                window.location.href = "/order/regular/temp/create?product_id=" + $('#product').val() + "&shop_group_id=" + shop_group_id;
            }else{
                Swal.fire({
                    icon: 'error',
                    title: "請選擇貨品！",
                });
            }
        }

        function delsample(id) {

            Swal.fire({
                title: "您確定要刪除該範本嗎?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '刪除',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "/order/regular/sample/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (msg) {
                            // console.log(msg);
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: "範本刪除成功!",
                            // });

                            Swal.fire({
                                title: "範本刪除成功!",
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: '確定'
                            }).then((result) => {
                                window.location.reload();
                            })

                        },
                        error: function (msg) {
                            // console.log(msg);
                            Swal.fire({
                                icon: 'error',
                                title: "刪除失敗!",
                            });
                        }
                    });
                }
            })

        }
    </script>

@endsection
