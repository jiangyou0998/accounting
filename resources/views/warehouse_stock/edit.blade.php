@extends('layouts.app')

@section('title')
    {{ request()->date }} - 貨倉入庫
@stop

@section('content')

    <div class="container-fluid">

        {{--        標題--}}
        <div class="py-5 text-center">

{{--            <h1>{{ request()->date }}</h1>--}}
            <h2>{{ Auth::user()->txt_name ?? '' }}</h2>
            <h2>貨倉入庫</h2>

{{--            修改訂單--}}
            <div class="d-flex justify-content-end input-group">
                <div class="card p-1">
                    <div class="input-group">
                        <input type="date" name="invoice_date" id="invoice_date" class="form-control" style="padding-right: 2px;" autocomplete="off" value="{{$invoice_info['date']}}" max="{{\Carbon\Carbon::now()->toDateString()}}">
                        <input type="text" name="invoice_no" id="invoice_no" class="form-control" style="padding-right: 2px;" placeholder="請填寫訂單編號" autocomplete="off" value="{{$invoice_info['invoice_no']}}">
                        <div class="input-group-append">
                            <button class="btn btn-danger save-invoice" style="margin-right: 5px;">修改訂單</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{--        頂部按鈕--}}
        <div class="d-flex justify-content-end input-group">
            <a href="{{ route('stock.warehouse.index', ['supplier' => $invoice_info['supplier_id']]) }}" class="btn btn-primary" style="margin-right: 5px;">新INVOICE(同供應商)</a>
            <a href="{{ route('stock.warehouse.index') }}" class="btn btn-success" style="margin-right: 5px;">新INVOICE</a>
        </div>

        <hr>

        {{--            已保存invoice tab--}}
        <div>
            @include('warehouse_stock._tab')
        </div>
        {{--            已保存invoice tab END--}}

        <hr>
        <div class="row">

            <div class="col-md-12 mb-8 right-div">
                <h1 class="text-center">{{$invoice_info['date'] . '   #' . $invoice_info['invoice_no']}}</h1>
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

        //更改單位時寫入數據
        $(document).on('change', '.select_unit', function () {
            let unit_id = $(this).val();
            let product_id = $(this).data('id');
            let qty_input = $(".qty[data-id=" + product_id + "]");
            let qty = qty_input.val();

            //2022-04-29 應該先更改data-unit的值 再判斷是否需要保存
            qty_input.attr('data-unit', unit_id);

            if (qty == null || qty == undefined || qty == "") {
                return ;
            }

            submit(qty, product_id, unit_id);
        });

        // $('.qty').blur(function () {
        $(document).on('blur', '.qty', function () {

            let qty = $(this).val();
            let unit_id = $(this).attr('data-unit');
            let product_id = $(this).data('id');

            // console.log(qty);
            // console.log(unit_id);
            submit(qty, product_id, unit_id);

        });

        //提交每一行數據
        function submit(qty, product_id, unit_id){

            if(isNaN(qty)){
                return ;
            }

            if (qty == null || qty == undefined || qty == "") {
                return ;
            }

            if(qty <= 0){
                Swal.fire({
                    icon: 'error',
                    title: "請輸入大於0的數字",
                });
                return ;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('stock.warehouse.add', ['date' => request()->date, 'times' => request()->times] ) }}",
                data: {
                    'product_id': product_id,
                    'qty': qty,
                    'unit_id': unit_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (msg) {
                    // window.location.reload();
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
            // let qty = qty_input.val();

            // if (qty == null || qty == undefined || qty == "") {
            //     return ;
            // }

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
                        url: "{{ route('stock.warehouse.edit_invoice', ['times' => request()->times]) }}",
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
                        error: function (res) {
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




        {{--}--}}

    </script>
@endsection
