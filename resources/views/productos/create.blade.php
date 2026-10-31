@extends('layouts.app')

@section('title', 'Nuevo producto')

@section('content')
<header class="page-heading">
    <div>
        <h1 class="mb-1">Nuevo producto</h1>
        <p class="muted mb-0">Registra un accesorio en el inventario.</p>
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
    <form action="{{ route('productos.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf

        @include('productos._form', ['boton' => 'Guardar producto'])
    </form>
</section>
@endsection