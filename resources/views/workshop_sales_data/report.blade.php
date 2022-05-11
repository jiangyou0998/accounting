@extends('layouts.app_no_header')

@section('title')
    批發數報告
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
            padding-right: 3px;
            padding-left: 3px;
            width: 100%;
            max-width: 2000px;      // 隨螢幕尺寸而變，當螢幕尺寸 ≥ 1200px 時是 1140px。
        }

        .left{
            /*float:left;*/
            display:inline-block;
            width:120px;
            font-size: small;
        }

        .right{
            display:inline-block;
            /*width:100px;*/
            font-size: small;
        }

        .total-left{
            display:inline-block;
            padding-top: 3px;
            padding-right: 2px;
        }

        .total-right{
            display:inline-block;
            padding-top: 3px;
            padding-right: 2px;
        }

        .group-div{
            padding-top: 5px;
        }

    </style>
@endsection

@section('content')

    <div class="container">
        <div>
            <label for="date"><h4>選擇日期:</h4></label>
            <input type="date" class="date" value="{{$date}}">
        </div>

{{--        顯示合計數--}}
        <div class="py-5 text-center">
            <h2>{{$date_and_week}}</h2>
            <h2>批發數</h2>

        </div>

        <hr class="mb-4">
        <div class="copy">
            <h4>{{$date_and_week}}</h4>

            @foreach($customer_total_this_month as $shop_group_id => $value)
                <span class="left">
                    {{$shop_groups[$shop_group_id] ?? ''}} ${{number_format(($customer_total_today[$shop_group_id] ?? 0), 0) }}
                </span>
                <span class="right">
                    本月累積 ${{number_format($value, 0)}}
                </span>
                <br>
            @endforeach

            <div class="group-div">
                <h5><span>總計:${{number_format($sale_summary['total'], 2) ?? '0.00'}}</span></h5>
                <h5>本月累積:${{number_format($sale_summary['month_total'], 2) ?? '0.00'}}</h5>
            </div>
        </div>

        <hr class="mb-4">

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

@endsection

@section('script')
    <script>

        $(document).on('change', '.date', function (){
            let date = $(this).val();
            window.location.href = '/workshop_sales_data/report?date=' + date;
        });
    </script>
@endsection
