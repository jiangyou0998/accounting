@extends('layouts.app')

@section('content')

<div class="container">
    <div class="py-5 text-center">

        <h2>表格</h2>
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
                            <a href="{{route('form')}}">
                                全部
                            </a>
                        </h6>

                    </div>

                </li>
                @foreach($dept_names as $key => $dept_name)
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">
                                <a href="{{route('form',['dept' => $key])}}">{{$dept_name}}</a>
                            </h6>
                        </div>

                    </li>
                @endforeach

            </ul>

            <form class="card p-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo code">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
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
                </tr>
                </thead>
                <tbody class="table-striped" style="background-color: white">
                @foreach($forms as $form)
                <tr>
                    <th scope="row" width="20%">{{$form->modify_date}}</th>
                    <td width="10%">{{$form->form_no}}</td>
                    <td width="45%">
                        <a href="{{'/forms/'.$form->file_path}}">
                            {{$form->form_name}}
                        </a>

                    </td>
                    <td width="25%">{{$dept_names[$form->admin_role_id]}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{$forms->links()}}
        </div>
    </div>

@endsection
