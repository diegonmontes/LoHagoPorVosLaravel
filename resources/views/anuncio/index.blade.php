@extends('layouts.layout')
@section('content')
    <section class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            
            @if(Session::has('success'))
                <div class="alert alert-info">
                    {{Session::get('success')}}

                </div>
            @endif

            <div class="col-xs-12 col-sm-12 col-md-8">
                <form method="post" id="formCrearAnuncio" action="{{ route('trabajo.store') }}" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                    <div class="card">
                            <div class="card-header">
                                <h4>Completa todos los campos para publicar tu anuncio</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <span id="msgvalido" class="text-danger"></span>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>TITULO DEL ANUNCIO*</label>
                                                <input type="text" name="titulo" id="titulo" class="form-control inputBordes" placeholder="El titulo de tu anuncio. Pensalo bien para llamar la atención." required>
                                                <span id="msgtitulo" class="text-danger">{{ $errors->first('titulo') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <label>INGRESE UNA IMAGEN(opcional)</label>
                                            <div class="drag-drop-imagenTrabajo imagenTrabajo">
                                                <input type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenTrabajo" />
                                                <output id="thumbnil" class="preview-imagenTrabajo">
                                                        <img class="preview-imagenTrabajo" src="{{asset('images/subirImagen.png')}}" style="width: 30%; margin: auto;">

                                                </output>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>DESCRIPCION*</label><br>
                                                <textarea type="text" rows="6" name="descripcion" id="descripcion" class="form-control inputBordes" placeholder="Describe bien lo que quieres. Mientras más detalles mejor." required></textarea>
                                                <span id="msgdescripcion" class="text-danger">{{ $errors->first('descripcion') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                                            <label for="idCategoriaTrabajo">CATEGORIA*</label>
                                            <select class="form-control inputSelect" name="idCategoriaTrabajo" id="idCategoriaTrabajo" required>
                                                <option value="" disabled selected>Seleccione una categoria</option>
                                                @foreach($listaCategoriaTrabajo as $unaCategoria)
                                                <option value="{{$unaCategoria->idCategoriaTrabajo}}">
                                                    {{$unaCategoria->nombreCategoriaTrabajo}}</option>
                                                @endforeach
                                            </select>
                                            <span id="msgidCategoriaTrabajo" class="text-danger">{{ $errors->first('idCategoriaTrabajo') }}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>MONTO*</label>
                                                <input type="number" name="monto" id="monto" class="form-control input-sm inputBordes" placeholder="$" min="1" pattern="^[0-9]+" required>
                                                <span id="msgMonto" class="text-danger">{{ $errors->first('monto') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>ESPERAR POSTULANTES HASTA*</label>
                                                <input type="text"  id="datepicker"  class="form-control inputBordes" placeholder="¿Hasta cuando se pueden postular?" required>
                                                <input type="text" id="datepickerAlt" name="tiempoExpiracion" class="datepicker-picker" >
                                                <span id="msgtiempoExpiracion" class="text-danger">{{ $errors->first('tiempoExpiracion') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                                                    
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <label for="idProvincia">PROVINCIA*</label>
                                            <select class="form-control inputSelect" name="idProvincia" id="idProvincia" >
                                                @foreach ($provincias as $unaProvincia)
                                                    <option value="{{$unaProvincia->idProvincia}}">
                                                        {{$unaProvincia->nombreProvincia}}</option>
                                                @endforeach
                                            </select>
                                            <span id="msgProvincia" class="text-danger">{{ $errors->first('idProvincia') }}</span>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <label for="idLocalidad" class="control-label">LOCALIDAD*</label>
                                            <select name="idLocalidad" id="idLocalidad" class="form-control inputSelect">
                                                <option value="">Seleccione una opcion</option>
                                            </select>
                                            <span id="msgidlocalidad" class="text-danger">{{ $errors->first('idLocalidad') }}</span>
                                        </div>
                                    </div>
                                    <br>
                                    <h6>Lo campos que tienen (*) son obligatorios</h6>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" id="boton" name="boton"  class="btn btn-success btn-block btn-lg">¡Publicar!</button>
                                        </div>
                                    </div>
                            </div>
                    </div> 
                </form>
            </div>
        </div>

        <script type="text/javascript">
        
        $(document).ready(function (e){
            $("#formCrearAnuncio").on('submit',(function(e){
                e.preventDefault();
                var titulo = $("#titulo").val();
                var descripcion = $("#descripcion").val();
                var idCategoriaTrabajo = $("#idCategoriaTrabajo").val(); 
                var monto = $("#monto").val();
                var tiempoExpiracion = $("#datepickerAlt").val();
                var idProvincia = $('#idProvincia').val();
                var idLocalidad = $('#idLocalidad').val();
                var imagenTrabajo = $('#files').val();
                var data={titulo:titulo,descripcion:descripcion,idCategoriaTrabajo:idCategoriaTrabajo,monto:monto,tiempoExpiracion:tiempoExpiracion,idProvincia:idProvincia,idLocalidad:idLocalidad,imagenTrabajo:imagenTrabajo};
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: "{{ route('trabajo.store') }}",
                    method: "POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data){
                        alert(data.message);
                        window.location = data.url;
                    },
                    error: function(msg){
                        var errors = $.parseJSON(msg.responseText);
                        $.each(errors.errors, function (key, val) {
                            $("#msg" + key).text(val[0]);
                        });
                    }                      
                });
            }));
        });
        </script>


    </section>
@endsection


