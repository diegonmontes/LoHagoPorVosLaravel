
@extends('layouts.layout')
@section('content')

<!-- Anuncios -->

<!-- Trabajos asignados-->
@if(count($listaTrabajosAsignados)>0)
    <h2>Mis postulaciones asignadas</h2>

    <div class="row" style="margin: auto">
        @foreach($listaTrabajosAsignados as $trabajoAsignado)
        @php $trabajo = $trabajoAsignado->Trabajo @endphp
            <div class="card margenCardInicio">
                <div class="card-body">
                    <h5 class="card-title">{{$trabajo->titulo}}</h5>
                    <p class="card-text">{{$trabajo->descripcion}}</p>
                </div>
                <div class="card-footer">
                    <a href="{{route('trabajorealizado',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Termine el trabajo</a>
                    <label class="product_price float-right">${{$trabajo->monto}}</label>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if(count($listaTrabajosAspirante)>0)

    <!-- Trabajos aspirantes-->
    <h2>Mis postulaciones pendientes</h2>

    <div class="row" style="margin: auto">
        @foreach($listaTrabajosAspirante as $trabajoAspirante)
        @php $trabajo = $trabajoAspirante->Trabajo @endphp
            <div class="card margenCardInicio">
                <div class="card-body">
                    <h5 class="card-title">{{$trabajo->titulo}}</h5>
                    <p class="card-text">{{$trabajo->descripcion}}</p>
                </div>
                <div class="card-footer">
                    <a href="{{route('veranuncio',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                    <label class="product_price float-right">${{$trabajo->monto}}</label>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if(count($listaTrabajosAsignados)<1 && count($listaTrabajosAspirante)<1)

    <h2> No tiene postulaciones pendientes y tampoco asignadas. </h2>

@endif

@endsection
