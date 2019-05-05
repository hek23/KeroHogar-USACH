@if($message = session()->get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif