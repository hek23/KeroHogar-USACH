@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.formats.create')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('formats.store', $product->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('navigation.formats.name') }}:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Bidón + parafina" value="{{old('name')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="added_price">{{ __('navigation.formats.added_price') }}:</label>
                            <input type="number" class="form-control" name="added_price" id="added_price" placeholder="$1000 por bidón" value="{{old('added_price')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="capacity">{{ __('navigation.formats.capacity') }}:</label>
                            <input type="number" class="form-control" name="capacity" id="capacity" placeholder="20 litros" value="{{old('capacity')}}" />
                        </div>
                        <div class="form-group">
                            <label for="minimum_quantity">{{ __('navigation.formats.minimum_quantity') }}:</label>
                            <input type="number" class="form-control" name="minimum_quantity" id="minimum_quantity" placeholder="40 litros mínimo por pedido" value="{{old('minimum_quantity')}}" required />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.formats.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection