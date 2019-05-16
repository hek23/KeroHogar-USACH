@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.schedule.create')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('schedule.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="start">{{ __('navigation.schedule.start') }}:</label>
                            <input class="form-control" type="time" placeholder="13:45:00" name="start" id="start" value="{{old('start')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="end">{{ __('navigation.schedule.end') }}:</label>
                            <input class="form-control" type="time" placeholder="13:45:00" name="end" id="end" value="{{old('end')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="max_orders">{{ __('navigation.schedule.max_orders') }}:</label>
                            <input class="form-control" type="number" placeholder="15" name="max_orders" id="max_orders" value="{{old('max_orders')}}" />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.schedule.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection