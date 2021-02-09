@extends('layouts.app')

@section('title')
    圖書館
@stop

{{--@section('style')--}}
{{--    <style>--}}
{{--        .card-deck {--}}
{{--            @include media-breakpoint-only(lg) {--}}
{{--                column-count: 4;--}}
{{--            }--}}
{{--        }--}}
{{--    </style>--}}

{{--@stop--}}

@section('content')

    <div class="container">
        <div class="py-5 text-center">

            <h2>圖書館</h2>
            {{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
        </div>

                @foreach($library_groups as $parent_group)
                    @if(($loop->index % 3) == 0)
                        <div class="card-deck mb-3 text-center">
                    @endif

                    <div class="card mb-4 box-shadow">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">{{$parent_group['title']}}</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mt-3 mb-4">
                                @if(isset($parent_group['children']))
                                    @foreach($parent_group['children'] as $item)
                                        <li style="padding-bottom: 10px">
                                            <h5>
                                                <a href="{{route('library.child.show',$item['id'])}}">{{$item['title']}}</a>
                                            </h5>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    @if($loop->index % 3 == 2 || $loop->last)
                        </div>
                    @endif
                @endforeach




    </div>
@endsection
