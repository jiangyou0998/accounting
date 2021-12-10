@extends('layouts.app')

@section('title')
    維修項目-未完成處理
@stop

@section('content')

    <div class="container">
        <div class="py-5 text-center">
            <h2>維修項目</h2>
            <h2>未完成處理</h2>
        </div>

        <hr class="mb-4">
        @include('support.repair.phone._unfinished')
        <hr class="mb-4">

    </div>

@endsection
