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
                            <label for="product" class="col-sm-3 col-form-label">{{ __('navigation.orders.product') }}*</label>
                            <div class="col-sm-9">
                                <select class="custom-select form-control" name="product" id="product" >
                                    @foreach($products as $id => $name)
                                        <option value="{{$id}}" @if(old('product')==$id) {{'selected'}} @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @csrf
                        <div class="formatDiv">
                        </div>
                        <div class="form-group row">
                            <label for="quantity" class="col-sm-3 col-form-label">{{ __('navigation.orders.quantity') }}*</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="quantity" id="quantity" value="{{old('quantity')}}" placeholder="5 (el monto será calculado de acuerdo a este número)" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="delivery_status" class="col-sm-3 col-form-label">{{ __('navigation.orders.delivery_status') }}*</label>
                            <div class="col-sm-9">
                                <select class="custom-select form-control" name="delivery_status" id="delivery_status" >
                                    @foreach($deliveryStatuses as $id => $name)
                                        <option value="{{$id}}" @if(old('delivery_status')==$id) {{'selected'}} @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payment_status" class="col-sm-3 col-form-label">{{ __('navigation.orders.payment_status') }}*</label>
                            <div class="col-sm-9">
                                <select class="custom-select form-control" name="payment_status" id="payment_status" >
                                    @foreach($paymentStatuses as $id => $name)
                                        <option value="{{$id}}" @if(old('payment_status')==$id) {{'selected'}} @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="delivery_date" class="col-sm-3 col-form-label">{{ __('navigation.orders.delivery_date') }}*</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="date" name="delivery_date" id="delivery_date" value="{{old('delivery_date')}}" required />
                            </div>
                        </div>
                        <div class="form-group available_blocks">
                            <label for="delivery_time">{{ __('navigation.orders.delivery_time') }}*</label>
                            <select multiple class="custom-select form-control" name="delivery_time[]" id="delivery_time" >
                                @foreach($timeBlocks as $timeBlock)
                                    <option value="{{$timeBlock->id}}" @foreach(old('delivery_time', []) as $dtId) @if($dtId==$timeBlock->id) {{'selected'}} @endif @endforeach>{{$timeBlock->format()}}</option>
                                @endforeach
                            </select>
                        </div>
                        <p>Detalles del cliente:</p>
                        <div class="form-group row">
                            <label for="rut" class="col-sm-2 col-form-label">{{ __('navigation.orders.rut') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="rut" id="rut" value="{{old('rut')}}" placeholder="12345678-9"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">{{ __('navigation.orders.name') }}*</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}" placeholder="Juan López" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">{{ __('navigation.orders.phone') }}</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="phone" id="phone" value="{{old('phone')}}" placeholder="+56 955580004" />
                            </div>
                            <label for="email" class="col-sm-2 col-form-label">{{ __('navigation.orders.email') }}</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="email" id="email" value="{{old('email')}}" placeholder="cliente@gmail.com" />
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="town" class="col-sm-2 col-form-label">{{ __('navigation.orders.town') }}*</label>
                            <div class="col-sm-3">
                                <select class="custom-select form-control" name="town" id="town" >
                                    @foreach($towns as $id => $name)
                                        <option value="{{$id}}" @if(old('town')==$id) {{'selected'}} @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="address" class="col-sm-2 col-form-label">{{ __('navigation.orders.address') }}*</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="address" id="address" value="{{old('address')}}" placeholder="San Juan 5286" required />
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="wholesaler" value=0 />
                            <input type="checkbox" class="form-check-input" name="wholesaler" id="wholesaler" value=1 />
                            <label for="wholesaler">{{ __('navigation.orders.wholesaler') }}</label>
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('navigation.orders.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>

$(document).ready(function() {
        
    function loadFormats(product) {
                
        var old_product = {{ old('product') ? old('product') : 0 }};
        var old_format = {{ old('format') ? old('format') : 0 }};

        $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })

        $.ajax({ 
            type: 'POST',
            url: '{{ route("orders.formats") }}',
            data: { id: product },
            success: function(data) {
                var isEmpty = (data || []).length === 0;
                if(isEmpty) {
                    $('.formatDiv').removeClass('form-group row');
                    $('.formatDiv').html('');
                } else {
                    $('.formatDiv').addClass('form-group row');
                    $('.formatDiv').html('<label for="format" class="col-sm-3 col-form-label">' + "{{ __('navigation.orders.format') }}" + '*</label>\n' +
                                        '<div class="col-sm-9">\n' +
                                        '<select class="custom-select form-control" name="format" id="format">\n' +
                                        '</select>\n' +
                                        '</div>\n');
                    
                    var options ="<option value=''";
                
                    if(old_product == product) {
                        if(!old_format) {
                            options += " selected";
                        }
                    }
                            
                    options += ">Escoge el formato de venta</option>";
                    
                    $.each(data, function(key, value) {
                        options += "<option value='" + key + "'>" + value + "</option>";
                    });
                    
                    $('select[name="format"]').html(options);
                            
                    if(old_product == product) {
                        if(old_format) {
                            $('select[name="format"]').val(old_format);
                        }
                    }
                }
            }
        });
    }

    function loadAvailableBlocks(date) {
                
        var old_date = {{ old('delivery_date') ? old('delivery_date') : 0 }};
        var old_blocks = [];
        @foreach(old('delivery_time', []) as $dt)
            old_blocks.push({{$dt}});
        @endforeach

        $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })

        $.ajax({ 
            type: 'POST',
            url: '{{ route("orders.available_blocks") }}',
            data: { delivery_date: date },
            success: function(data) {
                var isEmpty = (data || []).length === 0;
                if(isEmpty) {
                    var options = "<option value='0' disabled>No hay bloques disponibles para este día</option>";
                    document.getElementById('delivery_time').size = 1;
                    $('#delivery_time').html(options);
                } else {
                    var options = '';
                    $.each(data, function(key, value) {
                        options += "<option value='" + value.id + "'>" + value.start + ' - ' + value.end + "</option>";
                    });
                    
                    $('select[name="delivery_time[]"]').html(options);
                    document.getElementById('delivery_time').size = (data.length !== undefined) ? data.length : 1;
                            
                    if(old_date == date) {
                        if(old_blocks) {
                            $('select[name="delivery_time[]"]').val(old_blocks);
                        }
                    }
                }
            }
        });
    }

    $("#product").change(function() {
        var product = $(this).val();
        loadFormats(product);
    });

    $("#delivery_date").change(function() {
        var date = $(this).val();
        loadAvailableBlocks(date);
    });

    var product = $('select[name="product"]').val();
    loadFormats(product);
            
});
</script>
@endsection