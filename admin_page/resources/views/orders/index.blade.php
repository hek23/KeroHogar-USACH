@extends('layouts.app')

@section('style')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="float-left">
                @include('partials.errors')
                <form action="{{ route('orders.index') }}">
                    <div class="form-inline mb-2 ml-3">
                        <div class="form-group" style="flex-flow:column;">
                            <label for="client_type">Tipo de cliente:</label>
                            <select class="custom-select form-control mx-2" name="client_type" id="client_type">
                                <option value="0">{{ __('navigation.default_option') }}</option>
                                @foreach($clientTypes as $id => $name)
                                    <option value="{{$id}}" @if($client_type == $id) {{'selected'}} @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="time_interval_start">Comienzo de intervalo:</label>
                            <input type="date" class="form-control mx-2" name="time_interval_start" id="time_interval_start" value="{{$time_interval_start}}" style="max-width:165px;" />
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="time_interval_end">Fin de intervalo:</label>
                            <input type="date" class="form-control mx-2" name="time_interval_end" id="time_interval_end" value="{{$time_interval_end}}" style="max-width:165px;" />
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="time_block_id">Bloque:</label>
                            <select class="custom-select form-control mx-2" name="time_block_id" id="time_block_id" >
                                <option value="0">{{ __('navigation.default_option') }}</option>
                                @foreach($timeBlocks as $timeBlock)
                                    <option value="{{$timeBlock->id}}" @if($time_block_id == $timeBlock->id) {{'selected'}} @endif>{{$timeBlock->format()}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="town_id">Comuna:</label>
                            <select class="custom-select form-control mx-2" name="town_id" id="town_id" >
                                <option value="0">{{ __('navigation.default_option') }}</option>
                                @foreach($towns as $id => $name)
                                    <option value="{{$id}}" @if($town_id == $id) {{'selected'}} @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="delivery_status">Estado Entrega:</label>
                            <select class="custom-select form-control mx-2" name="delivery_status" id="delivery_status" >
                                <option value="0">{{ __('navigation.default_option') }}</option>
                                @foreach($deliveryStatuses as $id => $name)
                                    <option value="{{$id}}" @if($delivery_status == $id) {{'selected'}} @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex-flow:column;">
                            <label for="payment_status">Estado Pago:</label>
                            <select class="custom-select form-control mx-2" name="payment_status" id="payment_status" >
                                <option value="0">{{ __('navigation.default_option') }}</option>
                                @foreach($paymentStatuses as $id => $name)
                                    <option value="{{$id}}" @if($payment_status == $id) {{'selected'}} @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mx-2">Filtrar</button>
                        <button type="submit" class="btn btn-success ml-2" name="generate_excel" value='1'>Generar Excel</button>
                    </div>
                </form>
            </div>
            @can('create', App\Order::class)
            <div class="float-right mr-3 mt-2">
                <a class="btn btn-success" href="{{ route('orders.create') }}"> {{__('navigation.orders.create')}} </a>
            </div>
            @endcan
        </div>
    </div>
    @include('partials.session_success')
    <div class="row px-3">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>N°</td>
                        <td width="8%">Cliente</td>
                        <td>Comuna</td>
                        <td>Pedido</td>
                        <td>E. Entrega</td>
                        <td>E. Pago</td>
                        <td>Monto</td>
                        <td>Día entrega</td>
                        <td>Horario entrega</td>
                        <td colspan="1">Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ ++$rowItem }}</td>
                        <td>{{ $order->client->name }}</td>
                        <td>{{ $order->address->town->name }}</td>
                        <td>{{ $order->productNameFormat() }}</td>
                        <td>
                            @if($order->delivery_status == App\Order::PENDING_DELIVERY)
                                <i class="fas fa-truck" style="font-size:24px;color:red"></i>
                            @else
                                <i class="fas fa-truck" style="font-size:24px;color:green"></i>
                            @endif
                        </td>
                        <td>
                            @if($order->payment_status == App\Order::PENDING_PAYMENT)
                                <i class="fas fa-wallet" style="font-size:24px;color:red"></i>
                            @else
                                <i class="fas fa-wallet" style="font-size:24px;color:green"></i>
                            @endif
                        </td>
                        <td>{{ $order->amount }}</td>
                        <td>{{ $order->delivery_date }}</td>
                        <td>
                            @foreach ($order->delivery_blocks as $timeBlock)
                                {{ $timeBlock->start . " - " . $timeBlock->end }}<br>
                            @endforeach
                        </td>
                        <td class="dropdown">
                            <a id="actionDropdown{{$rowItem}}" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                Acciones <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown{{$rowItem}}">
                                @can('view', App\Order::class)
                                <a href="{{ route('orders.show', $order->id)}}" class="dropdown-item" style="color:#6cb2eb;">{{__('navigation.show')}}</a>
                                @endcan
                                @can('deliver', App\Order::class)
                                @if($order->delivery_status !== App\Order::DELIVERED)
                                <form action="{{ route('orders.delivered', $order->id)}}" method="post">
                                    @csrf
                                    <button class="dropdown-item delete" style="color:#3490dc;" data-confirm="{{__('navigation.confirm_delivered')}}"
                                        type="submit">{{__('navigation.delivered')}}</button>
                                </form>
                                @endif
                                @endcan
                                @can('payment', App\Order::class)
                                @if($order->payment_status !== App\Order::PAID)
                                <form action="{{ route('orders.paid', $order->id)}}" method="post">
                                    @csrf
                                    <button class="dropdown-item delete" style="color:#3490dc;" data-confirm="{{__('navigation.confirm_paid')}}"
                                        type="submit">{{__('navigation.paid')}}</button>
                                </form>
                                @endif
                                @endcan
                                @can('delete', App\Order::class)
                                <form action="{{ route('orders.destroy', $order->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item delete" style="color:red;" data-confirm="{{__('navigation.confirm_deletion')}}"
                                        type="submit">{{__('navigation.delete')}}</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($orders->count() === 0)
            <p>{{__('navigation.orders.empty')}}</p>
            @endif

            {!! $orders->appends([
                'client_type' => $client_type,
                'time_interval_start' => $time_interval_start,
                'time_interval_end' => $time_interval_end,
                'town_id' => $town_id,
                'time_block_id' => $time_block_id,
                'delivery_status' => $delivery_status,
                'payment_status' => $payment_status,
            ])->links() !!}
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/confirm_deletion.js') }}" defer></script>
@endsection