@extends('layouts.app')

@section('title')
    {{ request()->date }} - 貨倉入庫
@stop

@section('content')

    <div class="container-fluid">
        {{--        搜索框--}}
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
        {{--        標題--}}
        <div class="py-5 text-center">

            <h1>{{ request()->date }}</h1>
            <h2>{{ Auth::user()->txt_name ?? '' }}</h2>
            <h2>貨倉入庫</h2>
        </div>
        {{--        頂部按鈕--}}
        <div class="d-flex justify-content-end input-group">
            <a href="{{ route('stock.warehouse.index', ['date' => request()->date]) }}" class="btn btn-danger" style="margin-right: 5px;">全部</a>
            <a href="{{ route('stock.warehouse.index', ['type' => 'empty', 'date' => request()->date]) }}" class="btn btn-success">未填寫</a>
            <a href="{{ route('stock.warehouse.index', ['type' => 'filled', 'date' => request()->date]) }}" class="btn btn-primary">已填寫</a>
        </div>
        <hr>
        <div class="row">
            {{--            左邊供應商欄--}}
            <div class="col-3 col-md-4 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">部門</span>
                </h4>
                <ul class="list-group mb-3">

                    @foreach($groups as $key => $value)
                        <li class="list-group-item
                            @if(request()->group == $key) list-group-item-secondary @endif
                            d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">
                                    <a href="{{ route('stock.warehouse.index', ['group' => $key, 'supplier' => request()->supplier,  'date' => request()->date]) }}">
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
                    @foreach($suppliers as $key => $value)
                        <li class="list-group-item
                                @if(request()->supplier == $key) list-group-item-secondary @endif
                            d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">
                                    <a href="{{ route('stock.warehouse.index', ['group' => request()->group, 'supplier' => $key, 'date' => request()->date]) }}">
                                        {{$value}}
                                    </a>
                                </h6>

                            </div>

                        </li>
                    @endforeach

                </ul>

            </div>

            <div class="col-md-8 mb-8 right-div">
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
                url: "{{ route('stock.warehouse.add', ['date' => request()->date] ) }}",
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
            let qty = qty_input.val();

            if (qty == null || qty == undefined || qty == "") {
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
                },
                error:function () {
                    Swal.fire({
                        icon: 'error',
                        title: "發生错误，請嘗試關閉頁面後重新進入",
                    });
                }
            });

        });

    </script>
@endsection
