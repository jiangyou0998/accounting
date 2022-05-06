@extends('layouts.app')

@section('title')
    首頁
@stop

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-8">
                <!-- Banner Intro -->
                @include('home._banner')
                <!-- Banner Intro -->
            </div>

                <div class="col-md-4 mb-4">
                    <!-- 快速進入 -->
                    @include('home._quick_link')
                    <!-- 快速進入 -->

                </div>
            </div>

    </div>

    <!-- 最新通告 -->
    @include('home._notice')

@endsection
