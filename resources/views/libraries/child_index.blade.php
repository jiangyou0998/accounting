@extends('layouts.app')

@section('title')
    圖書館
@stop

@section('content')

    <div class="container">
        <div class="py-5 text-center">

            <h2>{{$library_groups['title'] ?? ''}}</h2>
            {{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
        </div>

        @isset($library_groups['children'])
            @foreach($library_groups['children'] as $child)
                <a href="{{route('library.child.show',$child['id'])}}">{{$child['title']}}</a>
            @endforeach
        @endisset

        <br><br>
        <hr>

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
