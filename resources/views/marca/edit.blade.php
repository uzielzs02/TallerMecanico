@extends('layouts.app')

@section('title','Editar Marca')

@push('css')
<style>
    #descripcion {
        resize: none;
    }

    /* Estilos para la validación del campo de nombre */
    .is-invalid {
        border: 2px solid red;
    }

    .is-valid {
        border: 2px solid green;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Marca</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('marcas.index')}}">Marcas</a></li>
        <li class="breadcrumb-item active">Editar Marca</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('marcas.update',['marca'=>$marca]) }}" method="post" id="marcaForm">
            @method('PATCH')
            @csrf
            <div class="card-body">
                <div class="row g-4">

                    <!---Nombre---->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label"><strong>Nombre:</strong></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre', $marca->caracteristica->nombre)}}" maxlength="60" oninput="validarCampos()">
                        @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                        <small id="nombreErrorVacio" class="text-danger d-none">El nombre no puede estar vacío.</small>
                        <small id="nombreErrorFormato" class="text-danger d-none">El nombre solo debe contener letras y un máximo de 60 caracteres.</small>
                    </div>

                    <!---Descripción---->
                    <div class="col-7">
                        <label for="descripcion" class="form-label"><strong>Descripción:</strong></label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control" maxlength="200" oninput="validarDescripcion(this)">{{old('descripcion', $marca->caracteristica->descripcion)}}</textarea>
                        @error('descripcion')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                        <small id="descripcionError" class="text-danger d-none">La descripción no debe exceder los 200 caracteres.</small>
                    </div>

                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Actualizar</button>
                <button type="reset" class="btn btn-secondary">Reiniciar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    function validarCampos() {
        const nombreInput = document.getElementById("nombre");
        const nombreErrorVacio = document.getElementById("nombreErrorVacio");
        const nombreErrorFormato = document.getElementById("nombreErrorFormato");
        const submitButton = document.getElementById("submitBtn");

        // Expresión regular para solo letras y espacios
        const regexNombre = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;

        let valid = true;

        // Validación del campo "Nombre"
        if (nombreInput.value.trim() === '') {
            nombreErrorVacio.classList.remove("d-none");
            nombreErrorFormato.classList.add("d-none");
            nombreInput.classList.add("is-invalid");
            nombreInput.classList.remove("is-valid");
            valid = false;
        } else if (!regexNombre.test(nombreInput.value) || nombreInput.value.length > 60) {
            nombreErrorVacio.classList.add("d-none");
            nombreErrorFormato.classList.remove("d-none");
            nombreInput.classList.add("is-invalid");
            nombreInput.classList.remove("is-valid");
            valid = false;
        } else {
            nombreErrorVacio.classList.add("d-none");
            nombreErrorFormato.classList.add("d-none");
            nombreInput.classList.remove("is-invalid");
            nombreInput.classList.add("is-valid");
        }

        // Habilitar o deshabilitar el botón de envío
        submitButton.disabled = !valid;
    }

    function validarDescripcion(textarea) {
        const errorMessage = document.getElementById('descripcionError');
        const submitButton = document.getElementById('submitBtn');

        if (textarea.value.length <= 200) {
            errorMessage.classList.add('d-none'); // Ocultar el mensaje de error
        } else {
            errorMessage.classList.remove('d-none'); // Mostrar el mensaje de error
            submitButton.disabled = true; // Deshabilitar el botón de actualizar si la descripción es demasiado larga
        }
    }

    // Validación inicial al cargar la página
    window.onload = function() {
        validarCampos();
        validarDescripcion(document.getElementById('descripcion'));
    }
</script>
@endpush
