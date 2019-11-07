
@extends('layouts.layout')




@section('content')
<section class="container h-100">
    <div class="row h-100 justify-content-center ">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">{{$trabajo->titulo}}</h5>
                </div>
                <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}">

                <div class="card-body">
                    <p class="card-text">{{$trabajo->descripcion}}</p>
                </div>

            </div>



            @include('comentario.list', ['comentarios' => $trabajo->Comentarios])            
            @include('comentario.form')
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{$trabajo->titulo}}<label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajo->monto}}</label></li>
                    @if($anuncioExpirado)
                        @if($esMiAnuncio)
                            @if($asignarPersona)

                                @if(!$pagado)
                                    {{-- Decodificamos el link recibido para obtener el smart checkout --}}
                                    <a class='btn btn-success btn-lg' href={{$link}}> Pagar </a>
                                @else
                                
                                    @if($valorarPersona)
                                        <a href="{{route('trabajo.valor',$trabajo->idTrabajo)}}" class="btn btn-lg btn-primary">Valorar el trabajo</a>

                                    @else
                                        @if($trabajoTerminado)
                                        <li class="list-group-item msjVerAnuncio">Anuncio terminado</li>

                                        @else
                                        <li class="list-group-item msjVerAnuncio">Esperando a que se realice el trabajo</li>
                                        @endif
                                    @endif        
                                @endif

                            @else
                                @if($soyElAsignadoPagado)
                                
                                    <a href="{{route('trabajorealizado',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Termine el trabajo</a>

                                @else
                                    @if($esMiAnuncio)


                                    <a class='btn btn-lg btn-primary' href="{{route('anuncio.postulante',$trabajo->idTrabajo)}}" > Elegir un postulante </a>


                                    @else
                                        @if($mostrarBotonPostularse)
                                        <li class="list-group-item msjVerAnuncio"> Trabajo expirado</li>


                                        @else
                                        <li class="list-group-item msjVerAnuncio">Esperando que se asigne una persona</li>

                                        @endif
                                        
                                    @endif
                                @endif

                            @endif
                        @else

                            @if($soyElAsignadoPagado)
                                @if($valorarPersona)
                                <li class="list-group-item msjVerAnuncio">Trabajo terminado. Esperando valoracion</li>

                                @else
                                @if($trabajoTerminado)
                                <li class="list-group-item msjVerAnuncio">Anuncio terminado</li>

                                @else
                                    <a href="{{route('trabajorealizado',$trabajo->idTrabajo)}}" class="btn btn-lg btn-primary">Termine el trabajo</a>
                                @endif
                                @endif
                            @else
                                <li class="list-group-item msjVerAnuncio"> Esperando a que se eliga un postulante</li>
                            @endif
           
                        @endif
                    @else
                        {{-- Si ya se postulo no mostramos boton postularse --}}
                        @if($esMiAnuncio)

                            @if($pagado)
                                {{-- Decodificamos el link recibido para obtener el smart checkout --}}
                                <li class="list-group-item msjVerAnuncio">Esperando a que se realice el trabajo</li>

                            @else

                                <li class="list-group-item msjVerAnuncio">Todavia se reciben postulantes en este anuncio</li>
                            
                            @endif


                        @else
                            @if($mostrarBotonPostularse)
                                <a href="{{route ('postularme',$trabajo->idTrabajo)}}" class="btn btn-success">Postularme</a>
                            @else
                                <li class="list-group-item msjVerAnuncio">Ya estoy postulado</li>
                            @endif
                        @endif
                    @endif   
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="margin: auto;">
        <div class="carousel-inner">
            @php $cant = 0 @endphp
            <div class="carousel-item active">
                <div class="row">
                    @foreach($listaTrabajo as $trabajo)
                        @if($cant<4)
                            <div class="card" style="width: 18rem; margin-left: 1%; margin-right: 1%; margin-top: 1%;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$trabajo->titulo}}</h5>
                                    <p class="card-text">{{$trabajo->descripcion}}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{route ('veranuncio',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                                    <label class="product_price float-right">${{$trabajo->monto}}</label>
                                </div>
                            </div>
                        @endif
                        @php $cant = $cant + 1 @endphp
                    @endforeach

                </div>
            </div>
            @php $cant = 4 @endphp
            <div class="carousel-item">
                    <div class="row">
                        @foreach($listaTrabajo as $trabajo)
                            @if($cant>4 && $cant<8)
                                <div class="card" style="width: 18rem; margin-left: 1%; margin-right: 1%; margin-top: 1%;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$trabajo->titulo}}</h5>
                                        <p class="card-text">{{$trabajo->descripcion}}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{route ('veranuncio',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                                        <label class="product_price float-right">${{$trabajo->monto}}</label>
                                    </div>
                                </div>
                            @endif
                            @php $cant = $cant + 1 @endphp
                        @endforeach
    
                    </div>
                </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

</div> --}}

@endsection
