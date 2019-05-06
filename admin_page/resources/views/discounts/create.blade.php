@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.discounts.create')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('discounts.store', $product->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre del pedido:</label>
                            <input type="text" class="form-control" name="name" />
                        </div>
                        <div class="form-group">
                            <label for="price">Precio del pedido:</label>
                            <input type="text" class="form-control" name="price" />
                        </div>
                        <div class="form-group">
                            <label for="quantity">Cantidad del pedido:</label>
                            <input type="text" class="form-control" name="quantity" />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.discounts.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection