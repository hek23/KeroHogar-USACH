@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mr-3 mb-2">
                <a class="btn btn-success" href="{{ route('prices.create') }}"> {{__('navigation.prices.create')}} </a>
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
                        <td colspan="4">Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderPrices as $orderPrice)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td><a href="{{ route('discounts.index', $orderPrice->id)}}" class="btn btn-info">{{__('navigation.discounts.index')}}</a></td>
                        <td><a href="{{ route('prices.show', $orderPrice->id)}}" class="btn btn-info">{{__('navigation.show')}}</a></td>
                        <td><a href="{{ route('prices.edit', $orderPrice->id)}}" class="btn btn-primary">{{__('navigation.edit')}}</a></td>
                        <td>
                            <form action="{{ route('prices.destroy', $orderPrice->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger delete" data-confirm="{{__('navigation.confirm_deletion')}}" type="submit">{{__('navigation.delete')}}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $orderPrices->links() !!}
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection