@extends('layouts.app')

@section('title')
    柯打
@stop

@section('content')


<div align="center" style="width:100%;" class="row">

    <div class="col-sm-6">
        <!-- <a href="#"><img src="images/Order_Button_Supplier.jpg" width="150" height="150" border="0"></a> -->
        <a href="{{route('kb.select_day')}}"><span class="btn" style="font-size: 40px;line-height: 50px;">蛋撻王<br/>工場</span></a>
        <br/>
        @can('shop')

            <br/>
            <a href='{{route('kb.sample')}}' class='styleA'>創建範本</a>
            <br/>
            <br/>
            <br/>
            <!-- 快速查看下單數量 -->

            @include('order._quick_check_order',['shop'=>'kb'])

            <!-- 快速查看下單數量 -->
        @endcan
    </div>


</div>



@endsection
