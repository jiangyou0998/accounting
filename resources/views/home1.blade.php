@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                <div>
                    用户角色为: {{ auth()->user()->getRoleNames() }}
                </div>
                <div>
                    @can('visit_home')
                        visit_home
                    @endcan
                </div>
                <div>
                    @can('show_users')
                        show_users
                    @endcan
                </div>
                <div>
                    @can('edit_users')
                        edit_users
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if (app()->isLocal())
    @include('sudosu::user-selector')
@endif
