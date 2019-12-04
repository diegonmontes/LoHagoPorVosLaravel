
@extends('layouts.layout')




@section('content')

<section class="container h-100">
    <div class="row h-100 justify-content-center ">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">{{$trabajo->titulo}}</h5>
                </div>

                @if($trabajo->imagenTrabajo == null || $trabajo->imagenTrabajo == '')
                    @php $imagen = $trabajo->CategoriaTrabajo['imagenCategoriaTrabajo']; $nombreImagen = $trabajo->CategoriaTrabajo['nombreCategoriaTrabajo'] @endphp

                    <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagen" )}}" alt="{{$nombreImagen}}">

                @else
                    <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajo->imagenTrabajo}}">

                @endif

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
                                       
                                        {{-- <a href="{{route('chatanuncio',$trabajo->idTrabajo)}}" class="btn btn-lg btn-primary">Ver chat</a> --}}
                                        <form action="{{url('chat')}}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="idTrabajo" value="{{$trabajo->idTrabajo}}"/>
                                            <input type="submit">
                                        </form>
                                        @endif

                                        @if($puedeCancelar)
                                        <li class="list-group-item"><a href="{{route('trabajo.cancelartrabajo',$trabajo->idTrabajo)}}"> <button type="button" class="btn btn-danger cancelarAnuncio">Cancelar el anuncio</button> </a></li>
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
                                    <form action="{{url('chat')}}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="idTrabajo" value="{{$trabajo->idTrabajo}}"/>
                                        <input type="submit">
                                    </form>
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
                                <li class="list-group-item">Usuarios que se postularon</li>
                                @foreach($listaAspirantes as $aspirante)
                                    @php $usuario = $aspirante->Persona->Usuario @endphp
                                    @php $fotoPerfil = $aspirante->Persona->imagenPerfil @endphp
                                    <li class="list-group-item listaPostulantes"><label class="listaPostulantesNombre">{{$usuario->nombreUsuario}}</label>
                                        <label class="listaPostulantesValoracion">
                                            @for($i=0;$i<$aspirante->valoracion;$i++)
                                                <span class="fa fa-star icon"></span>
                                            @endfor
                                        </label>
                                        <img  class="imagenListaPostulante" src="
                                            @if($fotoPerfil != null)
                                                {{ asset('storage/perfiles/'.$fotoPerfil)}}
                                            @else{{asset('images/fotoPerfil.png')}}
                                        @endif">
                                    </li>


                                @endforeach
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

<div id="respuestaComentario" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Error al subir el comentario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="msjError"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script type="text/javascript">


$(document).ready(function (e){
    $(".formComentario").on('submit',(function(e){
        e.preventDefault();
        var comentarioPadre = $("#idComentarioPadre").val();
        var idTrabajo = $("#idTrabajo").val();
        var idUsuario = $("#idUsuario").val();
        var contenido = $("#contenido").val();

        var data={comentarioPadre:comentarioPadre,idTrabajo:idTrabajo,idUsuario:idUsuario,contenido:contenido};
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: "{{route('comentario.store')}}",
            method: "POST",
            data:new FormData(this),
            dataType:'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $(".subirComentario").attr("disabled",true);
                $(".subirComentario").empty();
                $(".subirComentario").append("Enviando...");
            },
            success: function(data){
                $(".subirComentario").attr("disabled",false);
                $(".subirComentario").empty();
                $(".subirComentario").append("Enviar");
                window.location = data.url
            },
            error: function(msg){
                var errors = $.parseJSON(msg.responseText);
                $("#msjError").empty();
                $("#msjError").append("<p>"+errors.errors+"</p>")
                $(".subirComentario").empty();
                $(".subirComentario").append("Enviar");
                $(".subirComentario").attr("disabled",false);
                $("#respuestaComentario").modal("show");
                
            }                      
        });
    }));
});
</script>


@endsection