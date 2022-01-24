@extends('layouts.app')

@section('title')
    報告
@stop

@section('content')


<div align="center" style="width:100%;" class="row">
    <div class="col-sm-6">
        <a href="{{route('itsupport')}}"><span class="btn" style="font-size: 35px;line-height: 50px;">IT求助<br/>報告</span></a>
        <br/>
        <a href='{{route('itsupport.phone')}}' class='styleA'>未完成處理(手機版)</a>
        <br/>
        <br/>
        <br/>

    </div>

    <div class="col-sm-6">
        <a href="{{route('repair')}}"><span class="btn" style="font-size: 40px;line-height: 50px;">維修<br/>報告</span></a>
        <br/>
        <a href='{{route('repair.phone')}}' class='styleA'>未完成處理(手機版)</a>
        <br/>
        <br/>

    </div>

</div>



@endsection
