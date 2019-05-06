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
                            <label for="name">{{ __('navigation.schedule.start') }}</label>
                            <input type="text" class="form-control" name="name" value="{{$timeBlock->start}}" />
                        </div>
                        <div class="form-group">
                            <label for="price">{{ __('navigation.schedule.end') }}</label>
                            <input type="text" class="form-control" name="price" value="{{$timeBlock->end}}" />
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('navigation.schedule.store')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection