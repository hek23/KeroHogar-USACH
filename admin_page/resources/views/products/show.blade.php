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
                    <p><strong>{{ __('navigation.products.wholesaler_price') }}</strong>: {{$product->wholesaler_price}}</p>
                    <p><strong>{{ __('navigation.products.is_compounded') }}</strong>: {{$product->is_compounded == 1 ? 'Si' : 'No'}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection