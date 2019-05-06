@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="float-left">
                @include('partials.errors')
                <form method="post" action="{{ route('orders.filter') }}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="client_type">Nombre del pedido:</label>
                        <input type="text" class="form-control" name="client_type" value="{{old('')}}" />
                    </div>
                    <div class="form-group">
                        <label for="time_interval">Precio del pedido:</label>
                        <input type="text" class="form-control" name="time_interval" value="{{old('')}}" />
                    </div>
                    <div class="form-group">
                        <label for="town">Cantidad del pedido:</label>
                        <input type="text" class="form-control" name="town" value="{{old('')}}" />
                    </div>
                    <div class="form-group">
                        <label for="order_status">Cantidad del pedido:</label>
                        <input type="text" class="form-control" name="order_status" value="{{old('')}}" />
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
            <div class="float-right mr-3 mb-2">
                <a class="btn btn-success" href="{{ route('orders.create') }}"> {{__('navigation.orders.create')}} </a>
            </div>
        </div>
    </div>
    @include('partials.session_success')
    <div class="row px-3">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>N°</td>
                        <td>Cliente</td>
                        <td>Pedido</td>
                        <td>Estado</td>
                        <td>Monto</td>
                        <td>Comuna</td>
                        <td>Día entrega</td>
                        <td>Horario entrega</td>
                        <td colspan="3" width=20%>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td>{{ $order->client->rutFormat() }}</td>
                        <td>{{ $order->client->rut }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->amount }}</td>
                        <td>{{ $order->address->town->name }}</td>
                        <td>{{ $order->delivery_date }}</td>
                        <td>{{ $order->delivery_date }}</td>
                        <td><a href="{{ route('orders.show', $order->id)}}" class="btn btn-info">{{__('navigation.show')}}</a></td>
                        <td><a href="{{ route('orders.edit', $order->id)}}" class="btn btn-primary">{{__('navigation.edit')}}</a></td>
                        <td>
                            <form action="{{ route('orders.destroy', $order->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger delete" data-confirm="{{__('navigation.confirm_deletion')}}" type="submit">{{__('navigation.delete')}}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $orders->links() !!}
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection