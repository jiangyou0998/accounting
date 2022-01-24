@extends('layouts.app')

@section('title')
    維修項目-未完成處理
@stop

@section('style')
    <style type="text/css">

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
        <div class="py-5 text-center">
            <h2>維修項目</h2>
            <h2>未完成處理</h2>
        </div>

        <hr class="mb-4">
        @include('support.repair.phone._unfinished')
        <hr class="mb-4">

    </div>

@endsection

@section('script')
    <script>
        $(document).on('click', '.repair-order', function () {
            let shop_id = $(this).val();
            let name = 'repair-group-' + shop_id;

            let order_ids = $('input[type=checkbox][name="' + name + '"]:checked').map(function () {
                return this.value
            }).get().join(',');

            let url = '/repair_order?shop_id=' + shop_id + '&order_ids=' + order_ids;

            window.open(url);
            // console.log(url);
        });
    </script>
@endsection
