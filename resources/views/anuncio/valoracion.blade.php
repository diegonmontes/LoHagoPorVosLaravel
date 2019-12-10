
@extends('layouts.layout')

@section('jsHead')
	<script src="{{asset('js/previaImagen.js')}}"></script>
@endsection

@section('css')

<style >
.rating {
    display: inline-block;
    position: relative;
    height: 50px;
    line-height: 50px;
    font-size: 50px;
  }
  
  .rating label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    cursor: pointer;
  }
  
  .rating label:last-child {
    position: static;
  }
  
  .rating label:nth-child(1) {
    z-index: 5;
  }
  
  .rating label:nth-child(2) {
    z-index: 4;
  }
  
  .rating label:nth-child(3) {
    z-index: 3;
  }
  
  .rating label:nth-child(4) {
    z-index: 2;
  }
  
  .rating label:nth-child(5) {
    z-index: 1;
  }
  
  .rating label input {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
  }
  
  .rating label .icon {
    float: left;
    color: transparent;
  }
  
  .rating label:last-child .icon {
    color: #000;
  }
  
  .rating:not(:hover) label input:checked ~ .icon,
  .rating:hover label:hover input ~ .icon {
    color: #09f;
  }
  
  .rating label input:focus:not(:checked) ~ .icon:last-child {
    color: #000;
    text-shadow: 0 0 5px #09f;
  }
</style>
@endsection

@section('content')
<section class="container h-100">
    <div class="row h-100 justify-content-center ">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                  <h2>Valora el trabajo realizado</h2>
                </div>
                <div class="card-body">

                  <form method="POST" id="formTerminado" enctype="multipart/form-data" name="formTerminado" action="{{ route('valoracion.enviarvaloracion') }}"  role="form">
                      {{ csrf_field() }}

                      <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label>INGRESE UN COMENTARIO (opcional):</label>
                                    <input type="text" name="comentarioValoracion" id="comentarioValoracion" class="form-control" placeholder="Ingrese un comentario">
                              </div>
                      </div>

                      <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12">
                              <label>INGRESE UNA IMAGEN DEL TRABAJO TERMINADO(opcional)</label>
                              <div class="drag-drop-imagenTrabajo imagenTrabajo">
                                  <input class="inputImagenTrabajo" type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenValoracion" />
                                  <output id="thumbnil" class="preview-imagenTrabajo">
                                          <img class="preview-imagenTrabajo" src="{{asset('images/subirImagen.png')}}" style="width: 30%; margin: auto;">

                                  </output>
                              </div>
                              <span id="msgimagen" class="text-danger">{{ $errors->first('imagen') }}</span>

                          </div>
                      </div>
                      
                      <label>VALORA CON ESTRELLAS, COMO MINIMO DEBES ELEGIR UNA(obligatorio)</label>

                      <div class="rating">
                          <label>
                              <input type="radio" name="valor" value="1" />
                              <span class="fa fa-star icon"></span>
                            </label>
                            <label>
                              <input type="radio" name="valor" value="2" />
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                            </label>
                            <label>
                              <input type="radio" name="valor" value="3" />
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>   
                            </label>
                            <label>
                              <input type="radio" name="valor" value="4" />
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                            </label>
                            <label>
                              <input type="radio" name="valor" value="5" />
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                              <span class="fa fa-star icon"></span>
                            </label>
                      </div>

                  <input type="hidden" name="idTrabajo" id="idTrabajo" value="{{$trabajo->idTrabajo}}">

                      <br>
                      <div class="row">
                              <input type="submit"  value="Enviar y finalizar el trabajo" class="btn btn-success btn-block">
                      </div>
                  </form>
                </div>
    </div>
</section>
<!-- Modal -->
<div id="valoracionModal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title tituloModal" id="exampleModalLabel">
                    
                </h5>
            </div>
            <div class="content align-content-center align-self-center" id="cargando">

            </div>
            <div class="content" id="mensaje">

            </div>
            <div class="modal-footer botonCerrar">

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript">

  $(document).ready(function (e){
    $("#formTerminado").on('submit',(function(e){
      e.preventDefault();
      var comentarioValoracion = $("#comentarioValoracion").val();
      var imagenValoracion = $("#imagenValoracion").val();
      var valor = $("#valor").val(); 
    
      var data={comentarioValoracion:comentarioValoracion,valor:valor};
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        url: "{{ route('valoracion.enviarvaloracion') }}",
        method: "POST",
        data:new FormData(this),
        dataType:'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          //Cerramos el modal de actualizar datos
          $("#valoracionModal").modal("hide");
          //Quitamos el boton cerrar
          $('.botonCerrar').empty();
          //Quitamos el mensaje
          $('#mensaje').empty();
          //Quitamos el titulo y agregamos uno nuevo
          $('.tituloModal').empty();
          $('.tituloModal').append('Cargando datos ...')
          //Agregamos el icono de carga
          $('#cargando').append('<p><div class="lds-ring"><div></div><div></div><div></div><div></div></div></p>');
          //Abrimos el modal
          $('#valoracionModal').modal('show');
        },
        success: function(data){
          //Quitamos el boton cerrar
          $('.botonCerrar').empty();
          //Quitamos el icono de carga
          $('#cargando').empty();
          //Quitamos el titulo y agregamos uno nuevo
          $('.tituloModal').empty();
          $('.tituloModal').append('<p>Valoracion enviada.<p>');
          //Quitamos el mensaje y agremaos uno nuevo
          $('#mensaje').empty();
          $('#mensaje').append('<br><h5 style="margin-left: 3%">La pagina se redireccionara en 3 segundos...</h5><br>');
          //Dejamos el modal abierto 3 segundos
          setTimeout(function(){
            $('#valoracionModal').modal('hide');
            window.location = data.url
          },3000);
        },
        error: function(msg){
          var errors = $.parseJSON(msg.responseText);
          console.log(errors);
          //Quitamos el titulo y agregamos uno nuevo
          $('.tituloModal').empty();
          $('.tituloModal').append('Error al enviar la valoración');
          //Quitamso el icono de carga
          $('#cargando').empty();
          //Agregamos un mensaje
          $('#mensaje').append('<br><h5 style="margin-left: 3%">'+errors.errors.valor[0]+'</h5><br>');
          //Agregamos el boton cerrar
          $('.botonCerrar').append('<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>');
          
          
        }                      
      });
    }));
  });
  </script>

@endsection