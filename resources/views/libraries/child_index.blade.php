@extends('layouts.app')

@section('title')
    圖書館
@stop

@section('content')

    <div class="container">
        <div align="left"><a target="_top" href="javascript:history.back(-1);" style="font-size: xx-large;">返回</a></div>
        <div class="py-5 text-center">

            <h2>{{$library_groups->title ?? ''}}</h2>
            {{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
        </div>

{{--        @isset($library_groups->child)--}}
        @foreach($library_groups->child as $child_id => $child_name)
            <a href="{{ route('library.child.show', $child_id) }}">{{ $child_name }}</a>
        @endforeach
{{--        @endisset--}}

        <br><br>
        <hr>

        @foreach($library_groups->libraries as $library)
            @if($library->library_type === 'FILE')
                <div>
                    <a href="{{ '/libraries/'. $library->file_path }}" target="_blank">{{ $library->name }}</a>
                </div>
            @elseif($library->library_type === 'LINK')
                <div>
                    <a href="{{ $library->link_path }}" target="_blank">{{ $library->name }}</a>
                </div>
            @endif
        @endforeach

{{--        @if($library_groups->libraries)--}}
{{--            @foreach($library_groups->libraries as $library)--}}
{{--                @if($library->library_type === 'FILE')--}}
{{--                    <a href="{{$library->file_path}}" target="_blank">{{$library->name}}</a>--}}
{{--                @elseif($library->library_type === 'LINK')--}}
{{--                    <a href="{{$library->link_path}}" target="_blank">{{$library->name}}</a>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        @endif--}}

    </div>
@endsection
