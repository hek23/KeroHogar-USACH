@if ($errors->any())
    <div class="alert alert-danger">
        Hubo algunos problemas con los datos que ingresaste. Por favor revísalos:<br><br>
        <ul class="mb-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif