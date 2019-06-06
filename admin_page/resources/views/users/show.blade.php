@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.users.show')}}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('navigation.users.name') }}</strong>: {{$user->name}}</p>
                    <p><strong>{{ __('navigation.users.role') }}</strong>: {{$user->roleFormat()}}</p>
                    <p><strong>{{ __('navigation.users.email') }}</strong>: {{$user->email}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection