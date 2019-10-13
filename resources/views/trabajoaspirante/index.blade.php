@extends('layouts.layout')
@section('content')
<div class="container align-content-center">
    <div class="row">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">Datos del anuncio</h5>
                </div>
                <h1>{{$trabajo->titulo}}</h1>
                @if(!$trabajo->imagenTrabajo)
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image cap"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Imagen del anuncio</text></svg>
                @endif
                
                <div class="card-body">
                    <p class="card-text">{{$trabajo->descripcion}}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">Datos Personales</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Nombre: {{$persona->nombrePersona}}</p>
                    <p class="card-text">Apellido: {{$persona->apellidoPersona}}</p>
                    <p class="card-text">Documento: {{$persona->dniPersona}}</p>
                    <p class="card-text">Telefono: {{$persona->telefonoPersona}}</p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row col-md-6 offset-md-3">
        <form method="POST" action="{{ route('trabajoaspirantes.store') }}"  role="form">
            {{ csrf_field() }}
            <input type="hidden" value="{{$trabajo->idTrabajo}}" name="idTrabajo">
            <input type="hidden" value="{{$persona->idPersona}}" name="idPersona">
            
            <button type="submit" class="btn btn-primary btn-block">Confirmar y postularme</button>
        </form>
    </div>

</div>

@endsection
