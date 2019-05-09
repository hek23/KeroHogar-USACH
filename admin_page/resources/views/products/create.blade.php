@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.products.create')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('products.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('navigation.products.name') }}:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Relleno de bidones de parafina" value="{{old('name')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="price">{{ __('navigation.products.price') }}:</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="24000" value="{{old('price')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="minimum_amount">{{ __('navigation.products.minimum_amount') }}:</label>
                            <input type="number" class="form-control" name="minimum_amount" id="minimum_amount" placeholder="1" value="{{old('minimum_amount')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="unit">{{ __('navigation.products.unit') }}:</label>
                            <input type="text" class="form-control" name="unit" id="unit" placeholder="bidón" value="{{old('unit')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="plural">{{ __('navigation.products.plural') }}:</label>
                            <input type="text" class="form-control" name="plural" id="plural" placeholder="bidones" value="{{old('plural')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="liters_per_unit">{{ __('navigation.products.liters_per_unit') }}:</label>
                            <input type="number" class="form-control" name="liters_per_unit" id="liters_per_unit" placeholder="20" value="{{old('liters_per_unit')}}" required />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.products.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection