@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="float-left">
                @include('partials.errors')
                <form action="{{ route('orders.index') }}">
                    <div class="form-inline mb-2 ml-3">
                        <div class="form-group" style="flex-flow:column;">
                            <label for="client_type">Tipo de cliente:</label>
                            <select class="custom-select form-control mx-2" name="client_type" id="client_type">
                                <option value="0">Escoger...</option>
                                @foreach($clientTypes as $id => $name)
                                    <option value="{{$id}}" @if($client_type == $id) {{'selected'}} @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="client_type">Comienzo de intervalo:</label>
                            <input type="date" class="form-control mx-2" name="time_interval_start" id="time_interval_start" value="{{$time_interval_start}}" />
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="client_type">Fin de intervalo:</label>
                            <input type="date" class="form-control mx-2" name="time_interval_end" id="time_interval_end" value="{{$time_interval_end}}" />
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="client_type">Comuna:</label>
                            <select class="custom-select form-control mx-2" name="town_id" id="town_id" >
                                <option value="0">Escoger...</option>
                                @foreach($towns as $id => $name)
                                    <option value="{{$id}}" @if($town_id == $id) {{'selected'}} @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="client_type">Estado:</label>
                            <select class="custom-select form-control mx-2" name="order_status" id="order_status" >
                                <option value="0">Escoger...</option>
                                @foreach($orderStatuses as $id => $name)
                                    <option value="{{$id}}" @if($order_status == $id) {{'selected'}} @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mx-2">Filtrar</button>
                        <button type="submit" class="btn btn-success ml-2" name="generate_excel" value='1'>Generar Excel</button>
                    </div>
                </form>
            </div>
            <div class="float-right mr-3 mt-2">
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
                        <td>{{ $order->products[0]->name }}</td>
                        <td>{{ $order->statusFormat() }}</td>
                        <td>{{ $order->amount }}</td>
                        <td>{{ $order->address->town->name }}</td>
                        <td>{{ $order->delivery_date }}</td>
                        <td>
                            @foreach ($order->delivery_blocks as $timeBlock)
                                {{ $timeBlock->start . " - " . $timeBlock->end }}<br>
                            @endforeach
                        </td>
                        <td><a href="{{ route('orders.show', $order->id)}}" class="btn btn-info">{{__('navigation.show')}}</a></td>
                        <td>
                            @if($order->status !== App\Order::DELIVERED)
                            <form action="{{ route('orders.delivered', $order->id)}}" method="post">
                                @csrf
                                <button class="btn btn-primary delete" data-confirm="{{__('navigation.confirm_delivered')}}" type="submit">{{__('navigation.delivered')}}</button>
                            </form>
                            @endif
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