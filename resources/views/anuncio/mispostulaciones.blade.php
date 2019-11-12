
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
                
                <h5 class="card-title">{{ucfirst($trabajo->titulo)}}</h5>
             <hr>
             
             @if($trabajo->imagenTrabajo == null || $trabajo->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajo->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajo->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajo->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajo->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('veranuncio',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajo->monto}}</label>
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
    <div role="tabpanel" class="tab-pane fade" id="asignadas">

        <!-- Trabajos asignados-->
        @if(count($listaTrabajosAsignados)>0)
        <div class="row" style="margin: auto">
                @foreach($listaTrabajosAsignados as $trabajoAspirante)
                @php $trabajo = $trabajoAspirante->Trabajo @endphp
                <div class="card margenCardInicio">
                <div class="card-body">
                
                <h5 class="card-title">{{ucfirst($trabajo->titulo)}}</h5>
             <hr>
             
             @if($trabajo->imagenTrabajo == null || $trabajo->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajo->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajo->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajo->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajo->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            <a href="{{route('trabajorealizado',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Valorar y terminar el anuncio</a>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajo->monto}}</label>
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
    <div role="tabpanel" class="tab-pane fade" id="terminadas">

        <!-- Trabajos terminados-->
        @if(count($listaTrabajosTerminados)>0)
        <div class="row" style="margin: auto">
                @foreach($listaTrabajosTerminados as $trabajoAspirante)
                @php $trabajo = $trabajoAspirante->Trabajo @endphp
                <div class="card margenCardInicio">
                <div class="card-body">
                
                <h5 class="card-title">{{ucfirst($trabajo->titulo)}}</h5>
             <hr>
             
             @if($trabajo->imagenTrabajo == null || $trabajo->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajo->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajo->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajo->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajo->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            <button class="btn btn-sm btn-primary">Esperando que se valore el trabajo realizado</button>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajo->monto}}</label>
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
    <div role="tabpanel" class="tab-pane fade" id="cerradas">
        <!-- Trabajos terminados-->

        @if(count($listaTrabajosCerrados)>0)
        <div class="row" style="margin: auto">
                @foreach($listaTrabajosCerrados as $trabajoAspirante)
                @php $trabajo = $trabajoAspirante->Trabajo @endphp
                <div class="card margenCardInicio">
                <div class="card-body">
                
                <h5 class="card-title">{{ucfirst($trabajo->titulo)}}</h5>
             <hr>
             
             @if($trabajo->imagenTrabajo == null || $trabajo->imagenTrabajo == '')
                @php 
                
                $categoria = $categoriaTrabajo::find($trabajo->idCategoriaTrabajo);
                $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                @endphp
                
                <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

            @else
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajo->imagenTrabajo}}">

            @endif
         
         @php $descripcion = substr($trabajo->descripcion, 0, 100)  @endphp
                <p class="card-text">{{$descripcion}} @if(strlen($trabajo->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            <button class="btn btn-sm btn-primary">Anuncio cerrado</button>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajo->monto}}</label>
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
