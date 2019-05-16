@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.formats.show')}}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('navigation.formats.name') }}</strong>: {{$productFormat->name}}</p>
                    <p><strong>{{ __('navigation.formats.added_price') }}</strong>: {{'$' . $productFormat->added_price}}</p>
                    <p><strong>{{ __('navigation.formats.capacity') }}</strong>: {{$productFormat->capacity}}</p>
                    <p><strong>{{ __('navigation.formats.minimum_quantity') }}</strong>: {{$productFormat->minimum_quantity}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection