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

            <h2>供應商庫存-{{\Carbon\Carbon::now()->monthName}}</h2>
        </div>
        {{--        頂部按鈕--}}
        <div class="d-flex justify-content-end input-group">
            <a href="{{ route('stock.supplier.index') }}" class="btn btn-danger" style="margin-right: 5px;">全部</a>
            <a href="{{ route('stock.supplier.index', ['type' => 'empty']) }}" class="btn btn-success">未填寫</a>
        </div>
        <hr>
        <div class="row">
            {{--            左邊供應商欄--}}
            <div class="col-md-4 mb-4">
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
                                    <a href="{{ route('stock.supplier.index', ['group' => $key]) }}">
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
        //确定离开当前页面
        // window.onbeforeunload = function (e) {
        //     var e = window.event || e;
        //     e.returnValue = ("确定离开当前页面吗？");
        // }

        $('.qty').blur(function () {

            let qty = $(this).val();

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
                    'product_id': $(this).data('id'),
                    'qty': qty
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
                        title: "系统错误",
                    });
                }
            });

        });
    </script>
@endsection
