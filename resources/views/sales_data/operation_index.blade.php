@extends('layouts.app')

@section('title')
    營業數
@stop

@section('style')
    <style>
        .square-btn{
            padding-bottom: 10px;
        }
    </style>
@endsection

@section('content')


<div align="center" style="width:100%;" class="row">
    <div class="col-sm-4 square-btn">
        <a href="{{route('sales_data.report')}}"><span class="btn" style="font-size: 40px;line-height: 50px;">營業<br/>數</span></a>
        <br/>
    </div>

    <div class="col-sm-4 square-btn">
        <a href="{{route('sales_data_change_application.apply_index')}}"><span class="btn" style="font-size: 30px;line-height: 50px;">營業數<br/>修改申請</span></a>
        <br/>
    </div>

</div>



@endsection
