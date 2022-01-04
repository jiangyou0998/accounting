@extends('layouts.app')

@section('title')
    庫存
@stop

@section('style')
    <style type="text/css">

        /*.main-div{*/
        /*    display: flex;*/
        /*    width: 100%;*/
        /*}*/

        .left-div{
            width: 50%;
            height: 60vh;
            overflow: auto;

        }

        .right-div{
            width: 40%;
            height: 60vh;
            overflow-x: hidden;
            overflow-y: auto;

        }


    </style>
@endsection


@section('content')

    <div class="container">
{{--        搜索框--}}
        <div class="d-flex justify-content-end input-group">

            <form class="card p-1" method="POST" action="{{ route('stock.search') }}">
                <div class="input-group">
                    @csrf
                    <input id="search" name="search" type="text" class="form-control" placeholder="" value="{{ request()->search ?? '' }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">查詢</button>
                    </div>
                </div>
            </form>
        </div>
{{--        標題--}}
        <div class="py-4 text-center">

            <h2>庫存-{{\Carbon\Carbon::now()->monthName}}</h2>
        </div>
{{--        頂部按鈕--}}
        <div class="d-flex justify-content-end input-group">
            <a href="{{ route('stock.index') }}" class="btn btn-danger" style="margin-right: 5px;">全部</a>
            <a href="{{ route('stock.index', ['type' => 'empty']) }}" class="btn btn-success">未填寫</a>
        </div>
        <hr>
        <div class="container-fluid">
            <div class="row main-div">

                <div class="col-md-4 mb-4 left-div">
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
                                        <a href="{{ route('stock.index', ['group' => $key]) }}">
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
                        @include('stock._table')
                    @else
                        <h1>暫無查詢結果!</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>

        $('.qty').blur(function () {

            let qty = $(this).val();
            let unit_id = $(this).attr('data-unit');
            let product_id = $(this).data('id');

            submit(qty, product_id, unit_id)

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
                url: "{{ route('stock.add') }}",
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
                url: "{{ route('stock.delete') }}",
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

