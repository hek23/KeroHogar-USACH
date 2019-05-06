@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.schedule.show')}}
                </div>
                <div class="card-body">
                    <p><strong>Nombre del pedido</strong>: {{$timeBlock->name}}</p>
                    <p><strong>Precio del pedido</strong>: {{$timeBlock->price}}</p>
                    <p><strong>Cantidad del pedido</strong>: {{$timeBlock->quantity}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection