@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.products.edit')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('products.update', $product->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('navigation.products.name') }}:</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name', $product->name)}}" required />
                        </div>
                        <div class="form-group">
                            <label for="price">{{ __('navigation.products.price') }}:</label>
                            <input type="number" class="form-control" name="price" id="price" value="{{old('price', $product->price)}}" required />
                        </div>
                        <div class="form-group">
                            <label for="wholesaler_price">{{ __('navigation.products.wholesaler_price') }}:</label>
                            <input type="number" class="form-control" name="wholesaler_price" id="wholesaler_price" value="{{old('wholesaler_price', $product->wholesaler_price)}}" required />
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="is_compounded" value=0 />
                            <input type="checkbox" class="form-check-input" name="is_compounded" id="is_compounded" value=1 {{old('is_compounded', $product->is_compounded) == 1 ? 'checked' : '' }} />
                            <label for="is_compounded">{{ __('navigation.products.is_compounded') }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.products.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection