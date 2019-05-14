@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.orders.create')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('orders.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="product" class="col-sm-3 col-form-label">{{ __('navigation.orders.product') }}</label>
                            <div class="col-sm-9">
                                <select class="custom-select form-control" name="product" id="product" >
                                    @foreach($products as $id => $name)
                                        <option value="{{$id}}" @if(old('product')==$id) {{'selected'}} @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="quantity" class="col-sm-3 col-form-label">{{ __('navigation.orders.quantity') }}</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="quantity" id="quantity" value="{{old('quantity')}}" placeholder="5 (el monto será calculado de acuerdo a este número)" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="delivery_status" class="col-sm-3 col-form-label">{{ __('navigation.orders.delivery_status') }}</label>
                            <div class="col-sm-9">
                                <select class="custom-select form-control" name="delivery_status" id="delivery_status" >
                                    @foreach($deliveryStatuses as $id => $name)
                                        <option value="{{$id}}" @if(old('delivery_status')==$id) {{'selected'}} @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payment_status" class="col-sm-3 col-form-label">{{ __('navigation.orders.payment_status') }}</label>
                            <div class="col-sm-9">
                                <select class="custom-select form-control" name="payment_status" id="payment_status" >
                                    @foreach($paymentStatuses as $id => $name)
                                        <option value="{{$id}}" @if(old('payment_status')==$id) {{'selected'}} @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="delivery_date" class="col-sm-3 col-form-label">{{ __('navigation.orders.delivery_date') }}</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="date" name="delivery_date" id="delivery_date" value="{{old('delivery_date')}}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="delivery_time">{{ __('navigation.orders.delivery_time') }}</label>
                            <select multiple class="custom-select form-control" name="delivery_time[]" id="delivery_time" >
                                    @foreach($timeBlocks as $timeBlock)
                                        <option value="{{$timeBlock->id}}" @foreach(old('delivery_time', []) as $dtId) @if($dtId==$timeBlock->id) {{'selected'}} @endif @endforeach>{{$timeBlock->format()}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group row">
                            <label for="rut" class="col-sm-3 col-form-label">{{ __('navigation.orders.rut') }}</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="rut" id="rut" value="{{old('rut')}}" placeholder="12345678-9"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{ __('navigation.orders.name') }}</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}" placeholder="Juan López"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="town" class="col-sm-2 col-form-label">{{ __('navigation.orders.town') }}</label>
                            <div class="col-sm-3">
                                <select class="custom-select form-control" name="town" id="town" >
                                    @foreach($towns as $id => $name)
                                        <option value="{{$id}}" @if(old('town')==$id) {{'selected'}} @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="address" class="col-sm-2 col-form-label">{{ __('navigation.orders.address') }}</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="address" id="address" value="{{old('address')}}" placeholder="San Juan 5286" />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('navigation.orders.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection