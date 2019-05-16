@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    @can('create', App\ProductDiscount::class)
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mr-3 mb-2">
                <a class="btn btn-success" href="{{ route('discounts.create', $product->id) }}"> {{__('navigation.discounts.create')}} </a>
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
                        <td>Descuento por litro</td>
                        <td>Cantidad mínima</td>
                        <td>Cantidad máxima</td>
                        <td colspan="3">Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productDiscounts as $productDiscount)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td>{{ $productDiscount->formatDiscount() }}</td>
                        <td>{{ $productDiscount->formatMinQuantity() }}</td>
                        <td>{{ $productDiscount->formatMaxQuantity() }}</td>
                        <td>
                        @can('view', App\ProductDiscount::class)
                            <a href="{{ route('discounts.show', [$product->id, $productDiscount->id]) }}" class="btn btn-info">{{__('navigation.show')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('update', App\ProductDiscount::class)
                            <a href="{{ route('discounts.edit', [$product->id, $productDiscount->id]) }}" class="btn btn-primary">{{__('navigation.edit')}}</a>
                        @endcan
                        </td>
                        <td>
                        @can('delete', App\ProductDiscount::class)
                            <form action="{{ route('discounts.destroy', [$product->id, $productDiscount->id]) }}" method="post">
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

            {!! $productDiscounts->links() !!}
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection