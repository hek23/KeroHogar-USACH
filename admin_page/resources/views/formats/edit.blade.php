@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.formats.edit')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('formats.update', [$product->id, $productFormat->id]) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('navigation.formats.name') }}:</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name', $productFormat->name)}}" required />
                        </div>
                        <div class="form-group">
                            <label for="added_price">{{ __('navigation.formats.added_price') }}:</label>
                            <input type="number" class="form-control" name="added_price" id="added_price" value="{{old('added_price', $productFormat->added_price)}}" required />
                        </div>
                        <div class="form-group">
                            <label for="capacity">{{ __('navigation.formats.capacity') }}:</label>
                            <input type="number" class="form-control" name="capacity" id="capacity" value="{{old('capacity', $productFormat->capacity)}}" />
                        </div>
                        <div class="form-group">
                            <label for="minimum_quantity">{{ __('navigation.formats.minimum_quantity') }}:</label>
                            <input type="number" class="form-control" name="minimum_quantity" id="minimum_quantity" value="{{old('minimum_quantity', $productFormat->minimum_quantity)}}" required />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.formats.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection