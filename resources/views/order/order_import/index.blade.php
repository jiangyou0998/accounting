@extends('layouts.app')

@section('js')
{{--    bootstrap-fileinput--}}
    <link href="/vendors/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <link href="/vendors/bootstrap-fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet"
          type="text/css"/>
    <script src="/vendors/bootstrap-fileinput/js/plugins/piexif.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/js/locales/zh-TW.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/themes/fas/theme.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/themes/explorer-fas/theme.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('style')
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
@endsection

@section('content')

    <div class="container">

{{--        返回按鈕--}}
        @if(in_array(request()->shop_group_id, [1,5]))

        @else
            <div align="left"><a target="_top" href="{{route('customer.select_group')}}" style="font-size: xx-large;">返回</a></div>
        @endif
{{--        返回按鈕--}}

{{--        標題--}}
        <div class="style5" style="text-align: center;">
            <span class="style4">{{ \App\Models\ShopGroup::getShopGroupName(request()->shop_group_id) }}</span>
        </div>

        <div class="style5" style="text-align: center;">
            <span class="style4">柯打導入</span>
        </div>

        <div align="middle"><a target="_top" href="#" onclick="window.location.reload(true);" style="font-size: xx-large;">重新輸入</a></div>
{{--        標題--}}

        <div id="page-wrapper">
            <form class="needs-validation" novalidate="" method="post" action="{{route('order.order_import.result')}}" enctype="multipart/form-data">
                @csrf
                <hr class="mb-4">

                <div class="row">

                    <input type="text" class="form-control" name="shop_group_id" id="cc-shop_group_id"
                          value="{{request()->shop_group_id}}" placeholder="" hidden>

                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shop">分店</label>
                                <div>
                                    <select class="shop" id="shop" name="shop" style="min-width: 100%; min-height: 100%;">
                                        <option value="">-- 請選擇分店 --</option>
                                        @foreach($shops as $shop)
                                            <option value="{{$shop->id}}" @if(session('shop_id') == $shop->id) selected @endif>{{$shop->report_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="deli_date">送貨日期</label>
                                <input type="date" class="form-control" name="deli_date" id="deli_date"
                                       value="{{ session('deli_date') }}"  placeholder="">
                            </div>
                        </div>
                    </div>


                    @if (session('titles'))

                        <div class="col-md-12 match-success-div">
                        <h1>成功匹配貨品</h1>
                        @foreach(session('titles') as $code => $qty)
                            @if( ($code !== '') && ( isset(session('codes')[$code]['product']['product_name']) ))
                                <div class="col-md-12 mb-3 alert alert-success match-success"
                                     data-code="{{ $code }}"
                                     data-productid="{{session('codes')[$code]['product']['id'] ?? 0}}"
                                     data-qty="{{$qty}}">
                                    {{ $code }} => {{session('codes')[$code]['product']['product_no'] ?? ''}} - {{session('codes')[$code]['product']['product_name'] ?? ''}} => {{$qty}}
                                </div>
                            @endif
                        @endforeach

                        </div>

                        <h1>無法匹配貨品</h1>
                        @foreach(session('titles') as $code => $qty)
                            @if( ($code !== '') && (! isset(session('codes')[$code]['product']['product_name']) ))
                                <div class="col-md-12 mb-3 alert alert-danger match-fail" data-code="{{ $code }}" data-qty="{{$qty}}">
                                    {{ $code }} =>
                                    <select class="product" data-code="{{ $code }}" style="min-width: 30%">
                                        <option value="">-- 請選擇產品 --</option>
                                        @foreach(session('codeProductArr') as $id => $product)
                                            <option value="{{$id}}">{{$product}}</option>
                                        @endforeach
                                    </select>
                                    => {{$qty}}
                                    <button class="btn btn-primary btn-sm pull-right mismatch-save" type="button" data-code="{{ $code }}">匹配</button>
                                </div>
                            @endif
                        @endforeach

                        <hr class="mb-4">


                    @else

                        <div class="col-md-12 mb-3">
                            <input name="file" id="file" type="file" class="file" data-preview-file-type="text" required>
                        </div>
                        <hr class="mb-4">
{{--                        <button class="btn btn-primary btn-lg btn-block" type="submit" id="submit" onclick="sumbit()" data-loading-text="提交中...">讀取Excel資料</button>--}}

                    @endif

                </div>
            </form>

            @if (session('titles'))
                <button class="btn btn-success btn-lg btn-block" type="button" onclick="save_order();">落單</button>
            @else
                <button class="btn btn-primary btn-lg btn-block" type="button" onclick="read_excel_result();">讀取Excel資料</button>
            @endif

            <hr>

        </div>

@endsection

@section('script')
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('.shop').select2();
            $('.product').select2();

            // 匹配未存在的編號
            $('.mismatch-save').click(function (){

                $(this).attr('disabled', true);

                let code = $(this).data('code');
                let product_id = $('.product[data-code="' + code + '"]').val();
                let product_name = $('.product[data-code="' + code + '"] option:selected').text();
                let qty = $('.match-fail[data-code="' + code + '"]').data('qty');

                if (product_id === "") {
                    Swal.fire({
                        icon: 'error',
                        title: "請選擇產品！",
                    });
                    $(this).attr('disabled', false);
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "{{route('order.order_import.match_code')}}",
                    dataType: "json",
                    data: {
                        'code' : code,
                        'product_id' : product_id,
                        'product_name' : product_name,
                        'shop_group_id' : {{ request()->shop_group_id ?? 0 }}
                    },
                    success: function (data) {
                        if(data.status === 'error'){
                            Swal.fire({
                                icon: 'error',
                                title: data.error,
                            });
                            $(this).attr('disabled', false);
                            return false;
                        }

                        $('.match-success-div').append('<div class="col-md-12 mb-3 alert alert-success match-success"'
                            + 'data-code="' + code + '"'
                            + 'data-productid="' + product_id + '"'
                            + 'data-qty="' + qty + '"'
                            + '>' + code + ' => ' + product_name + ' => ' + qty + '</div>');

                        $('.match-fail[data-code="' + code + '"]').remove();
                        $(this).attr('disabled', false);
                    }
                });
            });
        });

        $("#file").fileinput({
            theme: 'fas',
            language: 'zh-TW',
            uploadUrl: '#', // you must set a valid URL here else you will get an error
            allowedFileExtensions: ["csv", "xlsx"],
            overwriteInitial: false,
            showUpload: false,
            showUploadedThumbs: false,
            dropZoneEnabled: false,
            maxFileSize: 10000,
            maxFilesNum: 1,
            //allowedFileTypes: ['image', 'video', 'flash'],
            //禁止csv文件上傳後自動下載
            disabledPreviewTypes: ['text'],
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });

        function read_excel_result(){

            $(this).attr('disabled', true);

            let shop_id = $('#shop').val();
            let file = $('#file').get(0).files[0];

            if (shop_id === "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分店！",
                });
                $(this).attr('disabled', false);
                return false;
            }

            if (!file) {
                Swal.fire({
                    icon: 'error',
                    title: "請上傳文件！",
                });
                $(this).attr('disabled', false);
                return false;
            }

            $(".needs-validation").submit();
        }

        function save_order(){

            $(this).attr('disabled', true);

            let shop_id = $('#shop').val();
            let deli_date = $('#deli_date').val();
            let insertarray = [];

            if (shop_id === "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇分店！",
                });
                $(this).attr('disabled', false);
                return false;
            }

            if (deli_date === "") {
                Swal.fire({
                    icon: 'error',
                    title: "請選擇送貨日期！",
                });
                $(this).attr('disabled', false);
                return false;
            }

            $(".match-success").each(function () {

                var productid = $(this).data('productid');
                var qty = $(this).data('qty');

                var item = {'itemid': productid, 'qty': qty };
                insertarray.push(item);

            });

            $.ajax({
                type: "POST",
                url: "{{route('order.order_import.save_order')}}",
                dataType: "json",
                data: {
                    'shop_id' : shop_id,
                    'deli_date' : deli_date,
                    'insertData' : JSON.stringify(insertarray),
                },
                success: function (data) {

                    let edit_order_url = '{{route('customer.cart')}}' + '?shop='+ shop_id + '&dept=CU&deli_date=' + deli_date;

                    if(data.status === 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: data.error,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '返回修改',
                            cancelButtonText: '查看訂單',
                        }).then((result) => {
                            if (result.isDismissed) {
                                window.open(edit_order_url);
                            }
                        });
                        $(this).attr('disabled', false);
                        return false;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: "已落貨!",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '繼續下單',
                        cancelButtonText: '查看訂單',
                    }).then((result) => {
                        if (result.isDismissed) {
                            window.open(edit_order_url);
                            window.location.reload();
                        } else {
                            window.location.reload();
                        }

                    });
                }
            });

        }

    </script>
@endsection
