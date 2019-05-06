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
                    <p><strong>Nombre del pedido</strong>: {{$product->name}}</p>
                    <p><strong>Precio del pedido</strong>: {{$product->price}}</p>
                    <p><strong>Cantidad del pedido</strong>: {{$product->quantity}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection