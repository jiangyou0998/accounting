@extends('layouts.app_print')

@section('title')
    供應商庫存
@stop

@section('style')
    <style>
        .table td, .table th {
            padding: initial;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        {{--        標題--}}
        <div class="py-1 text-center">

            <h2>供應商庫存-{{$monthname}}</h2>
        </div>
        <hr>
        <div class="row">

            <div class="col-md-12 mb-12 right-div">
                @if(count($products))
                    @include('stock._supplier_table_print')
                @else
                    <h1>暫無查詢結果!</h1>
                @endif
            </div>
        </div>

@endsection

