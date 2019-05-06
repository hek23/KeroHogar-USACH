@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.prices.show')}}
                </div>
                <div class="card-body">
                    <p><strong>Nombre del pedido</strong>: {{$orderPrice->name}}</p>
                    <p><strong>Precio del pedido</strong>: {{$orderPrice->price}}</p>
                    <p><strong>Cantidad del pedido</strong>: {{$orderPrice->quantity}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection