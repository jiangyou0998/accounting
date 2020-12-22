@extends('layouts.app')

@section('title')
    柯打
@stop

@section('content')


<div align="center" style="width:100%;" class="row">
    <div class="col-sm-6">
        <!-- <a href="select_day_dept.php?advDays=14"><img src="images/Order_Button_Stock.jpg" width="150" height="150" border="0"></a> -->
        <a href="{{route('select_day')}}"><span class="btn" style="font-size: 40px;line-height: 50px;">中央<br/>工場</span></a>
        <br/>
        @can('workshop')
{{--            <a href="order_check.php?head=5" class="styleA">翻查柯打</a>--}}
            <br/>
            <a href='{{route('order.deli.list')}}' class='styleA'>改發票</a>
            <br/>
            <a href='{{route('order.select_old_order',['dept'=>'R'])}}' class='styleA'>改舊單</a>
            <br/>
            <a href='{{route('order.select_deli')}}' class='styleA'>送貨單查詢</a>
        @endcan

        @can('operation')
{{--            <br/>--}}
{{--            <a href='{{route('sample.regular')}}' class='styleA'>固定柯打範本</a>--}}
{{--            <br/>--}}
{{--            <a href='{{route('order.regular')}}' class='styleA'>批量下單</a>--}}
            <br/>
            <a href='{{route('order.select_deli')}}' class='styleA'>送貨單查詢</a>
        @endcan

        @can('shop')
{{--            <a href="order_check.php?head=5" class="styleA">翻查柯打</a>--}}
            <br/>
            <a href='{{route('sample')}}' class='styleA'>創建範本</a>
            <br/>
            <a href='{{route('order.deli')}}' class='styleA' target='view_window'>查看落貨單</a>
        @endcan

    </div>
{{--    <div class="col-sm-6">--}}
{{--        <!-- <a href="#"><img src="images/Order_Button_Supplier.jpg" width="150" height="150" border="0"></a> -->--}}
{{--        <a href="#"><span class="btn" style="font-size: 30px;line-height: 100px;">供應商</span></a>--}}
{{--    </div>--}}
</div>



@endsection
