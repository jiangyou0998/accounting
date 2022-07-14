@extends('layouts.app')

@section('title')
    貨倉入庫
@stop

@section('style')
    <style>

    </style>
@endsection

@section('content')

    <div class="container-fluid">
        {{--        搜索框--}}
        @if($filled_count === 0)
            <div class="d-flex justify-content-end input-group">

                <form class="card p-1" method="POST" action="{{ route('stock.warehouse.search', ['date' => request()->date]) }}">
                    <div class="input-group">
                        @csrf
                        <input id="search" name="search" type="text" class="form-control" placeholder=""
                               value="{{ request()->search ?? '' }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">查詢</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
        {{--        標題--}}
        <div class="py-5 text-center">

{{--            <h1>{{ request()->date }}</h1>--}}
            <h2>{{ Auth::user()->txt_name ?? '' }}</h2>
            <h2>貨倉入庫</h2>

{{--            保存訂單--}}
            @if($filled_count !== 0)
                <div class="d-flex justify-content-end input-group">
                    <div class="card p-1">
                        <div class="input-group">
                            <input type="date" name="invoice_date" id="invoice_date" class="form-control" style="padding-right: 2px;" autocomplete="off" max="{{\Carbon\Carbon::now()->toDateString()}}">
                            <input type="text" name="invoice_no" id="invoice_no" class="form-control" style="padding-right: 2px;" placeholder="請填寫訂單編號" autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-danger save-invoice" style="margin-right: 5px;">保存訂單</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        {{--        頂部按鈕--}}
        <div class="d-flex justify-content-end input-group">
            <a href="{{ route('stock.warehouse.index') }}" class="btn btn-danger" style="margin-right: 5px;">全部</a>
{{--            <a href="{{ route('stock.warehouse.index', ['type' => 'empty', 'date' => request()->date]) }}" class="btn btn-success">未填寫</a>--}}
{{--            <a href="{{ route('stock.warehouse.index', ['type' => 'filled', 'date' => request()->date]) }}" class="btn btn-primary">已填寫</a>--}}
        </div>
        <hr>

        {{--            已保存invoice tab--}}
        <div>
            @include('warehouse_stock._tab')
        </div>
        {{--            已保存invoice tab END--}}

        <hr>

