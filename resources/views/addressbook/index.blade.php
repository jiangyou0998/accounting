@extends('layouts.app')

@section('title')
    通訊錄
@stop

@section('content')

<div class="container">
    <div class="py-5 text-center">
        <h2>通訊錄</h2>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">

            </h4>
            <ul class="list-group mb-3">


                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">
                            <a href="{{route('addressbook')}}">
                                全部
                            </a>
                        </h6>
                    </div>
                </li>
                @include('addressbook._nav')

            </ul>

        </div>
        <div class="col-md-8 order-md-1 bg-white">
            <table width="100%" border="1" cellspacing="1" cellpadding="3" id="table01" style="z-index: 100">
                <tbody><tr style="background-color:#CCFFFF;">
                    <td align="center" width="15%"><strong>分店</strong></td>
                    <td align="center" width="75%"><strong>資料</strong></td>
                </tr>
                @include('addressbook._table_data')

                </tbody>
            </table>

        </div>
    </div>

@endsection

