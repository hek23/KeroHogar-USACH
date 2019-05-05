@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.orders.show')}}
                </div>
                <div class="card-body">
                    <p><strong>Nombre del pedido</strong>: {{$order->name}}</p>
                    <p><strong>Precio del pedido</strong>: {{$order->price}}</p>
                    <p><strong>Cantidad del pedido</strong>: {{$order->quantity}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection