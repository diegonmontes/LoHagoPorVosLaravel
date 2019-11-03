
@extends('layouts.layout')
@section('content')

@if(count($listaTrabajosTerminados)>0)
<!-- Anuncios activos -->
<h2>Mis anuncios esperando confirmacion de finalizacion</h2>
<div class="row" style="margin: auto">
    @foreach($listaTrabajosTerminados as $trabajo)
        <div class="card margenCardInicio">
            <div class="card-body">
                <h5 class="card-title">{{$trabajo->titulo}}</h5>
                <p class="card-text">{{$trabajo->descripcion}}</p>
            </div>
            <div class="card-footer">
                <a href="{{route('trabajo.valor',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Valorar el trabajo</a>
                <label class="product_price float-right">${{$trabajo->monto}}</label>
            </div>
        </div>
    @endforeach
</div>
@endif


@if(count($listaTrabajos)>0)
<!-- Anuncios activos -->
<h2>Mis anuncios activos</h2>
<div class="row" style="margin: auto">
    @foreach($listaTrabajos as $trabajo)
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

@endsection
