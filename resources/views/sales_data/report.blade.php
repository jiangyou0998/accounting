@extends('layouts.app')

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

        <div class="py-5 text-center">
            <h2>{{$date}}</h2>
            <h2>營業數</h2>

        </div>

        <hr class="mb-4">
            <div class="copy">
                @isset($sale_summary['other'])
                    <div>{{$date}}</div>
                    <div>混合型/飯堂營業數</div>
                    @foreach($sale_summary['other'] as $value)
                        {{$value->user->report_name}} ${{$value->income_sum}}
                        八達通${{$value->details->where('type_no', 31)->first()->income ?? '0.00'}}
                        <br>
                    @endforeach
                        合計:${{$sale_summary['other']->sum('income_sum')}}<br>
                @endisset

                @isset($sale_summary['bakery'])
                    <br>
                    <div>餅店營業數</div>
                    @foreach($sale_summary['bakery'] as $value)
                        {{$value->user->report_name}} ${{$value->income_sum}}
                        <span class="octopus-total" style="display: none;">
                        八達通${{$value->details->where('type_no', 31)->first()->income ?? '0.00'}}
                        </span>
                            <br>
                    @endforeach
                        合計:${{$sale_summary['bakery']->sum('income_sum')}}<br>
                @endisset
            </div>

        <hr class="mb-4">

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
