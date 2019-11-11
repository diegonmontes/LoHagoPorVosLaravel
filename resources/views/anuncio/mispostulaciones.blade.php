
@extends('layouts.layout')
@section('content')

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link  active" href="#pendiente" role="tab" data-toggle="tab" aria-selected="true">Pendientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#asignadas" role="tab" data-toggle="tab">Valorar y terminar</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#terminadas" role="tab" data-toggle="tab">Anuncios terminados</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#cerradas" role="tab" data-toggle="tab">Cerradas</a>
    </li>
</ul>
      
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="pendiente">

        @if(count($listaTrabajosAspirante)>0)
            <!-- Trabajos aspirantes-->
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
        @else
            <h4> Nada para mostrar. </h4>
        @endif

    </div>
    <div role="tabpanel" class="tab-pane fade" id="asignadas">

        <!-- Trabajos asignados-->
        @if(count($listaTrabajosAsignados)>0)
        <div class="row" style="margin: auto">
            @foreach($listaTrabajosAsignados as $trabajoAsignado)
            @php $trabajo = $trabajoAsignado->Trabajo @endphp
                <div class="card margenCardInicio">
                    <div class="card-body">
                        <h5 class="card-title">{{$trabajo->titulo}}</h5>
                        <p class="card-text">{{$trabajo->descripcion}}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('trabajorealizado',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Valorar y terminar el anuncio</a>
                        <label class="product_price float-right">${{$trabajo->monto}}</label>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <h4> Nada para mostrar. </h4>
        @endif

    </div>
    <div role="tabpanel" class="tab-pane fade" id="terminadas">

        <!-- Trabajos terminados-->
        @if(count($listaTrabajosTerminados)>0)
        <div class="row" style="margin: auto">
            @foreach($listaTrabajosTerminados as $trabajoTerminado)
            @php $trabajo = $trabajoTerminado->Trabajo @endphp
                <div class="card margenCardInicio">
                    <div class="card-body">
                        <h5 class="card-title">{{$trabajo->titulo}}</h5>
                        <p class="card-text">{{$trabajo->descripcion}}</p>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm btn-primary">Esperando que se valore el trabajo realizado</button>
                        <label class="product_price float-right">${{$trabajo->monto}}</label>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <h4> Nada para mostrar. </h4>
        @endif

    </div>
    <div role="tabpanel" class="tab-pane fade" id="cerradas">
        <!-- Trabajos terminados-->
        @if(count($listaTrabajosCerrados)>0)
        <div class="row" style="margin: auto">
            @foreach($listaTrabajosCerrados as $trabajoCerrado)
            @php $trabajo = $trabajoCerrado->Trabajo @endphp
                <div class="card margenCardInicio">
                    <div class="card-body">
                        <h5 class="card-title">{{$trabajo->titulo}}</h5>
                        <p class="card-text">{{$trabajo->descripcion}}</p>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm btn-primary">Anuncio cerrado</button>
                        <label class="product_price float-right">${{$trabajo->monto}}</label>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <h4> Nada para mostrar. </h4>
        @endif

    </div>
</div>


@endsection
