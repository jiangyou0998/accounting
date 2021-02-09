@extends('layouts.app')

@section('title')
    通告
@stop

@section('content')

<div class="container">
    <div class="py-5 text-center">

        <h2>通告</h2>
{{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">部門</span>
            </h4>
            <ul class="list-group mb-3">


                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">
                            <a href="{{route('notice')}}">
                                全部
                            </a>
                        </h6>

                    </div>

                </li>
                @foreach($dept_names as $key => $dept_name)
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="{{route('notice',['dept' => $key , 'search' => $search])}}">{{$dept_name}}</a>
                            </h6>
                        </div>

                    </li>
                @endforeach

            </ul>

            <form class="card p-2" method="POST" action="{{route('notice')}}">
                <div class="input-group">
                    @csrf
                    <input id="search" name="search" type="text" class="form-control" placeholder="根據編號或主旨查詢" value="{{ $search }}">
                    <input id="dept" name="dept" type="hidden" value="{{ request()->dept }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">查詢</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8 order-md-1">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">日期</th>
                    <th scope="col">編號</th>
                    <th scope="col">主旨</th>
                    <th scope="col">部門</th>
                    <th scope="col">鏈接</th>
                </tr>
                </thead>
                <tbody class="table-striped" style="background-color: white">
                @foreach($notices as $notice)
                <tr>
                    <th scope="row" width="20%">{{\Carbon\Carbon::parse($notice->updated_at)->toDateString()}}</th>
                    <td width="10%">{{$notice->notice_no}}</td>
                    <td width="40%">
                        @if($notice->is_directory)
                            <a href="{{route('notice.attachment',$notice->id)}}" target="_blank">
                                {{$notice->notice_name}}
                            </a>
                            <span class="badge badge-success">附件</span>
                        @else
                            <a href="{{'/notices/'.$notice->file_path}}" target="_blank">
                                {{$notice->notice_name}}
                            </a>
                        @endif

                        @if($notice->isNew)
                            <span class="badge badge-danger">New</span>
                        @endif
                    </td>
                    <td width="20%">{{$dept_names[$notice->admin_role_id]}}</td>
                    <td width="10%">
                        @if($notice->first_path)
                            <a href="{{'http://'.$notice->first_path}}" target="_blank">鏈接</a>
                        @endif
                    </td>
                </tr>
{{--                <tr class="child_row_01">--}}
{{--                    <th>分区</th>--}}
{{--                    <th>类型</th>--}}
{{--                    <th>是否挂载</th>--}}
{{--                    --}}
{{--                </tr>--}}
                @endforeach
                </tbody>
            </table>
            {{$notices->appends(['dept' => request()->dept ,'search' => $search])->links()}}
        </div>
    </div>

@endsection

