@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
<header class="page-heading">
    <div>
        <h1 class="mb-1">Editar producto</h1>
        <p class="muted mb-0">
            Modifica los datos de {{ $producto->nombre }}.
        </p>
    </div>
</header>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Revisa los siguientes errores:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="panel">
    <form action="{{ route('productos.update', $producto) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('productos._form', ['boton' => 'Actualizar producto'])
    </form>
</section>
@endsection