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
                            <label for="discount_per_liter">{{ __('navigation.discounts.discount_per_liter') }}</label>
                            <input class="form-control" type="number" name="discount_per_liter" id="discount_per_liter" placeholder="20" value="{{old('discount_per_liter')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="min_quantity">{{ __('navigation.discounts.min_quantity') }}</label>
                            <input class="form-control" type="number" name="min_quantity" id="min_quantity" placeholder="5" value="{{old('min_quantity')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="max_quantity">{{ __('navigation.discounts.max_quantity') }}</label>
                            <input class="form-control" type="number" name="max_quantity" id="max_quantity" placeholder="10" value="{{old('max_quantity')}}" required />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.discounts.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection