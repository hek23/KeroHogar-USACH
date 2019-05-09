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
                            <input class="form-control" type="time" placeholder="13:45:00" name="start" id="start" value="{{old('start')}}" />
                        </div>
                        <div class="form-group">
                            <label for="end">{{ __('navigation.schedule.end') }}:</label>
                            <input class="form-control" type="time" placeholder="13:45:00" name="end" id="end" value="{{old('end')}}" />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.schedule.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection