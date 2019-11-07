@extends('layouts.layout')
@section('content')
<div class="container align-content-center">
    <div class="row">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">Datos del anuncio que me estoy postulando</h5>
                </div>
                <h1>{{$trabajo->titulo}}</h1>
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}">

                
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                    <p class="card-text">{{$trabajo->descripcion}}</p>
                            </li>
                    <li class="list-group-item">
                    <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajo->monto}}</label>
                    </li>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">Mis datos</h5>
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
        <form method="POST" action="{{ route('trabajoaspirante.store') }}"  role="form">
            {{ csrf_field() }}
            <input type="hidden" value="{{$trabajo->idTrabajo}}" name="idTrabajo">
            <input type="hidden" value="{{$persona->idPersona}}" name="idPersona">
            <button type="submit" class="btn btn-primary btn-block">Confirmar y postularme</button>
        </form>
    </div>

</div>

@endsection
