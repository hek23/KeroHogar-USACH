@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.products.show')}}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('navigation.products.name') }}</strong>: {{$product->name}}</p>
                    <p><strong>{{ __('navigation.products.price') }}</strong>: {{$product->price}}</p>
                    <p><strong>{{ __('navigation.products.minimum_amount') }}</strong>: {{$product->minimum_amount}}</p>
                    <p><strong>{{ __('navigation.products.unit') }}</strong>: {{$product->unit}}</p>
                    <p><strong>{{ __('navigation.products.plural') }}</strong>: {{$product->plural}}</p>
                    <p><strong>{{ __('navigation.products.liters_per_unit') }}</strong>: {{$product->liters_per_unit}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection