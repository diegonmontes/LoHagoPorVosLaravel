
@extends('layouts.layout')
@section('content')
<section class="container h-100">
    <div class="row h-100 justify-content-center ">
        <h1>aca va un formulario para que complete antes de finalizar el trabajo</h1>

        <form method="POST" id="formTerminado" name="formTerminado" action="{{ route('trabajo.terminado') }}"  role="form">
            {{ csrf_field() }}
            <div class="row">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="nombreRol" id="nombreRol" class="form-control input-sm">
                    </div>
                </div>
            <div class="row">
                <div class="form-group">
                    <label>Descripcion:</label>
                    <input type="text" name="descripcionRol" id="descripcionRol" class="form-control input-sm">
                </div>
            </div>
        <input type="hidden" name="idTrabajo" id="idTrabajo" value="{{$idTrabajo}}">

            <br>
            <div class="row">
                    <input type="submit"  value="Enviar y finalizar el trabajo" class="btn btn-success btn-block">
            </div>
        </form>
    </div>
</section>

@endsection
