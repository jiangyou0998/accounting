@extends('layouts.app')

@section('title')
    通告
@stop

@section('content')

<div class="container">
    <div class="py-5 text-center">

        <h2>{{$notice->notice_name}}</h2>
{{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
    </div>
    <div class="row">
        <div class="col-md-12 mb-12">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">附件</span>
            </h4>
            <ul class="list-group mb-3">

                @foreach($notice->attachments as $attachment)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">
                            <a href="{{'/notices/'.$attachment->file_path}}" target="_blank">
                                {{$attachment->title ?? '無標題'}}
                            </a>
                        </h6>
                    </div>

                </li>
                @endforeach

            </ul>

        </div>

    </div>

@endsection

