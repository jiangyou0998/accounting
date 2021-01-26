@extends('layouts.app')

@section('title')
    圖書館
@stop

@section('content')

    <div class="container">
        <div class="py-5 text-center">

            <h2>圖書館</h2>
            {{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
        </div>

{{--        @foreach($library_groups->chunk(3) as $library_group)--}}
{{--            <div class="card-deck mb-3 text-center">--}}
{{--                @foreach($library_group as $parent_group)--}}
{{--                <div class="card mb-4 box-shadow">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4 class="my-0 font-weight-normal">{{$parent_group->title}}</h4>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1>--}}
{{--                        <ul class="list-unstyled mt-3 mb-4">--}}
{{--                            @foreach($parent_group->child_menu_has_libraries as $item)--}}
{{--                                <li style="padding-bottom: 10px">--}}
{{--                                    <h5>--}}
{{--                                        <a href="{{route('library.child.show',$item->id)}}">{{$item->title}}</a>--}}
{{--                                    </h5>--}}
{{--                                </li>--}}
{{--                                <li style="text-align:left">{{$item->title}}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                        <button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        @endforeach--}}



    </div>
@endsection
