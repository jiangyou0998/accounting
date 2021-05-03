@extends('layouts.app')

@section('title')
    固定柯打
@stop


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

    </style>
@endsection

@section('content')
    <div class="container">


        <div align="left">
            <a target="_top" href="{{route('order.regular.sample')}}" style="font-size: xx-large;">返回</a>
        </div>

        <div align="middle">
            <strong>
                <span style="color: #FF0000; font-size: xx-large">
                    {{$info->product_no}}&nbsp&nbsp{{$info->product_name}}&nbsp&nbsp固定柯打
                </span>
            </strong>
        </div>

        <div align="left" style="padding-top: 15px;">
            <strong>
                <span style="color: #FF0000; font-size: 172%; ">選擇星期:</span>
            </strong>
        </div>

        {!! $checkHtml !!}
        @if($sample->id)
            <input type="hidden" name="weekstr" id="weekstr" value="{{$currentdate ?? ''}}"/>
        @else
            <input type="hidden" name="weekstr" id="weekstr" value=""/>
        @endif


        <br><br>
        <table class="table table-bordered table-hover">
            <h4>請填寫固定柯打內容</h4>

            <thead class="thead-dark">
                <tr>
                    @foreach($shops as $shop)
                        <th>{{$shop->report_name}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody style="background-color: white">
                <tr>
                    @foreach($shops as $shop)
                        <td><input class="qty" type="tel" style="width:50px;" data-id="{{$shop->id}}" value="{{$itemsArr[$shop->id][0]['qty'] ?? '' }}"></td>
                    @endforeach
                </tr>

            </tbody>
        </table>

        <div>
            <button class="btnsubmit btn btn-primary btn-lg btn-block" id="btnsubmit" onclick="sss();">提交</button>
        </div>

        <br>

    </div>



    <script>
        //鉤選或取消時,修改weekstr(隱藏)的值
        $(document).on('change', 'input[type=checkbox]', function () {
            var weekstr = $('input[type=checkbox]:checked').map(function () {
                return this.value
            }).get().join(',');
            $('#weekstr').val(weekstr);
            // alert(weekstr);
        });

        function sss() {

            //禁止按鈕重複點擊
            $("#btnsubmit").attr('disabled', true);

            var weekstr = $('#weekstr').val();
            if (weekstr == "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇範本日期！",
                });
                $("#btnsubmit").attr('disabled', false);
                return false;
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

            var orderid = {{$sample->id ?? 0}};
            var productid = {{request()->product_id ?? 0}};
            var type = 'POST';

            var url = '';
            @if($sample->id)
                url = '{{route('order.regular.sample.update', $sample->id)}}';
                type = 'PUT';
            @else
                url = '{{route('order.regular.sample.store')}}';
            @endif


            $.ajax({
                type: type,
                url: url,
                data: {
                    'productid'  : productid,
                    'orderid' : orderid,
                    'orderdates': weekstr,
                    'insertData': JSON.stringify(insertarray)
                },
                success: function (msg) {
                    Swal.fire({
                        icon: 'success',
                        title: "固定柯打設置成功!",
                        showDenyButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '確定',
                        denyButtonText: '返回',
                    }).then((result) => {
                        if (result.isDenied) {
                            window.location.href = '{{route('order.regular.sample')}}';
                        } else {
                            window.location.reload();
                        }

                    });
                }
            });

            // $("#btnsubmit").attr('disabled', false);
        }
    </script>

@endsection
