@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.orders.show')}}
                </div>
                <div class="card-body">
                    <p><strong>Nombre de lo pedido</strong>: <a href="{{route('products.show', $order->products[0]->id)}}">{{$order->products[0]->name}}</a></p>
                    <p><strong>Monto pagado</strong>: {{$order->amount}}</p>
                    <p><strong>Cantidad comprada</strong>: {{$order->products[0]->pivot->quantity . ' ' . $order->products[0]->plural}}</p>
                    <p><strong>Estado de la compra</strong>: {{$order->statusFormat()}}</p>
                    <p><strong>Dia de entrega escogido</strong>: {{$order->delivery_date}}</p>
                    <p><strong>Bloques horarios de entrega elegidos</strong>:</p>
                    <p>
                        @foreach ($order->delivery_blocks as $timeBlock)
                            {{ $timeBlock->start . " - " . $timeBlock->end }}<br>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Detalles del cliente
                </div>
                <div class="card-body">
                    <p><strong>Rut</strong>: {{$order->client->rutFormat()}}</a></p>
                    <p><strong>Alias dirección</strong>: {{$order->address->alias}}</p>
                    <p><strong>Comuna</strong>: {{$order->address->town->name}}</p>
                    <p><strong>Dirección</strong>: {{$order->address->address}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection