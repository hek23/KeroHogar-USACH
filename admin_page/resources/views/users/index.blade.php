@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    @can('create', App\User::class)
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mr-3 mb-2">
                <a class="btn btn-success" href="{{ route('users.create') }}"> {{__('navigation.users.create')}} </a>
            </div>
        </div>
    </div>
    @endcan
    @include('partials.session_success')
    <div class="row px-3">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>N°</td>
                        <td>Nombre</td>
                        <td>Rol</td>
                        <td>Correo</td>
                        <td colspan="3" width="20%">Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->roleFormat() }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                        @can('view', App\User::class)
                            <a href="{{ route('users.show', $user->id)}}" class="btn btn-info">{{__('navigation.show')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('update', $user)
                            <a href="{{ route('users.edit', $user->id)}}" class="btn btn-primary">{{__('navigation.edit')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('delete', $user)
                            <form action="{{ route('users.destroy', $user->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger delete" data-confirm="{{__('navigation.confirm_deletion')}}" type="submit">{{__('navigation.delete')}}</button>
                            </form>
                        @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $users->links() !!}
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection