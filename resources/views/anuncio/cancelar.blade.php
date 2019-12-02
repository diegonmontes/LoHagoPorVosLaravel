
@extends('layouts.layout')

@section('content')
<section class="container h-100">
    <div class="row h-100 justify-content-center ">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                  <h2>Cancelar el anuncio</h2>
                </div>
                <div class="card-body">

                  <form method="POST" id="formCancelar" name="formCancelar" action="{{ route('multa.cancelartrabajo') }}"  role="form">
                      {{ csrf_field() }}

                      <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label>Motivo: *</label>
                                    <input type="text" name="motivo" id="motivo" class="form-control" placeholder="Ingrese un motivo por el cuál va a cancelar el anuncio">
                              </div>
                      </div>

                      <input type="hidden" name="idTrabajo" id="idTrabajo" value="{{$trabajo->idTrabajo}}">
                      <input type="checkbox" name="checkbox" id="checkbox"> Entiendo que estoy cancelando un anuncio ya asignado y que voy a tener que abonar una multa

                      <br>
                      <div class="row">
                              <input type="submit"  value="Confirmar" class="btn btn-success btn-block">
                      </div>
                  </form>
                </div>
    </div>
</section>
<!-- Modal -->
<div id="cancelarModal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    $("#formCancelar").on('submit',(function(e){
      e.preventDefault();
      var motivo = $("#motivo").val();
      var idTrabajo = $("#idTrabajo").val();
      

      var data={motivo:motivo,idTrabajo:idTrabajo};
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        url: "{{ route('multa.cancelartrabajo') }}",
        method: "POST",
        data:new FormData(this),
        dataType:'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          //Cerramos el modal de actualizar datos
          $("#cancelarModal").modal("hide");
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
          $('#cancelarModal').modal('show');
        },
        success: function(data){
          //Quitamos el boton cerrar
          $('.botonCerrar').empty();
          //Quitamos el icono de carga
          $('#cargando').empty();
          //Quitamos el titulo y agregamos uno nuevo
          $('.tituloModal').empty();
          $('.tituloModal').append('<p>Anuncio cancelado.<p>');
          //Quitamos el mensaje y agremaos uno nuevo
          $('#mensaje').empty();
          $('#mensaje').append('<br><h5 style="margin-left: 3%">La pagina se redireccionara en 3 segundos...</h5><br>');
          //Dejamos el modal abierto 3 segundos
          setTimeout(function(){
            $('#cancelarModal').modal('hide');
            window.location = data.url
          },3000);
        },
        error: function(msg){
          var errors = $.parseJSON(msg.responseText);
          console.log(errors);
          //Quitamos el titulo y agregamos uno nuevo
          $('.tituloModal').empty();
          $('.tituloModal').append('Error al actualizar los datos');
          //Quitamso el icono de carga
          $('#cargando').empty();
          //Agregamos un mensaje
          $('#mensaje').append('<br><h5 style="margin-left: 3%">'+errors.errors.valor[0]+'</h5><br>');
          //Agregamos el boton cerrar
          $('.botonCerrar').append('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
          
          
        }                      
      });
    }));
  });
  </script>

@endsection