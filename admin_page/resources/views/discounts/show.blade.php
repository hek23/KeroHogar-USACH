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
                    <p><strong>{{ __('navigation.discounts.discount_per_liter') }}</strong>: {{$productDiscount->formatDiscount()}}</p>
                    <p><strong>{{ __('navigation.discounts.min_quantity') }}</strong>: {{$productDiscount->formatMinQuantity()}}</p>
                    <p><strong>{{ __('navigation.discounts.max_quantity') }}</strong>: {{$productDiscount->formatMaxQuantity()}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection