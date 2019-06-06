@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.users.edit')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('users.update', $user->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('navigation.users.name') }}:</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{old('name', $user->name)}}" />
                        </div>
                        <div class="form-group">
                            <label for="role">{{ __('navigation.users.role') }}</label>
                            <select class="custom-select form-control" name="role" id="role" >
                                @foreach($roles as $id => $name)
                                    <option value="{{$id}}" @if(old('role', $user->role)==$id) {{'selected'}} @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('navigation.users.email') }}:</label>
                            <input class="form-control" type="text" name="email" id="email" value="{{old('email', $user->email)}}" />
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('navigation.users.password') }}:</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="******" />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.users.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection