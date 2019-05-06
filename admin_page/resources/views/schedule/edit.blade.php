@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.schedule.edit')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('schedule.update', $timeBlock->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre del pedido:</label>
                            <input type="text" class="form-control" name="name" value="{{$timeBlock->name}}" />
                        </div>
                        <div class="form-group">
                            <label for="price">Precio del pedido:</label>
                            <input type="text" class="form-control" name="price" value="{{$timeBlock->price}}" />
                        </div>
                        <div class="form-group">
                            <label for="quantity">Cantidad del pedido:</label>
                            <input type="text" class="form-control" name="quantity" value="{{$timeBlock->quantity}}" />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.schedule.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection