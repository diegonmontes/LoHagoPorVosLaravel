@extends('admin')
@section('jsHead')
	<script src="{{asset('js/buscarLocalidades.js')}}"></script>
	<script src="{{asset('js/previaImagen.js')}}"></script>
@endsection
@section('content')
<div class="row">
	<section class="content">
		<div class="col-md-6 col-md-offset-2">
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Error!</strong> Revise los campos obligatorios.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			@if(Session::has('success'))
			<div class="alert alert-info">
				{{Session::get('success')}}
			</div>
			@endif
		</div>

        <div class="card">
            <div class="card-header">
				<h3>Editar Trabajo</h3>
			</div>
                
			<div class="card-body">
				<form method="POST" id="formEditarTrabajo" name="formEditarTrabajo" action="{{ route('trabajo.updatepanel',$trabajo->idTrabajo) }}"  role="form">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="PATCH">
					<input type="hidden" name="idTrabajo" id="idTrabajo" value={{$trabajo->idTrabajo}}>
					<div class="row">
						<div class="form-group">
							<label>Titulo:</label><br>
							<input type="text" name="titulo" id="titulo" class="form-control input-sm" value="{{$trabajo->titulo}}">
							<span id="msgtitulo" class="text-danger">{{ $errors->first('titulo') }}</span>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label>Descripcion:</label><br>
							<input type="text" name="descripcion" id="descripcion" class="form-control input-sm" value="{{$trabajo->descripcion}}">
							<span id="msgdescripcion" class="text-danger">{{ $errors->first('descripcion') }}</span>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label>Monto:</label><br>
							<input type="text" name="monto" id="monto" class="form-control input-sm" value="{{$trabajo->monto}}">
							<span id="msgmonto" class="text-danger">{{ $errors->first('monto') }}</span>
						</div>
					</div>
					
					<div class="row">
						<label for="idEstado">Estado:</label>
						<select class="form-control" name="idEstado" id="idEstado">
                        <option value="" selected disabled>Seleccione un estado </option>
							@foreach($listaEstados as $estado)
								<option value="{{$estado->idEstado}}"
									@if($trabajo->estado->idEstado == $estado->idEstado){
										selected
										}
									@endif>
									{{$estado->idEstado." - ".$estado->nombreEstado}}
								</option>
							@endforeach
						</select>
					</div>

					<div class="row">
						<label for="idCategoriaTrabajo">Categoria:</label>
						<select class="form-control" name="idCategoriaTrabajo" id="idCategoriaTrabajo">
                        <option value="" selected disabled>Seleccione una categor&iacute;a </option>
							@foreach($listaCategorias as $categoria)
								<option value="{{$categoria->idCategoriaTrabajo}}"
									@if($trabajo->categoriaTrabajo->idCategoriaTrabajo == $categoria->idCategoriaTrabajo){
										selected
										}
									@endif>
									{{$categoria->idCategoriaTrabajo." - ".$categoria->nombreCategoriaTrabajo}}
								</option>
							@endforeach
						</select>
					</div>

					<div class="row">
						<label for="idPersona">Persona:</label>
						<select class="form-control" name="idPersona" id="idPersona">
                        <option value="" selected disabled>Seleccione una persona </option>
							@foreach($listaPersonas as $persona)
								<option value="{{$persona->idPersona}}"
									@if($trabajo->persona->idPersona == $persona->idPersona){
										selected
										}
									@endif>
									{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}
								</option>
							@endforeach
						</select>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 inputSelect">
							<label for="idProvincia">PROVINCIA</label>
								<select class="form-control" name="idProvincia" id="idProvincia" style="color: #1e1e27" required>
								@foreach ($listaProvincias as $provincia)
									<option value="{{$provincia->idProvincia}}"
										@if($provincia->idProvincia == $trabajo->localidad->idProvincia)
											selected
										@endif
									>{{$provincia->nombreProvincia}}</option>
									@endforeach
							</select>
							<span id="msgidProvincia" class="text-danger">{{ $errors->first('idProvincia') }}</span>
						</div>
						<input type="hidden" name="localidadActual" id="localidadActual" value={{$trabajo->localidad->idLocalidad}}>

						<div class="col-xs-12 col-sm-12 col-md-6 inputSelect">
							<label for="idLocalidad" class="control-label">LOCALIDAD</label>
							<select name="idLocalidad" id="idLocalidad" class="form-control" style="color: #1e1e27" required>
								<option value="">Seleccione una opcion</option>
							</select>
							<span id="msgidLocalidad" class="text-danger">{{ $errors->first('idLocalidad') }}</span>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label>Tiempo expiracion:</label><br>
							<input type="text"  id="datepicker" class="form-control inputBordes" value="{{$trabajo->tiempoExpiracion}}" style="background-color: #fff;" readonly>
                            <input type="text" id="datepickerAlt" name="tiempoExpiracion" class="datepicker-picker"  >	
							<span id="msgtiempoExpiracion" class="text-danger">{{ $errors->first('tiempoExpiracion') }}</span>
						</div>
					</div>

					<br/>
					<div class="row">
						<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
						<a href="{{ route('trabajo.indexpanel') }}" class="btn btn-info btn-block" >Atrás</a>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
        <script type="text/javascript">
            $('#datepicker').datetimepicker({
                altField: "#datepickerAlt",
                altFieldTimeOnly: false,
                altFormat: "yy-mm-dd",
                controlType: 'select',
                oneLine: true,
                altTimeFormat: "H:m",
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss",
                minDate: '2019-01-01',
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
				weekHeader: "Sm"
            });   
        </script>
@endsection

@section('js')


<script type="text/javascript">
    $(document).ready(function(){
        var valorInicial = $('select#idProvincia').val();
		var localidadActual = $('#localidadActual').val();
        cargarLocalidades(valorInicial,localidadActual);
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
            $('#msgtitulo').append('Maximo de letras sobrepasado.')
        }else if(titulo.length == 0){
            $('#msgtitulo').empty();
            $('#msgtitulo').append('El titulo es obligatorio.')
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
            $('#msgdescripcion').append('Maximo de letras sobrepasado.')
        }else if(descripcion.length == 0){
            $('#msgdescripcion').empty();
            $('#msgdescripcion').append('La descripcion es obligatoria.')
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
            $('#msgmonto').append('Solamente se puede ingresar numeros.')
        }else if(monto.length == 0){
            $('#msgmonto').empty();
            $('#msgmonto').append('El monto es obligatorio.')
        }else{
            $('#msgmonto').empty();
        }
    }

    //Funcion que controla el mensaje de imagen
    $('#files').on('change',function(){
        $('#msgimagen').empty();
    })

    $(document).ready(function (e){
        $("#formEditarTrabajo").on('submit',(function(e){
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
                url: "{{ route('trabajo.updatepanel') }}",
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



