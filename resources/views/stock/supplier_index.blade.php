@extends('layouts.app')

@section('title')
    供應商庫存
@stop

@section('content')

    <div class="container">
        {{--        搜索框--}}
        <div class="d-flex justify-content-end input-group">

            <form class="card p-1" method="POST" action="{{ route('stock.supplier.search') }}">
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

            <h2>供應商庫存-{{$monthname}}</h2>
        </div>
        {{--        頂部按鈕--}}
        <div class="d-flex justify-content-end input-group">
            <a href="{{ route('stock.supplier.index') }}" class="btn btn-danger" style="margin-right: 5px;">全部</a>
            <a href="{{ route('stock.supplier.index', ['type' => 'empty']) }}" class="btn btn-success">未填寫</a>
            <a href="{{ route('stock.supplier.index', ['type' => 'filled']) }}" class="btn btn-primary">已填寫</a>
        </div>
        <div class="d-flex justify-content-start input-group">
            <a href="{{ route('stock.supplier.index', ['type' => 'filled', 'mode' => 'print']) }}" target="_blank" class="btn btn-danger" style="margin-right: 5px;">查看已填寫</a>
        </div>
        <hr>
        <div class="row">
            {{--            左邊部門欄--}}
            <div class="col-md-4 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">部門</span>
                </h4>
{{--                    全部--}}
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">
                            <a href="{{ route('stock.supplier.index', ['supplier' => request()->supplier]) }}">
                                全部
                            </a>
                        </h6>
                    </div>

                </li>
{{--                    其他部門--}}
                <ul class="list-group mb-3">

                    @foreach($groups as $key => $value)
                        <li class="list-group-item
                            @if(request()->group == $key) list-group-item-secondary @endif
                            d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">
                                    <a href="{{ route('stock.supplier.index', ['group' => $key, 'supplier' => request()->supplier]) }}">
                                        {{ $value }}
                                    </a>
                                </h6>
                            </div>

                        </li>
                    @endforeach

                </ul>

                {{--            左邊供應商欄--}}
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">供應商</span>
                </h4>
                <ul class="list-group mb-3">

{{--                    全部--}}
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="{{ route('stock.supplier.index', ['group' => request()->group]) }}">
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
                                    <a href="{{ route('stock.supplier.index', ['group' => request()->group, 'supplier' => $key]) }}">
                                        {{ $value }}
                                    </a>
                                </h6>
                            </div>

                        </li>
                    @endforeach

                </ul>

            </div>

            <div class="col-md-8 mb-8 right-div">
                @if(count($products))
                    @include('stock._supplier_table')
                @else
                    <h1>暫無查詢結果!</h1>
                @endif
            </div>
        </div>

@endsection

@section('script')
    <script>

        //更改單位時寫入數據
        // $(document).on('change', '.select_unit', function () {
        //     let unit_id = $(this).val();
        //     let product_id = $(this).data('id');
        //     let qty_input = $(".qty[data-id=" + product_id + "]");
        //     let qty = qty_input.val();
        //
        //     if (qty == null || qty == undefined || qty == "") {
        //         return ;
        //     }
        //     qty_input.attr('data-unit', unit_id);
        //
        //     submit(qty, product_id, unit_id);
        // });

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
                url: "{{ route('stock.supplier.add') }}",
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
            let qty_is_empty = true;

            qty_input.each(function () {

                let input = $(this).val();

                if (input !== null && input !== undefined && input !== "") {
                    qty_is_empty = false;
                    return false;
                }

            });

            if (qty_is_empty === true) {
                return ;
            }

            $.ajax({
                type: "DELETE",
                url: "{{ route('stock.supplier.delete') }}",
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
