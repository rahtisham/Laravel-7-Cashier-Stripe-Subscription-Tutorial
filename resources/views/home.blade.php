@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                   
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(\Session::has('success'))
                    <div class="alert alert-success">
                    <p><b>{{ \Session::get('success') }}</b></p>
                    </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <div style="display: flex; margin-top: 20px;">
                        <a href="create/plan" class="btn btn-primary btn-sm">CREATE PLAN</a>
                        <a style="margin-left: 10px;" href="/plans" class="btn btn-primary btn-sm">PLANS</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
