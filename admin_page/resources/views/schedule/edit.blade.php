@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.schedule.edit')}}
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form method="post" action="{{ route('schedule.update', $timeBlock->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="start">{{ __('navigation.schedule.start') }}:</label>
                            <input class="form-control" type="time" name="start" id="start" value="{{old('start', $timeBlock->start)}}" required />
                        </div>
                        <div class="form-group">
                            <label for="end">{{ __('navigation.schedule.end') }}:</label>
                            <input class="form-control" type="time" name="end" id="end" value="{{old('end', $timeBlock->end)}}" required />
                        </div>
                        <div class="form-group">
                            <label for="max_orders">{{ __('navigation.schedule.max_orders') }}:</label>
                            <input class="form-control" type="number" name="max_orders" id="max_orders" value="{{old('max_orders', $timeBlock->max_orders)}}" />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.schedule.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection