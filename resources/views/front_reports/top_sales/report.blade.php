@extends('layouts.app_print')

@section('title')
    Top Sales Report
@stop

@section('style')
    <style>
        .table td, .table th {
            padding: initial;
        }

        input[type="checkbox"]{
            width: 30px; /*Desired width*/
            height: 30px; /*Desired height*/
        }

        .checkbox{
            font-size: 30px;
            margin-bottom: 10px;
        }

        .describe-text{
            font-size: 20px;
            margin-bottom: 10px;
        }

        .row { margin-bottom: 1rem; }
    </style>
@endsection

@section('content')

    <div class="container">

{{--        查詢:--}}
        <div class="m-4">
            <div class="row">
                <span class="describe-text">開始時間:</span><input type="date" id="start_date" value="{{ request()->start_date ?? now()->toDateString() }}">
            </div>
            <div class="row">
                <span class="describe-text">結束時間:</span><input type="date" id="end_date" value="{{ request()->end_date ?? now()->toDateString() }}">
            </div>
            <div class="row">
                @foreach($shops as $shop)
                    <label style="padding-right:15px;">
                        <input type="checkbox" name="shop" value="{{$shop->id}}" @if(in_array($shop->id, explode(',', request()->shop_ids))) checked @endif>
                        <span class="checkbox">{{$shop->report_name}}</span>
                    </label>
                @endforeach
            </div>

            <div class="row">
                <button class="btn btn-success btn-search">查詢</button>
            </div>

            <input type="hidden" name="shopstr" id="shopstr" value="{{ request()->shop_ids }}"/>

        </div>

        {{--        標題--}}
        <div class="py-1 text-center">

            <h2>Top Sales 15</h2>
            <h2>{{ request()->start_date ?? now()->toDateString() }} 至 {{ request()->end_date ?? now()->toDateString() }}</h2>

        </div>
        <hr>
        <div class="row">

            <div class="col-md-12 mb-12 right-div">
                @if(count($products))
                    @include('front_reports.top_sales._table_data')
                @else
                    <h1>暫無查詢結果!</h1>
                @endif
            </div>
        </div>

@endsection

@section('script')
        <script>
            //鉤選或取消時,修改shopstr(隱藏)的值
            $(document).on('change', 'input[type=checkbox]', function () {
                let shopstr = $('input[type=checkbox]:checked').map(function () {
                    return this.value
                }).get().join(',');
                $('#shopstr').val(shopstr);
            });

            $(document).on('click', '.btn-search', function () {
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                let shopstr = $('#shopstr').val();

                if(start_date === ''){
                    Swal.fire({
                        icon: 'error',
                        title: "請選擇「開始時間」!",
                    });
                    return ;
                }

                if(end_date === ''){
                    Swal.fire({
                        icon: 'error',
                        title: "請選擇「結束時間」!",
                    });
                    return ;
                }

                if(shopstr === ''){
                    Swal.fire({
                        icon: 'error',
                        title: "請選擇「分店」!",
                    });
                    return ;
                }

                window.location.href = '{{ route('top_sales.report')}}'
                    + '?start_date=' + $('#start_date').val()
                    + '&end_date=' + $('#end_date').val()
                    + '&shop_ids=' + $('#shopstr').val();

            });
        </script>
@endsection

