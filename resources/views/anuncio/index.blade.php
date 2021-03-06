@extends('layouts.layout')

@section('jsHead')

	<script src="{{asset('js/buscarLocalidades.js')}}"></script>
	<script src="{{asset('js/previaImagen.js')}}"></script>

@endsection

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
                                            <div class="form-group">
                                                <label>T&Iacute;TULO DEL ANUNCIO *</label>
                                                <input type="text" name="titulo" id="titulo" class="form-control inputBordes" placeholder="El titulo de tu anuncio. Pensalo bien para llamar la atención." >
                                                <span id="msgtitulo" class="text-danger">{{ $errors->first('titulo') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <label>INGRESE UNA IMAGEN(opcional)</label>
                                            <div class="drag-drop-imagenTrabajo imagenTrabajo">
                                                <input class="inputImagenTrabajo" type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenTrabajo" />
                                                <output id="thumbnil" class="preview-imagenTrabajo">
                                                        <img class="preview-imagenTrabajo" src="{{asset('images/subirImagen.png')}}" style="width: 30%; margin: auto;">

                                                </output>
                                            </div>
                                            <span id="msgimagen" class="text-danger">{{ $errors->first('imagen') }}</span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>DESCRIPCI&Oacute;N *</label><br>
                                                <textarea type="text" rows="6" name="descripcion" id="descripcion" class="form-control inputBordes" placeholder="Describe bien lo que quieres. Mientras más detalles mejor." ></textarea>
                                                <span id="msgdescripcion" class="text-danger">{{ $errors->first('descripcion') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 inputSelect">
                                            <label for="idCategoriaTrabajo">CATEGOR&Iacute;A *</label>
                                            <select class="form-control" name="idCategoriaTrabajo" id="idCategoriaTrabajo">
                                                <option value="" disabled selected>Seleccione una categor&iacute;a</option>
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
                                                <label>MONTO *</label>
                                                <input type="number" name="monto" id="monto" class="form-control input-sm inputBordes" placeholder="$" min="1" pattern="^[0-9]+" >
                                                <span id="msgmonto" class="text-danger">{{ $errors->first('monto') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>ESPERAR POSTULANTES HASTA *</label>
                                                <input type="text"  id="datepicker"  class="form-control inputBordes" style="background-color: #fff;" placeholder="¿Hasta cuando se pueden postular?" readonly >
                                                <input type="text" id="datepickerAlt" name="tiempoExpiracion" class="datepicker-picker" >
                                                <span id="msgtiempoExpiracion" class="text-danger">{{ $errors->first('tiempoExpiracion') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                                                    
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 inputSelect">
                                            <label for="idProvincia">PROVINCIA *</label>
                                            <select class="form-control" name="idProvincia" id="idProvincia" >
                                                @foreach ($provincias as $unaProvincia)
                                                    <option value="{{$unaProvincia->idProvincia}}">
                                                        {{$unaProvincia->nombreProvincia}}</option>
                                                @endforeach
                                            </select>
                                            <span id="msgProvincia" class="text-danger">{{ $errors->first('idProvincia') }}</span>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 inputSelect">
                                            <label for="idLocalidad" class="control-label">LOCALIDAD *</label>
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
        
        <!-- Modal -->
		<div id="loadingAnuncio" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </section>
@endsection

@section('js')

<script type="text/javascript">
    $(document).ready(function(){
        var valorInicial = $('select#idProvincia').val();
        cargarLocalidades(valorInicial,null);
        
        $("#idProvincia").change(function(){
            var idProvincia = $(this).val();
            cargarLocalidades(idProvincia,null);
        });
        
        $('#borrarCampos').click(function() {
            $('input[type="text"]').val('');
            $('select[name="idProvincia"]').val('20');
            cargarLocalidades(20,null);
            $('input[type=checkbox]').prop('checked',false);
        });
    });
</script>


<script type="text/javascript">
    $('#datepicker').datetimepicker({
        altField: "#datepickerAlt",
        altFieldTimeOnly: false,
        altFormat: "yy-mm-dd",
        controlType: 'select',
        oneLine: true,
        altTimeFormat: "H:m",
        dateFormat: "dd/mm/yy",
        timeFormat: "HH:mm",
        minDate: 0,
        timeText:"Horario",
		currentText: "Hoy",
		closeText: "Cerrar",
		prevText: "&#x3C;Anterior",
		nextText: "&#x3ESiguiente",
		monthNames: [ "Enero","Febrero","Marzo","Abril","Mayo","Junio",
		"Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre" ],
		monthNamesShort: [ "ene","feb","mar","abr","may","jun",
		"jul","ago","sep","oct","nov","dic" ],
		dayNames: [ "domingo","lunes","martes","miércoles","jueves","viernes","sábado" ],
		dayNamesShort: [ "dom","lun","mar","mié","jue","vie","sáb" ],
		dayNamesMin: [ "D","L","M","M","J","V","S" ],
		showMonthAfterYear: false,
		yearSuffix: "",
		weekHeader: "Sm",
    });   
</script>

<script type="text/javascript">
    //Funciones que controla el ingreso del titulo
    $('#titulo').on('keyup',function(){
        controlTitulo();
    })

    $('#titulo').on('click',function(){
        controlTitulo();
    })

    function controlTitulo(){
        var titulo = $("#titulo").val();
        if(titulo.length>255){
            $('#msgtitulo').empty();
            $('#msgtitulo').append('M&aacute;ximo de letras sobrepasado.')
        }else if(titulo.length == 0){
            $('#msgtitulo').empty();
            $('#msgtitulo').append('Debe ingresar un t&iacute;tulo.')
        }else{
            $('#msgtitulo').empty();
        }
    }

    //Funciones que controla el ingreso de la Descripcion
    $('#descripcion').on('keyup',function(){
        controlDescripcion();
    })

    $('#descripcion').on('click',function(){
        controlDescripcion();
    })

    function controlDescripcion(){
        var descripcion = $("#descripcion").val();
        if(descripcion.length>511){
            $('#msgdescripcion').empty();
            $('#msgdescripcion').append('M&aacute;ximo de letras sobrepasado.')
        }else if(descripcion.length == 0){
            $('#msgdescripcion').empty();
            $('#msgdescripcion').append('Debe ingresar una descripci&oacute;n del anuncio.')
        }else{
            $('#msgdescripcion').empty();
        }
    }

    //Funciones que controla el ingreso del monto
    $('#monto').on('keyup',function(){
        controlMonto();
    })

    $('#monto').on('click',function(){
        controlMonto();
    })

    function controlMonto(){
        var monto = $("#monto").val();
        var patron = /^[0-9]+$/;
        if (!patron.test(monto)){
            $('#msgmonto').empty();
            $('#msgmonto').append('Solamente se puede ingresar n&uacute;meros.')
        }else if(monto.length == 0){
            $('#msgmonto').empty();
            $('#msgmonto').append('Debe ingresar un monto.')
        }else{
            $('#msgmonto').empty();
        }
    }

    //Funcion que controla el mensaje de imagen
    $('#files').on('change',function(){
        $('#msgimagen').empty();
    })

    $(document).ready(function (e){
        $("#formCrearAnuncio").on('submit',(function(e){
            e.preventDefault();
            //Seteamos las variables ingresadas
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
                beforeSend: function() {
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
                    $('#loadingAnuncio').modal('show');
                },
                success: function(data){
                    //Quitamos el boton cerrar
                    $('.botonCerrar').empty();
                    //Quitamos el icono de carga
                    $('#cargando').empty();
                    //Quitamos el titulo y agregamos uno nuevo
                    $('.tituloModal').empty();
                    $('.tituloModal').append('<p>Anuncio creado exitosamente.<p>');
                    //Quitamos el mensaje y agremaos uno nuevo
                    $('#mensaje').empty();
                    $('#mensaje').append('<br><h5 style="margin-left: 3%">La pagina se redireccionara en 3 segundos...</h5><br>');
                    //Dejamos el modal abierto 3 segundos
                    setTimeout(function(){
                        $('#loadingAnuncio').modal('hide');
                        window.location = data.url
                    },3000);
                },
                error: function(msg){
                    //Quitamos el titulo y agregamos uno nuevo
                    $('.tituloModal').empty();
                    $('.tituloModal').append('Error al crear el anuncio');
                    //Quitamso el icono de carga
                    $('#cargando').empty();
                    //Agregamos un mensaje
                    $('#mensaje').append('<br><h5 style="margin-left: 3%">Por favor revise todos los campos del formulario.</h5><br>');
                    //Agregamos el boton cerrar
                    $('.botonCerrar').append('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    //Mostramos el mensaje de error
                    var errors = $.parseJSON(msg.responseText);
                    $.each(errors.errors, function (key, val) {
                        $("#msg" + key).text(val[0]);
                    });
                    
                }                      
            });
        }));
    });
</script>
@endsection


