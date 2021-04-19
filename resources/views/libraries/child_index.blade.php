@extends('layouts.app')

@section('title')
    圖書館
@stop

@section('content')

    <div class="container">
        @include('libraries._search_box')

        <div class="py-5 text-center">

            <h2>{{$library_groups->title ?? ''}}</h2>
            {{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
        </div>

{{--        @isset($library_groups->child)--}}

        @if($library_groups->child->count())
            <h4>分類</h4>
            @foreach($library_groups->child as $child_id => $child_name)

                <a class="btn
                @if($loop->index % 3 == 0)
                    btn-primary
                @elseif($loop->index % 3 == 1)
                    btn-danger
                @elseif($loop->index % 3 == 2)
                    btn-success
                @endif"
                   href="{{ route('library.child.show', $child_id) }}">
                    {{ $child_name }}
                </a>

            @endforeach
            <br><br>
        @endif
        {{--        @endisset--}}

        @if($library_groups->libraries->count())
        <hr>

        <div class="list-group">
            <h4>文件</h4>
            @foreach($library_groups->libraries as $library)
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
        @endif
        <br><br>

    </div>


@endsection
