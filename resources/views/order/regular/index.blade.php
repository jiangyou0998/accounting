@extends('layouts.app')

@section('title')
    固定柯打
@stop

@section('content')
    <div class="container">
        <div class="py-5 text-center">

            <h2>固定柯打</h2>
            {{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
        </div>
        <div class="row">
{{--            <div class="col-md-4 mb-4">--}}
{{--                <h4 class="d-flex justify-content-between align-items-center mb-3">--}}
{{--                    <span class="text-muted">部門</span>--}}
{{--                </h4>--}}
{{--                <ul class="list-group mb-3">--}}


{{--                    <li class="list-group-item d-flex justify-content-between lh-condensed">--}}
{{--                        <div>--}}
{{--                            <h6 class="my-0">--}}
{{--                                <a href="{{route('notice')}}">--}}
{{--                                    全部--}}
{{--                                </a>--}}
{{--                            </h6>--}}

{{--                        </div>--}}

{{--                    </li>--}}


{{--                </ul>--}}


{{--            </div>--}}
            <div class="col-md-12 order-md-1">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        @foreach($shop_names as $shop_name)
                            <th scope="col">{{$shop_name}}</th>
                        @endforeach

                    </tr>
                    </thead>
                    <tbody class="table-striped" style="background-color: white">
                        @include('order.regular._table_data')
                    </tbody>
                </table>

            </div>
        </div>


@endsection
