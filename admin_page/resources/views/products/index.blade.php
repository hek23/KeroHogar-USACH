@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    @can('create', App\Product::class)
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mr-3 mb-2">
                <a class="btn btn-success" href="{{ route('products.create') }}"> {{__('navigation.products.create')}} </a>
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
                        <td>Producto</td>
                        <td>Precio</td>
                        <td>Precio Distribuidor</td>
                        <td colspan="5" width=30%>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ '$' . $product->price }}</td>
                        <td>{{ '$' . $product->wholesaler_price }}</td>
                        <td>
                        @can('view', App\ProductDiscount::class)
                            <a href="{{ route('discounts.index', $product->id)}}" class="btn btn-secondary">{{__('navigation.discounts.index')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('view', App\ProductFormat::class)
                        @if($product->is_compounded)
                            <a href="{{ route('formats.index', $product->id)}}" class="btn btn-secondary">{{__('navigation.formats.index')}}</a>
                        @endif
                        @endcan
                        </td>
                        <td>
                        @can('view', App\Product::class)
                            <a href="{{ route('products.show', $product->id)}}" class="btn btn-info">{{__('navigation.show')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('update', App\Product::class)
                            <a href="{{ route('products.edit', $product->id)}}" class="btn btn-primary">{{__('navigation.edit')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('delete', App\Product::class)
                            @if($product->id !== 1)
                                <form action="{{ route('products.destroy', $product->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger delete" data-confirm="{{__('navigation.confirm_deletion')}}" type="submit">{{__('navigation.delete')}}</button>
                                </form>
                            @endif
                        @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $products->links() !!}
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection