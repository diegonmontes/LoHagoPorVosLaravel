
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
        <a class="nav-link" href="#esperar" role="tab" data-toggle="tab">Esperando que se realice</a>
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
                
                <h5 class="card-title">{{ucfirst($trabajoPendiente->titulo)}}</h5>
             <hr>
             
             @if($trabajoPendiente->imagenTrabajo == null || $trabajoPendiente->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajoPendiente->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajoPendiente->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajoPendiente->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajoPendiente->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('veranuncio',$trabajoPendiente->idTrabajo)}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajoPendiente->monto}}</label>
                            </div>
                        </div>
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
                
                <h5 class="card-title">{{ucfirst($trabajoAsignar->titulo)}}</h5>
             <hr>
             
             @if($trabajoAsignar->imagenTrabajo == null || $trabajoAsignar->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajoAsignar->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajoAsignar->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajoAsignar->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajoAsignar->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            <a class='btn btn-sm btn-primary' href="{{route('anuncio.postulante',$trabajoAsignar->idTrabajo)}}" > Elegir un postulante </a>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajoAsignar->monto}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <h4> Nada para mostrar. </h4>
        @endif

    </div>

    <div role="tabpanel" class="tab-pane" id="esperar">

        @if(count($listaTrabajosEsperar)>0)
        <div class="row" style="margin: auto">
            @foreach($listaTrabajosEsperar as $trabajoEsperar)
                <div class="card margenCardInicio">
                <div class="card-body">
                
                <h5 class="card-title">{{ucfirst($trabajoEsperar->titulo)}}</h5>
             <hr>
             
             @if($trabajoEsperar->imagenTrabajo == null || $trabajoEsperar->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajoEsperar->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajoEsperar->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajoEsperar->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajoEsperar->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            <a href="{{route('veranuncio',$trabajoEsperar->idTrabajo)}}" class="btn btn-sm btn-primary">Ver el anuncio</a>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajoEsperar->monto}}</label>
                            </div>
                        </div>
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
        <div class="row" style="margin: auto">
            @foreach($listaTrabajosTerminados as $trabajoTerminado)
                <div class="card margenCardInicio">
                <div class="card-body">
                
                <h5 class="card-title">{{ucfirst($trabajoTerminado->titulo)}}</h5>
             <hr>
             
             @if($trabajoTerminado->imagenTrabajo == null || $trabajoTerminado->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajoTerminado->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajoTerminado->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajoTerminado->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajoTerminado->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            <a href="{{route('trabajo.valor',$trabajoTerminado->idTrabajo)}}" class="btn btn-sm btn-primary">Valorar el trabajo</a>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajoTerminado->monto}}</label>
                            </div>
                        </div>
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
        <div class="row" style="margin: auto">
            @foreach($listaTrabajosCerradas as $trabajoCerrado)
                <div class="card margenCardInicio">
                <div class="card-body">
                
                <h5 class="card-title">{{ucfirst($trabajoCerrado->titulo)}}</h5>
             <hr>
             
             @if($trabajoCerrado->imagenTrabajo == null || $trabajoCerrado->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajoCerrado->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajoCerrado->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajoCerrado->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajoCerrado->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            <li class="list-group-item msjVerAnuncio">Anuncio terminado</li>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajoCerrado->monto}}</label>
                            </div>
                        </div>
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










