@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__('navigation.schedule.show')}}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('navigation.schedule.start') }}</strong>: {{$timeBlock->start}}</p>
                    <p><strong>{{ __('navigation.schedule.end') }}</strong>: {{$timeBlock->end}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection