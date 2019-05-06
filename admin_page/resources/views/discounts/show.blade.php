@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.discounts.show')}}
                </div>
                <div class="card-body">
                    <p><strong>Nombre del pedido</strong>: {{$productDiscount->name}}</p>
                    <p><strong>Precio del pedido</strong>: {{$productDiscount->price}}</p>
                    <p><strong>Cantidad del pedido</strong>: {{$productDiscount->quantity}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection