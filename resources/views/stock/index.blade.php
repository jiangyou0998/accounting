@extends('layouts.app')

@section('title')
    庫存
@stop

@section('content')

    <div class="container">
        <div class="py-5 text-center">

            <h2>庫存-{{\Carbon\Carbon::now()->subMonth()->monthName}}</h2>
        </div>
        <div class="row">
            @foreach($groups as $key => $value)
                @include('stock._table')
            @endforeach
        </div>
    </div>

@endsection

@section('script')
    <script>
        //确定离开当前页面
        window.onbeforeunload = function (e) {
            var e = window.event || e;
            e.returnValue = ("确定离开当前页面吗？");
        }
    </script>
@endsection

