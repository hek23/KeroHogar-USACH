@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mr-3 mb-2">
                <a class="btn btn-success" href="{{ route('products.create') }}"> {{__('navigation.products.create')}} </a>
            </div>
        </div>
    </div>
    @include('partials.session_success')
    <div class="row px-3">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>N°</td>
                        <td>Producto</td>
                        <td>Precio</td>
                        <td>Unidad</td>
                        <td colspan="4" width=25%>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ '$' . $product->price }}</td>
                        <td>{{ $product->unit }}</td>
                        <td><a href="{{ route('discounts.index', $product->id)}}" class="btn btn-info">{{__('navigation.discounts.index')}}</a></td>
                        <td><a href="{{ route('products.show', $product->id)}}" class="btn btn-info">{{__('navigation.show')}}</a></td>
                        <td><a href="{{ route('products.edit', $product->id)}}" class="btn btn-primary">{{__('navigation.edit')}}</a></td>
                        <td>
                            <form action="{{ route('products.destroy', $product->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger delete" data-confirm="{{__('navigation.confirm_deletion')}}" type="submit">{{__('navigation.delete')}}</button>
                            </form>
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

@section('script')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection