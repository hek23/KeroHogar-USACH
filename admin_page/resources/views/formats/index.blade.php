@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    @can('create', App\ProductFormat::class)
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mr-3 mb-2">
                <a class="btn btn-success" href="{{ route('formats.create', $product->id) }}"> {{__('navigation.formats.create')}} </a>
            </div>
        </div>
    </div>
    @endcan
    @include('partials.session_success')
    <div class="row px-3">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>N°</td>
                        <td>Nombre</td>
                        <td>Precio añadido</td>
                        <td>Capacidad</td>
                        <td>Cantidad mínima de compra</td>
                        <td colspan="3" width=20%>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productFormats as $productFormat)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td>{{ $productFormat->name }}</td>
                        <td>{{ '$' . $productFormat->added_price }}</td>
                        <td>{{ $productFormat->capacity }}</td>
                        <td>{{ $productFormat->minimum_quantity }}</td>
                        <td>
                        @can('view', App\ProductFormat::class)
                            <a href="{{ route('formats.show', [$product->id, $productFormat->id])}}" class="btn btn-info">{{__('navigation.show')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('update', App\ProductFormat::class)
                            <a href="{{ route('formats.edit', [$product->id, $productFormat->id])}}" class="btn btn-primary">{{__('navigation.edit')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('delete', App\ProductFormat::class)
                            <form action="{{ route('formats.destroy', [$product->id, $productFormat->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger delete" data-confirm="{{__('navigation.confirm_deletion')}}" type="submit">{{__('navigation.delete')}}</button>
                            </form>
                        @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $productFormats->links() !!}
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection