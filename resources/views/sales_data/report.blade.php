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
            padding-right: 15px;
            padding-left: 15px;
            width: 100%;
            max-width: 2000px;      // 隨螢幕尺寸而變，當螢幕尺寸 ≥ 1200px 時是 1140px。
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
            @isset($sale_summary['other'])
                <h5>混合型/飯堂營業數</h5>
                @foreach($sale_summary['other'] as $value)
{{--                    {{$value->user->report_name}} ${{$value->income_sum}}--}}
{{--                    <span class="octopus-total">--}}
{{--                        本月合計${{$total_income[$value->shop_id] ?? '0.00'}}--}}
{{--                    </span>--}}
                    <span style="float:left;width:140px;">
                        {{$value->user->report_name}} ${{$value->income_sum}}
                    </span>
                    <span style="width: 180px">
                        本月 ${{$total_income[$value->shop_id] ?? '0.00'}}
                    </span>
                    <br>
                @endforeach
                <h5>
                    <span>合計:${{sprintf("%.2f", $sale_summary['other_total'])}}</span>
                </h5>
{{--                <h5>--}}
{{--                    <span>本月:${{sprintf("%.2f", $sale_summary['other_month_total'])}}</span>--}}
{{--                </h5>--}}
                <br>
            @endisset

            @isset($sale_summary['bakery'])
                <h5>餅店營業數</h5>
                @foreach($sale_summary['bakery'] as $value)
                    <span style="float:left;width:140px;">
                        {{$value->user->report_name}} ${{$value->income_sum}}
                    </span>
                    <span style="width: 180px">
                        本月 ${{$total_income[$value->shop_id] ?? '0.00'}}
                    </span>
                    <br>
                @endforeach
                <h5>
                    <span>合計:${{sprintf("%.2f", $sale_summary['bakery_total'])}}</span>
                </h5>
{{--                <h5>--}}
{{--                    <span>本月:${{sprintf("%.2f", $sale_summary['bakery_month_total'])}}</span>--}}
{{--                </h5>--}}
                <br>
            @endisset
            <h5>總計:${{sprintf("%.2f", $sale_summary['total'])}}</h5>
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
                @isset($sale_summary['other'])
                    <h5>混合型/飯堂營業數</h5>
                    @foreach($sale_summary['other'] as $value)
                        <span style="float:left;width:140px;">
                            {{$value->user->report_name}} ${{$value->income_sum}}
                        </span>
                        <span style="width: 180px">
                            本月 ${{$total_income[$value->shop_id] ?? '0.00'}}
                        </span>
                        <br>
                        <span>
                            八達通${{$value->details->where('type_no', 31)->first()->income ?? '0.00'}}
                        </span>
                        <br>
                    @endforeach
                        <h5>
                            <span>合計:${{sprintf("%.2f", $sale_summary['other_total'])}}</span>
{{--                            <span>總:${{sprintf("%.2f", $sale_summary['other_month_total'])}}</span>--}}
                        </h5>
                        <br>
                @endisset

                @isset($sale_summary['bakery'])
                    <h5>餅店營業數</h5>
                    @foreach($sale_summary['bakery'] as $value)
                        <span style="float:left;width:140px;">
                            {{$value->user->report_name}} ${{$value->income_sum}}
                        </span>
                        <span style="width: 180px">
                            本月 ${{$total_income[$value->shop_id] ?? '0.00'}}
                        </span>
                        <br>
                        <span>
                            八達通${{$value->details->where('type_no', 31)->first()->income ?? '0.00'}}
                        </span>
                        <br>
                    @endforeach

                    <h5>
                        <span>合計:${{sprintf("%.2f", $sale_summary['bakery_total'])}}</span>
{{--                        <span>總:${{sprintf("%.2f", $sale_summary['bakery_month_total'])}}</span>--}}
                    </h5>
                    <br>
                @endisset
                    <h5>總計:${{sprintf("%.2f", $sale_summary['total'])}}</h5>
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
            @isset($sale_summary['other'])
                <h5>混合型/飯堂營業數</h5>
                @foreach($sale_summary['other'] as $value)

                    @if($loop->iteration % 2 === 1)
                        <span style="float:left;width:140px;">
                            {{$value->user->report_name}} ${{$value->income_sum}}
                        </span>
                    @endif

                    @if($loop->iteration % 2 === 0)
                        <span style="width:180px;">
                            {{$value->user->report_name}} ${{$value->income_sum}}
                        </span>
                        <br>
                    @endif

                    @if($loop->iteration % 2 === 1 && $loop->last)
                        <br>
                    @endif

                @endforeach
                <h5>合計:${{sprintf("%.2f", $sale_summary['other_total'])}}</h5>
                <br>
            @endisset

            @isset($sale_summary['bakery'])
                <h5>餅店營業數</h5>
                @foreach($sale_summary['bakery'] as $value)
                    @if($loop->iteration % 2 === 1)
                        <span style="float:left;width:140px;">
                            {{$value->user->report_name}} ${{$value->income_sum}}
                        </span>
                    @endif

                    @if($loop->iteration % 2 === 0)
                        <span style="width:180px;">
                            {{$value->user->report_name}} ${{$value->income_sum}}
                        </span>
                        <br>
                    @endif

                    @if($loop->iteration % 2 === 1 && $loop->last)
                        <br>
                    @endif
                @endforeach
                <h5>合計:${{sprintf("%.2f", $sale_summary['bakery_total'])}}</h5>
                <br>
            @endisset
            <h5>總計:${{sprintf("%.2f", $sale_summary['total'])}}</h5>
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