{{--        總計--}}
        <div><h2>總計 : $<span class="total_price" id="total_price">0</span></h2></div>
        <hr>

        @if($filled_count !== 0)
            <h1 class="text-center">未保存INVOICE</h1>
        @endif

        <div class="row">
            @if($filled_count === 0)
            {{--            左邊部門欄--}}
            <div class="col-3 col-md-4 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">部門</span>
                </h4>
                <ul class="list-group mb-3">
{{--                    全部--}}
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="{{ route('stock.warehouse.index', ['supplier' => request()->supplier,  'date' => request()->date]) }}">
                                    全部
                                </a>
                            </h6>
                        </div>

                    </li>
{{--                    其他部門--}}
                    @foreach($warehouse_groups as $key => $value)
                        <li class="list-group-item
                            @if(request()->warehouse_group == $key) list-group-item-secondary @endif
                            d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">
                                    <a href="{{ route('stock.warehouse.index', ['warehouse_group' => $key, 'supplier' => request()->supplier,  'date' => request()->date]) }}">
                                        {{ $value }}
                                    </a>
                                </h6>
                            </div>

                        </li>
                    @endforeach

                </ul>

                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">供應商</span>
                </h4>
                <ul class="list-group mb-3">
                    {{--                    全部--}}
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="{{ route('stock.warehouse.index', ['warehouse_group' => request()->warehouse_group,  'date' => request()->date]) }}">
                                    全部
                                </a>
                            </h6>
                        </div>

                    </li>
                    {{--                    其他供應商--}}
                    @foreach($suppliers as $key => $value)
                        <li class="list-group-item
                                @if(request()->supplier == $key) list-group-item-secondary @endif
                            d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">
                                    <a href="{{ route('stock.warehouse.index', ['warehouse_group' => request()->warehouse_group, 'supplier' => $key, 'date' => request()->date]) }}">
                                        {{$value}}
                                    </a>
                                </h6>

                            </div>

                        </li>
                    @endforeach

                </ul>

            </div>
            @endif


            <div class=" @if($filled_count === 0) col-md-8 @else col-md-12 @endif mb-8 right-div">
                @if(count($products))
                    @include('warehouse_stock._supplier_table')
                @else
                    <h1>暫無查詢結果!</h1>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>

        var search_prices;

        //計算總價
        function cal_price(prices) {
            let total_price = 0;

            $(".price, .base_price, .subtotal_price").html('');
            $.each(prices, function(key, value) {
                let subtotal_price = 0;
                let price = value.price;
                let base_price = value.base_price;

                let qty =  $(".qty[data-id=" + value.product_id + "]").val();
                let base_qty =  $(".base_qty[data-id=" + value.product_id + "]").val();

                if( qty === null || qty === undefined || qty === ''){
                    qty = 0;
                }

                if( base_qty === null || base_qty === undefined || base_qty === '' ){
                    base_qty = 0;
                }

                subtotal_price += parseFloat(qty) * parseFloat(value.price) + parseFloat(base_qty) * parseFloat(value.base_price);
                if (! isNaN(subtotal_price)){
                    total_price += parseFloat(subtotal_price);
                }


                $(".price[data-id=" + value.product_id + "]").html('$'+ price + '/');
                $(".base_price[data-id=" + value.product_id + "]").html('$'+ base_price + '/');
                $(".subtotal_price[data-id=" + value.product_id + "]").html('$'+ subtotal_price + '');

                // console.log('qty:' + qty + ',base_qty:' + base_qty
                //     + ',price:' + value.price + ',base_price:' + value.base_price
                //     + ',item_price:' + item_price + ',total_price:' + total_price);

            });

            //總數千分位加逗號
            var num = total_price.toFixed(2)+"";//保留两位小数
            var total_price_sum = num.replace(/(\d{1,3})(?=(\d{3})+(?:$|\.))/g,'$1,');

            $('#total_price').html(total_price_sum);
        }

        //更改日期時
        $(document).on('change', '#invoice_date', function () {
            let date = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ route('stock.warehouse.price_check') }}",
                data: {
                    'date': date,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    search_prices = data.prices;
                    cal_price(data.prices);
                },
                error:function () {
                    Swal.fire({
                        icon: 'error',
                        title: "發生错误，請嘗試關閉頁面後重新進入",
                    });
                }
            });


        });

        // $('.qty').blur(function () {
        $(document).on('blur', '.qty, .base_qty', function () {

            let product_id = $(this).data('id');

            let qty =  $(".qty[data-id=" + product_id + "]").val();
            let base_qty =  $(".base_qty[data-id=" + product_id + "]").val();

            submit(qty, base_qty, product_id);

            cal_price(search_prices);

        });

        // $(document).on('keydown', '.qty, .base_qty', function(e) {
        //     if (13 === e.keyCode) {
        //         let product_id = $(this).data('id');
        //
        //         let qty = $(".qty[data-id=" + product_id + "]").val();
        //         let base_qty = $(".base_qty[data-id=" + product_id + "]").val();
        //
        //         submit(qty, base_qty, product_id);
        //
        //         cal_price(search_prices);
        //     }
        // });

        //提交每一行數據
        function submit(qty, base_qty, product_id){

            if(qty <= 0 && qty !== null && qty !== undefined && qty !== "" ){
                Swal.fire({
                    icon: 'error',
                    title: "請輸入大於0的數字",
                });
                // 輸入錯誤清空數據
                $(".qty[data-id=" + product_id + "]").val('');
                return ;
            }

            if(base_qty <= 0 && base_qty !== null && base_qty !== undefined && base_qty !== "" ){
                Swal.fire({
                    icon: 'error',
                    title: "請輸入大於0的數字",
                });
                // 輸入錯誤清空數據
                $(".base_qty[data-id=" + product_id + "]").val('');
                return ;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('stock.warehouse.add', ['date' => request()->date, 'times' => request()->times] ) }}",
                data: {
                    'product_id': product_id,
                    'qty': qty,
                    'base_qty': base_qty,

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    console.log(data.msg);
                    if(data.msg === 'new'){
                        window.location.href = "{{route('stock.warehouse.index')}}";
                    }
                },
                error:function () {
                    Swal.fire({
                        icon: 'error',
                        title: "發生错误，請嘗試關閉頁面後重新進入",
                    });
                }
            });

        }

        //刪除(x按鈕),刪除庫存
        $(document).on('click', '.delstock', function () {

            let product_id = $(this).data('id');
            let qty_input = $(".qty[data-id=" + product_id + "]");
            let base_qty_input = $(".base_qty[data-id=" + product_id + "]");

            let qty_is_empty = true;
            let base_qty_is_empty = true;

            qty_input.each(function () {

                let input = $(this).val();

                if (input !== null && input !== undefined && input !== "") {
                    qty_is_empty = false;
                    return false;
                }

            });

            base_qty_input.each(function () {

                let input = $(this).val();

                if (input !== null && input !== undefined && input !== "") {
                    base_qty_is_empty = false;
                    return false;
                }

            });

            if (qty_is_empty === true && base_qty_is_empty === true) {
                return ;
            }

            $.ajax({
                type: "DELETE",
                url: "{{ route('stock.warehouse.delete', ['date' => request()->date] ) }}",
                data: {
                    'product_id': product_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (msg) {
                    qty_input.val('');
                    base_qty_input.val('');
                    cal_price(search_prices);
                },
                error:function () {
                    Swal.fire({
                        icon: 'error',
                        title: "發生错误，請嘗試關閉頁面後重新進入",
                    });
                }
            });

        });

        //提交批次
        $(document).on('click', '.save-invoice', function () {

            let invoice_date = $('#invoice_date').val();
            let invoice_no = $('#invoice_no').val();

            if (invoice_date === null || invoice_date === '') {
                Swal.fire({
                    icon: 'error',
                    title: "請填寫訂單日期！",
                });
                return;
            }

            if (invoice_no === null || invoice_no === '') {
                Swal.fire({
                    icon: 'error',
                    title: "請填寫訂單編號！",
                });
                return;
            }

            Swal.fire({
                icon: 'warning',
                title: "確定將所有未保存項目添加到批次?",
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: '確定',
                denyButtonText: '取消',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('stock.warehouse.save_invoice') }}",
                        data: {
                            'invoice_no': invoice_no,
                            'date': invoice_date,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (msg) {
                            Swal.fire({
                                icon: 'success',
                                title: "已成功保存到批次",
                            }).then((result) => {
                                window.location.reload();
                            });

                        },
                        error: function(res) {
                            errors = res.responseJSON.errors;
                            let form_errors = '';
                            $.each(errors, function(i) {
                                form_errors += '<div>' + errors[i] + '</div>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: form_errors,
                            });
                        }
                    });
                }
            });
        });

    </script>
@endsection
