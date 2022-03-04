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
            <a href='{{route('order.deli.list')}}' class='styleA'>改發票(蛋撻王)</a>
            <br/>
            <a href='{{route('order.deli.list',['group'=>'RB'])}}' class='styleA'>改發票(糧友)</a>
            <br/>
            <a href='{{route('order.deli.list',['group'=>'CU'])}}' class='styleA'>改發票(外客)</a>
            <br/>
            <a href='{{route('order.select_old_order',['dept'=>'R'])}}' class='styleA'>改舊單(蛋撻王)</a>
            <br/>
            <a href='{{route('rb.order.select_old_order',['dept'=>'RB'])}}' class='styleA'>改舊單(糧友)</a>
            <br/>
            <a href='{{route('customer.select_group')}}' class='styleA'>外客下單</a>
            <br/>
            <a href='{{route('customer.sample.index')}}' class='styleA'>外客範本</a>
            <br/>
            <a href='{{route('order.regular.sample',['shop_group_id' => 1])}}' class='styleA'>固定柯打(蛋撻王)</a>
            <br/>
            <a href='{{route('order.regular',[ 'dept' => 'F' ,'shop_group_id' => 1])}}' class='styleA'>批量下單(蛋撻王)</a>
            <br/>
            <a href='{{route('order.regular.sample',['shop_group_id' => 1])}}' class='styleA'>臨時加單(蛋撻王)</a>
            <br/>
            <a href='{{route('order.regular.sample',['shop_group_id' => 5])}}' class='styleA'>臨時加單(糧友)</a>
            <br/>
            <a href='{{route('order.select_deli')}}' class='styleA'>送貨單查詢</a>
            <br/>
            <a href='{{route('order.update_price')}}' class='styleA'>更新價錢</a>
            <br/>
            <a href='{{route('order.batch_delete')}}' class='styleA'>批量刪除貨品</a>
            <br/>
            <a href='{{route('order.order_change')}}' class='styleA'>柯打改期</a>
            <br/>
            <a href='{{route('order.order_delete')}}' class='styleA'>柯打全單刪除</a>
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

            <!-- 快速查看下單數量 -->
            @include('order._quick_check_order')
            <!-- 快速查看下單數量 -->
        @endcan

    </div>
{{--    <div class="col-sm-6">--}}
{{--        <!-- <a href="#"><img src="images/Order_Button_Supplier.jpg" width="150" height="150" border="0"></a> -->--}}
{{--        <a href="#"><span class="btn" style="font-size: 30px;line-height: 100px;">供應商</span></a>--}}
{{--    </div>--}}
</div>



@endsection
