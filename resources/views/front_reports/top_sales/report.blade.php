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
        <hr>

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
                        <input class="shop-checkbox" type="checkbox" name="shop" value="{{$shop->id}}" @if(in_array($shop->id, explode(',', request()->shop_ids))) checked @endif>
                        <span class="checkbox">{{$shop->report_name}}</span>
                    </label>
                @endforeach
            </div>

            @foreach($catsAndGroups as $cat_name => $group)
                <div class="row">
                    <div class="col-12">
                        <h1>{{$cat_name}}</h1>
                        <input class="check-all" type="checkbox" data-name="{{$cat_name}}" onclick="checkAll('{{$cat_name}}')">
                        <span class="checkbox" data-name="{{$cat_name}}">全選</span>
                        <hr>
                    </div>
                    <div class="col-12">
                        @foreach($group as $group_id => $group_name)
                            <label style="padding-right:15px;">
                                <input class="group-checkbox" type="checkbox" name="group"  value="{{$group_id}}" data-name="{{$cat_name}}" @if(in_array($group_id, explode(',', request()->group_ids))) checked @endif>
                                <span class="checkbox">{{$group_name}}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="row">
                <button class="btn btn-success btn-search">查詢</button>
{{--                <button class="btn btn-primary btn-clear-group-search">清空部門</button>--}}
                <button class="btn btn-danger btn-clear-search">清空搜索條件</button>
            </div>

            <input type="hidden" name="shopstr" id="shopstr" data-loading-text="..." value="{{ request()->shop_ids }}"/>
            <input type="hidden" name="groupstr" id="groupstr" value="{{ request()->group_ids }}"/>
        </div>

@endsection

@section('script')
        <script>
            //鉤選或取消時,修改shopstr(隱藏)的值
            $(document).on('change', '.shop-checkbox', function () {
                let shopstr = $('.shop-checkbox:checked').map(function () {
                    return this.value
                }).get().join(',');
                $('#shopstr').val(shopstr);
            });

            //鉤選或取消時,修改groupstr(隱藏)的值
            $(document).on('change', '.group-checkbox', function () {
                let groupstr = $('.group-checkbox:checked').map(function () {
                    return this.value
                }).get().join(',');
                $('#groupstr').val(groupstr);
            });

            //全選/反選
            function checkAll(cat_name){
                // let cat_name = $(obj).data('name');
                console.log(cat_name);
                let input = $("input[data-name=" + cat_name + "]");
                if($(".check-all[data-name=" + cat_name + "]").prop("checked")){    //判斷check_all是否被選中
                    input.prop("checked",true);//全選
                    $(".checkbox[data-name=" + cat_name + "]").html("取消");
                }else{
                    input.prop("checked",false); //反選
                    $(".checkbox[data-name=" + cat_name + "]").html("全選");
                }
                input.trigger('change');
            }

            $(document).on('click', '.btn-search', function () {

                $(this).attr('disabled', true);

                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                let shopstr = $('#shopstr').val();

                if(start_date === ''){
                    Swal.fire({
                        icon: 'error',
                        title: "請選擇「開始時間」!",
                    });
                    $(this).attr('disabled', false);
                    return ;
                }

                if(end_date === ''){
                    Swal.fire({
                        icon: 'error',
                        title: "請選擇「結束時間」!",
                    });
                    $(this).attr('disabled', false);
                    return ;
                }

                if(shopstr === ''){
                    Swal.fire({
                        icon: 'error',
                        title: "請選擇「分店」!",
                    });
                    $(this).attr('disabled', false);
                    return ;
                }

                let url = '{{ route('top_sales.report')}}'
                    + '?start_date=' + $('#start_date').val()
                    + '&end_date=' + $('#end_date').val()
                    + '&shop_ids=' + $('#shopstr').val();

                if($('#groupstr').val()){
                    url += '&group_ids=' + $('#groupstr').val();
                }

                window.location.href = url;

            });

            $(document).on('click', '.btn-clear-search', function () {

                window.location.href  = '{{ route('top_sales.report')}}';

            });
        </script>
@endsection

