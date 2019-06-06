@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.orders.show')}}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('navigation.orders.product') }}</strong>: <a href="{{route('products.show', $order->product->id)}}">{{$order->product->name}}</a></p>
                    @if(!is_null($order->format))<p><strong>{{ __('navigation.orders.format') }}</strong>: <a href="{{ route('formats.show', [$order->product->id, $order->format->id])}}">{{$order->format->name}}</a></p>@endif
                    <p><strong>{{ __('navigation.orders.amount') }}</strong>: {{$order->amount}}</p>
                    <p><strong>{{ __('navigation.orders.quantity') }}</strong>: {{$order->product->pivot->quantity}}</p>
                    <p><strong>{{ __('navigation.orders.delivery_status') }}</strong>: {{$order->deliveryStatusFormat()}}</p>
                    <p><strong>{{ __('navigation.orders.payment_status') }}</strong>: {{$order->paymentStatusFormat()}}</p>
                    <p><strong>{{ __('navigation.orders.delivery_date') }}</strong>: {{$order->delivery_date}}</p>
                    <p><strong>{{ __('navigation.orders.delivery_time') }}</strong>:</p>
                    <p>
                        @foreach ($order->delivery_blocks as $timeBlock)
                            {{ $timeBlock->start . " - " . $timeBlock->end }}<br>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Detalles del cliente
                </div>
                <div class="card-body">
                    <p><strong>{{ __('navigation.orders.rut') }}</strong>: {{$order->client->rutFormat()}}</a></p>
                    <p><strong>{{ __('navigation.orders.name') }}</strong>: {{$order->client->name}}</a></p>
                    <p><strong>{{ __('navigation.orders.email') }}</strong>: {{$order->client->email}}</a></p>
                    <p><strong>{{ __('navigation.orders.phone') }}</strong>: {{$order->client->phone}}</a></p>
                    <p><strong>{{ __('navigation.orders.wholesaler') }}</strong>: {{$order->client->wholesaler == 1 ? 'Si' : 'No'}}</a></p>
                    <p><strong>{{ __('navigation.orders.alias') }}</strong>: {{$order->address->alias}}</p>
                    <p><strong>{{ __('navigation.orders.town') }}</strong>: {{$order->address->town->name}}</p>
                    <p><strong>{{ __('navigation.orders.address') }}</strong>: {{$order->address->address}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection