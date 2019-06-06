@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    @can('create', App\TimeBlock::class)
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mr-3 mb-2">
                <a class="btn btn-success" href="{{ route('schedule.create') }}"> {{__('navigation.schedule.create')}} </a>
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
                        <td>Inicio</td>
                        <td>Fin</td>
                        <td>Máx. pedidos/entregas</td>
                        <td colspan="3" width="20%">Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeBlocks as $timeBlock)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td>{{ $timeBlock->start }}</td>
                        <td>{{ $timeBlock->end }}</td>
                        <td>{{ $timeBlock->max_orders }}</td>
                        <td>
                        @can('view', App\TimeBlock::class)
                            <a href="{{ route('schedule.show', $timeBlock->id)}}" class="btn btn-info">{{__('navigation.show')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('update', App\TimeBlock::class)
                            <a href="{{ route('schedule.edit', $timeBlock->id)}}" class="btn btn-primary">{{__('navigation.edit')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('delete', App\TimeBlock::class)
                            <form action="{{ route('schedule.destroy', $timeBlock->id)}}" method="post">
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

            {!! $timeBlocks->links() !!}
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection