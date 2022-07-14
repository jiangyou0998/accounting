@extends('layouts.app')

@section('title')
    貨倉入庫
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

{{--        總計--}}
        <div><h2>總計 : $<span class="total_price" id="total_price">0</span></h2></div>
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

    @include('warehouse_stock._script')

    <script>

        $( document ).ready(function() {
            $( "#invoice_date" ).trigger( "change" );
        });

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

        //提交批次
        $(document).on('click', '.save-invoice', function () {

            let url = "{{ route('stock.warehouse.edit_invoice', ['times' => request()->times]) }}";
            save_invoice(url);

        });

    </script>
@endsection
