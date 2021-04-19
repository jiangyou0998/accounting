@extends('layouts.app')

@section('title')
    圖書館
@stop

@section('content')

    <div class="container">
        @include('libraries._search_box')

        <div class="py-4 text-center">
            <h2>{{request()->keyword ? '「'.request()->keyword.'」的搜索結果' : '全部結果'}}</h2>
        </div>

        <hr>

        <div class="list-group">
            @foreach($libraries as $library)
                @if($library->library_type === 'FILE')
                    <a href="{{ '/libraries/'. $library->file_path }}" target="_blank" class="list-group-item">
                        <h4 class="d-flex justify-content-between list-group-item-heading">
                            {{ $library->name }}
                            <span class="badge badge-secondary">{{ $library->group_name }}</span>
                        </h4>
                    </a>
                @elseif($library->library_type === 'LINK')
                    <a href="{{ $library->link_path }}" target="_blank" class="list-group-item">
                        <h4 class="d-flex justify-content-between list-group-item-heading">
                            {{ $library->name }}
                            <span class="badge badge-secondary">{{ $library->group_name }}</span>
                        </h4>
                    </a>
                @endif
            @endforeach

        </div>
        <br><br>
    </div>
@endsection
