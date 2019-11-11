
@extends('layouts.layout')
@section('content')


<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link  active" href="#pendiente" role="tab" data-toggle="tab" aria-selected="true">Esperando postulantes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#asignar" role="tab" data-toggle="tab">Asignar un postulante y pagar</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#terminadas" role="tab" data-toggle="tab">Valorar y terminar</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#cerradas" role="tab" data-toggle="tab">Cerradas</a>
    </li>
</ul>
          
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="pendiente">

        @if(count($listaTrabajos)>0)
        <!-- Anuncios activos -->
        <div class="row" style="margin: auto">
            @foreach($listaTrabajos as $trabajoPendiente)
                <div class="card margenCardInicio">
                    <div class="card-body">
                        <h5 class="card-title">{{$trabajoPendiente->titulo}}</h5>
                        <p class="card-text">{{$trabajoPendiente->descripcion}}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('veranuncio',$trabajoPendiente->idTrabajo)}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                        <label class="product_price float-right">${{$trabajoPendiente->monto}}</label>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <h4> Nada para mostrar. </h4>
        @endif
    </div>

    <div role="tabpanel" class="tab-pane" id="asignar">

        @if(count($listaTrabajosEvaluar)>0)
            <div class="row" style="margin: auto">
                @foreach($listaTrabajosEvaluar as $trabajoAsignar)
                    <div class="card margenCardInicio">
                        <div class="card-body">
                            <h5 class="card-title">{{$trabajoAsignar->titulo}}</h5>
                            <p class="card-text">{{$trabajoAsignar->descripcion}}</p>
                        </div>
                        <div class="card-footer">
                            <a class='btn btn-sm btn-primary' href="{{route('anuncio.postulante',$trabajoAsignar->idTrabajo)}}" > Elegir un postulante </a>
                            <label class="product_price float-right">${{$trabajoAsignar->monto}}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h4> Nada para mostrar. </h4>
        @endif

    </div>

    <div role="tabpanel" class="tab-pane" id="terminadas">

        @if(count($listaTrabajosTerminados)>0)
            <!-- Anuncios activos -->
            <div class="row" style="margin: auto">
                @foreach($listaTrabajosTerminados as $trabajoTerminado)
                    <div class="card margenCardInicio">
                        <div class="card-body">
                            <h5 class="card-title">{{$trabajoTerminado->titulo}}</h5>
                            <p class="card-text">{{$trabajoTerminado->descripcion}}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('trabajo.valor',$trabajoTerminado->idTrabajo)}}" class="btn btn-sm btn-primary">Valorar el trabajo</a>
                            <label class="product_price float-right">${{$trabajoTerminado->monto}}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h4> Nada para mostrar. </h4>
        @endif

    </div>

    <div role="tabpanel" class="tab-pane" id="cerradas">
            
        @if(count($listaTrabajosCerradas)>0)
            <!-- Anuncios cerrados -->
            <div class="row" style="margin: auto">
                @foreach($listaTrabajosCerradas as $trabajoCerrado)
                <div class="card margenCardInicio">
                    <div class="card-body">
                        <h5 class="card-title">{{$trabajoCerrado->titulo}}</h5>
                        <p class="card-text">{{$trabajoCerrado->descripcion}}</p>
                    </div>
                    <div class="card-footer">
                            <li class="list-group-item msjVerAnuncio">Anuncio terminado</li>
                            <label class="product_price float-right">${{$trabajoCerrado->monto}}</label>
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










