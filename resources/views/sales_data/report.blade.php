@extends('layouts.app_no_header')

@section('title')
    銷售數據
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
            width:130px;
            font-size: small;
        }

        .right{
            display:inline-block;
            width:105px;
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
            <h2>營業數</h2>

        </div>

        <hr class="mb-4">
        <div class="copy">
            <h4>{{$date_and_week}}</h4>

            @isset($front_groups['bakery'])
                <div class="group-div">
                    <h5>營業數</h5>
                    @foreach($front_groups['bakery'] as $shop_id)
                        <span class="left">
                            {{$shop_names[$shop_id] ?? 0}} ${{number_format(($day_income[$shop_id] ?? 0), 0)}}
                        </span>
                            <span class="right">
                            累積 ${{number_format(($total_income[$shop_id] ?? 0), 0)}}
                        </span>
{{--                        <span class="right">--}}
{{--                            上月 ${{number_format(($last_month_total_income[$value->shop_id] ?? 0), 0)}}--}}
{{--                        </span>--}}
                        @isset($seasonal_income[$shop_id])
                            @if($seasonal_income[$shop_id] != 0)
                                <span class="right">
                                    時節 ${{number_format(($seasonal_income[$shop_id] ?? 0), 0)}}
                                </span>
                            @endif
                        @endisset
                        <br>
                    @endforeach
                    <h6>
                        <span class="total-left">合計${{number_format($sale_summary['bakery_total'], 0) ?? '0.00'}}</span>
                        <span class="total-right">本月累積${{number_format($sale_summary['bakery_month_total'], 0) ?? '0.00'}}</span>
{{--                        <span class="total-right">上月${{number_format($sale_summary['bakery_last_month_total'], 0) ?? '0.00'}}</span>--}}
                    </h6>
                </div>

            @endisset
            <div class="group-div">
                <h5><span>總計:${{number_format($sale_summary['total'], 2) ?? '0.00'}}</span></h5>
                <h5>本月累積:${{number_format($sale_summary['month_total'], 2) ?? '0.00'}}</h5>
{{--                <h5>上月:${{number_format($sale_summary['last_month_total'], 2) ?? '0.00'}}</h5>--}}
            </div>
        </div>

        <hr class="mb-4">

{{--        顯示八達通+合計數--}}
        <div class="py-5 text-center">
            <h2>{{$date_and_week}}</h2>
            <h2>營業數</h2>

        </div>

        <hr class="mb-4">
            <div class="copy">
                <h4>{{$date_and_week}}</h4>

                @isset($sale_summary['bakery'])
                    <h5>營業數</h5>
                    @foreach($sale_summary['bakery'] as $value)
                        <span style="float:left;width:140px;">
                            {{$value->user->report_name}} ${{number_format($value->income_sum, 2)}}
                        </span>
                        <span style="width: 180px">
                            本月 ${{number_format($total_income[$value->shop_id], 2) ?? '0.00'}}
                        </span>
                        <br>
                        <span>
                            八達通${{number_format(($value->details->where('type_no', 31)->first()->income ?? 0), 2)}}
                        </span>
                        <br>
                    @endforeach

                    <h5>
                        <span>合計:${{number_format($sale_summary['bakery_total'], 2) ?? '0.00'}}</span>
{{--                        <span>總:${{sprintf("%.2f", $sale_summary['bakery_month_total'])}}</span>--}}
                    </h5>
                    <br>
                @endisset
                <div class="group-div">
                    <h5><span>總計:${{number_format($sale_summary['total'], 2) ?? '0.00'}}</span></h5>
                    <h5>本月總計:${{number_format($sale_summary['month_total'], 2) ?? '0.00'}}</h5>
                </div>
            </div>

        <hr class="mb-4">

{{--        不顯示八達通--}}
        <div class="py-5 text-center">
            <h2>{{$date_and_week}}</h2>
            <h2>營業數</h2>

        </div>

        <hr class="mb-4">
        <div class="copy">
            <h4>{{$date_and_week}}</h4>

            @isset($sale_summary['bakery'])
                <h5>營業數</h5>
                @foreach($sale_summary['bakery'] as $value)
                    @if($loop->iteration % 2 === 1)
                        <span style="float:left;width:140px;">
                            {{$value->user->report_name}} ${{number_format($value->income_sum, 2)}}
                        </span>
                    @endif

                    @if($loop->iteration % 2 === 0)
                        <span style="width:180px;">
                            {{$value->user->report_name}} ${{number_format($value->income_sum, 2)}}
                        </span>
                        <br>
                    @endif

                    @if($loop->iteration % 2 === 1 && $loop->last)
                        <br>
                    @endif
                @endforeach
                <h5>
                    <span>合計:${{number_format($sale_summary['bakery_total'], 2) ?? '0.00'}}</span>
                </h5>
                <br>
            @endisset
            <div class="group-div">
                <h5><span>總計:${{number_format($sale_summary['total'], 2) ?? '0.00'}}</span></h5>
                <h5>本月總計:${{number_format($sale_summary['month_total'], 2) ?? '0.00'}}</h5>
            </div>
        </div>

        <hr class="mb-4">

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>

@endsection

@section('script')
    <script>
        // //点击复制
        // var clipboard = new Clipboard('.copy');
        // clipboard.on('success', function(e) {
        //     Hap.showToast({
        //         type:'success',
        //         message: $l('已复制到剪贴板')
        //     });
        // });
        // clipboard.on('error', function(e) {
        //     Hap.showToast({
        //         type:'error',
        //         message: $l('复制失败,请联系管理人员')
        //     });
        // });

        $(document).on('change', '.date', function (){
            let date = $(this).val();
            window.location.href = '/sales_data/report?date=' + date;
        });
    </script>
@endsection
