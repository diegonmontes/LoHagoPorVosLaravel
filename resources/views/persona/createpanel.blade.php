@extends('admin')

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
			<div class="col-xs-6 col-sm-6 col-md-8">
		<form id="formPersona" method="post" enctype="multipart/form-data" action="{{ route('persona.storepanel') }}"  role="form">
			{{ csrf_field() }}
			
				<div class="card">
					<div class="card-header">
						<h4> Completar para terminar el registro </h4>
					</div>

					<div class="card-body">

						<div class="row margenImagenPerfil">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="drag-drop-imagenPersona inputImagenPersona">
									<input type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenPersona" />
									<output id="thumbnil" class="preview-imagenPersona">
										<img  class="preview-imagenPersona" src="">
									</output>
								</div>
								<span id="msgimagenPersona" class="text-danger">{{ $errors->first('imagenPersona') }}</span>
							</div>
						</div>

						<br>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6">
								<div class="form-group">
									<label>NOMBRE</label>
									<br>
									<input type="text" name="nombrePersona" id="nombrePersona" class="form-control input-sm inputBordes" style="color: #1e1e27"" placeholder="Nombre">
									<span id="msgnombrePersona" class="text-danger">{{ $errors->first('nombrePersona') }}</span>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6">
								<div class="form-group">
									<label>APELLIDO</label>
									<br>
									<input type="text" name="apellidoPersona" id="apellidoPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" placeholder="Apellido">
									<span id="msgapellidoPersona" class="text-danger">{{ $errors->first('apellidoPersona') }}</span>
								</div>
							</div>
						</div>
						<div class="row">
								<label for="idUsuario">Usuario:</label>
								<select class="form-control" name="idUsuario" id="idUsuario">
								<option value="" selected disabled>Seleccione un usuario </option>
									@foreach($usuarios as $usuario)
										<option value="{{$usuario->idUsuario}}">
										{{$usuario->idUsuario." - ".$usuario->nombreUsuario}}</option>
									@endforeach
								</select>		
							</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6">
								<div class="form-group">
									<label>DNI</label><br>
									<input type="text" name="dniPersona" id="dniPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" placeholder="12345678">
									<span id="msgdniPersona" class="text-danger">{{ $errors->first('dniPersona') }}</span>

								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6">
								<div class="form-group">
									<label>TELEFONO</label><br>
									<input type="text" name="telefonoPersona" id="telefonoPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" placeholder="(299)15123456">
									<span id="msgtelefonoPersona" class="text-danger">{{ $errors->first('telefonoPersona') }}</span>

								</div>
							</div>
						</div>


						
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 inputSelect">
								<label for="idProvincia">PROVINCIA</label>
									<select class="form-control" name="idProvincia" id="idProvincia" style="color: #1e1e27">
									@foreach ($provincias as $unaProvincia)
										<option value="{{$unaProvincia->idProvincia}}">
										{{$unaProvincia->nombreProvincia}}</option>
									@endforeach
								</select>
								<span id="msgidProvincia" class="text-danger">{{ $errors->first('idProvincia') }}</span>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 inputSelect">
								<label for="idLocalidad" class="control-label">LOCALIDAD</label>
								<select name="idLocalidad" id="idLocalidad" class="form-control" style="color: #1e1e27">
									<option value="">Seleccione una opcion</option>
								</select>
								<span id="msgidLocalidad" class="text-danger">{{ $errors->first('idLocalidad') }}</span>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<label>N&uacute;mero de CBU:</label><br>
								<input type="number" name="numeroCBU" id="numeroCBU" class="form-control input-sm">
							</div>
						</div>
						<div class="row">

							<span id="msgnumeroCBU" class="text-danger">{{ $errors->first('numeroCBU') }}</span>

						</div>

						<br>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6" id="seleccionHabilidades">
							@php
							if (count($habilidades)>0){ // Si existe alguna habilidad cargada en la base de datos
								echo '<h6>HABILIDADES</h6>';
									foreach ($habilidades as $habilidad){
										echo '<div class="form-check form-check-inline col-5">';
										echo '<input class="form-check-input" type="checkbox" id="habilidades' .$habilidad->idHabilidad.'" name="habilidades[]" value="' .$habilidad->idHabilidad.'">';
										echo '<label class="form-check-label" for="habilidades' .$habilidad->idHabilidad.'">'.$habilidad->nombreHabilidad.'</label>';
										echo '</div>';
									};
								};
							@endphp
							<div class="row">
								<span id="msghabilidades" class="text-danger">{{ $errors->first('habilidades') }}</span>
							</div>
							</div>
							<br>
							<div class="col-xs-12 col-sm-12 col-md-6" id="categoriasDeTrabajo">
							@php
							if (count($categoriasTrabajo)>0){
								echo '<h6>PREFERENCIAS</h6>';
								foreach ($categoriasTrabajo as $categoriaTrabajo){
									echo '<div class="form-check form-check-inline col-5">';
										echo '<input class="form-check-input" type="checkbox" id="preferenciaPersona' .$categoriaTrabajo->idCategoriaTrabajo.'" name="preferenciaPersona[]" value="' .$categoriaTrabajo->idCategoriaTrabajo.'">';
										echo '<label class="form-check-label" for="preferenciaPersona' .$categoriaTrabajo->idCategoriaTrabajo.'">'.$categoriaTrabajo->nombreCategoriaTrabajo.'</label>';
										echo '</div>';
									};
								}
								
							@endphp
							<div class="row">
							<span id="msgpreferenciaPersona" class="text-danger">{{ $errors->first('preferenciaPersona') }}</span>
							</div>
							</div>
						</div>

				
						<div class="row">
							<div class="col-xs-6 col-sm-12 col-md-12">
								<input type="submit"  value="Guardar mis datos" class="btn btn-success btn-block inputBordes">
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<input id="borrarCampos" type="button"  value="Borrar" class="btn btn-primary btn-block inputBordes">
							</div>
						</div>
				</form>
			</div>
		</div>
	</div>

		<!-- Modal -->
		<div id="loadingPersona" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        cargarLocalidades(valorInicial);
        
        $("#idProvincia").change(function(){
            var idProvincia = $(this).val();
            cargarLocalidades(idProvincia);
        });
        
        $('#borrarCampos').click(function() {
            $('input[type="text"]').val('');
            $('select[name="idProvincia"]').val('20');
            cargarLocalidades(20);
            $('input[type=checkbox]').prop('checked',false);
        });
    });
</script>

<script type="text/javascript">

	//Funcion que controla el ingreso del nombre de la persona
	$("#nombrePersona").on("change",function(){
		controlNombrePersona();
	})
	$("#nombrePersona").on("keyup",function(){
		controlNombrePersona();
	})
	function controlNombrePersona(){
		var nombrePersona = $("#nombrePersona").val();
		var patron = /^[a-zA-Z ]+$/i; //Patron que debe respetarse
		if (patron.test(nombrePersona)){
			if(nombrePersona.lenght > 80){
				$("#msgnombrePersona").empty();
				$("#msgnombrePersona").append("Sobrepasado el limite maximo de letas.");
			}else if(nombrePersona.lenght == 0){
				$("#msgnombrePersona").empty();
				$("#msgnombrePersona").append("El nombre es obligatorio.");
			}else{
				$("#msgnombrePersona").empty();
			}
		}else{
			$("#msgnombrePersona").empty();
			$("#msgnombrePersona").append("Solo esta permitido el ingreso de letras.");
		}
	}

	//Funcion que controla el ingreso del apellido de la persona
	$("#apellidoPersona").on("change",function(){
		controlApellidoPersona();
	})
	$("#apellidoPersona").on("keyup",function(){
		controlApellidoPersona();
	})
	function controlApellidoPersona(){
		var apellidoPersona = $("#apellidoPersona").val();
		var patron = /^[a-zA-Z ]+$/i; //Patron que debe respetarse
		if (patron.test(apellidoPersona)){
			if(apellidoPersona.lenght > 80){
				$("#msgapellidoPersona").empty();
				$("#msgapellidoPersona").append("Sobrepasado el limite maximo de letas.");
			}else if(nombrePersona.lenght == 0){
				$("#msgapellidoPersona").empty();
				$("#msgapellidoPersona").append("El apellido es obligatorio.");
			}else{
				$("#msgapellidoPersona").empty();
			}
		}else{
			$("#msgapellidoPersona").empty();
			$("#msgapellidoPersona").append("Solo esta permitido el ingreso de letras.");
		}
	}
	
	//Funcion que controla el ingreso del documento de la persona
	$("#dniPersona").on("change",function(){
		controlDniPersona();
	})
	$("#dniPersona").on("keyup",function(){
		controlDniPersona();
	})
	function controlDniPersona() {
		var dniPersona = $('#dniPersona').val();
		var patron = /^[0-9]+$/; //Patron que debe respetarse
		if(dniPersona.length == 0){
			$('#msgdniPersona').empty();
			$('#msgdniPersona').append('El DNI es obligatorio.')
		}else if (!patron.test(dniPersona)){
			$('#msgdniPersona').empty();
			$('#msgdniPersona').append('Solo se puede ingresar numeros.')
		}else if(dniPersona.length<8){
			$('#msgdniPersona').empty();
			$('#msgdniPersona').append('Ingrese un numero de DNI valido.')
		}else{
			$('#msgdniPersona').empty();
		}
	}

	//Funcion que controla el ingreso del telefono de la persona
	$("#telefonoPersona").on("change",function(){
		controlTelefonoPersona();
	})
	$("#telefonoPersona").on("keyup",function(){
		controlTelefonoPersona();
	})
	function controlTelefonoPersona() {
		var telefonoPersona = $('#telefonoPersona').val();
		var patron = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/; //Patron que debe respetarse
		if(telefonoPersona.length == 0){
			$('#msgtelefonoPersona').empty();
			$('#msgtelefonoPersona').append('El telefono es obligatorio.')
		}else if (!patron.test(telefonoPersona)){
			$('#msgtelefonoPersona').empty();
			$('#msgtelefonoPersona').append('Ingrese un numero telefonico valido.')
		}else{
			$('#msgtelefonoPersona').empty();
		}
	}

	function controlNumeroCBU() {
		var numeroCBU = $('#numeroCBU').val();
		var patron = /^[0-9]+$/; //Patron que debe respetarse
		if(numeroCBU.length == 0){
			if (!patron.test(telefonoPersona)){
				$('#msgnumeroCBU').empty();
				$('#msgnumeroCBU').append('Ingrese un numero de CBU v&aacute;lido.')
			} else {
				if (!(numeroCBU.length == 22)){
					$('#msgnumeroCBU').empty();
					$('#msgnumeroCBU').append('El CBU tiene 22 numeros.')
					}
			}
		} else {
			$('#msgnumeroCBU').empty();
		}	
	}

	//Funcion que controla los checkbox de habilidades
	$("#seleccionHabilidades input[type=checkbox]").on("click",function(){
		controlCategorias();
	})
	$("#seleccionHabilidades input[type=checkbox]").on("change",function(){
		controlCategorias();
	})
	function controlCategorias(){
		var contador = 0;
		$('#seleccionHabilidades input[type=checkbox]').each(function(){
			if (this.checked) {
				contador = contador + 1;
			}
		});
		if(contador<3){
			$("#msghabilidades").empty();
			$("#msghabilidades").append("Debe seleccionar minimo tres habilidades que posea.")
		}else{
			$("#msghabilidades").empty();
		}
	}

	//Funcion que controla los checkbox de categorias de trabajo
	$("#categoriasDeTrabajo input[type=checkbox]").on("click",function(){
		controlHabilidad();
	})
	$("#categoriasDeTrabajo input[type=checkbox]").on("change",function(){
		controlHabilidad();
	})
	function controlHabilidad(){
		var contador = 0;
		$('#categoriasDeTrabajo input[type=checkbox]').each(function(){
			if (this.checked) {
				contador = contador + 1;
			}
		});
		if(contador<3){
			$("#msgpreferenciaPersona").empty();
			$("#msgpreferenciaPersona").append("Debe seleccionar minimo tres categorias que desea ver primero.")
		}else{
			$("#msgpreferenciaPersona").empty();
		}
	}

	$(document).ready(function (e){
		$("#formPersona").on('submit',(function(e){
			e.preventDefault();
			var nombrePersona = $("#nombrePersona").val();
			var apellidoPersona = $("#apellidoPersona").val();
			var dniPersona = $("#dniPersona").val(); 
			var telefonoPersona = $("#telefonoPersona").val();
			var imagenPersona = $("#imagenPersona").val();
			var idProvincia = $('#idProvincia').val();
			var idLocalidad = $('#idLocalidad').val();
			var habilidades = $('#habilidades').val();
			var preferenciaPersona =$('#preferenciaPersona').val();
			var numeroCBU = $('#numeroCBU').val();
			var data={nombrePersona:nombrePersona,apellidoPersona:apellidoPersona,dniPersona:dniPersona,telefonoPersona:telefonoPersona,imagenPersona:imagenPersona,idProvincia:idProvincia,idLocalidad:idLocalidad,habilidades:habilidades,preferenciaPersona:preferenciaPersona,numeroCBU:numeroCBU};
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				url: "{{route('persona.storepanel') }}",
				method: "POST",
				data:new FormData(this),
				dataType:'json',
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
					$('#loadingPersona').modal('show');
				},
				success: function(data){
					//Quitamos el boton cerrar
					$('.botonCerrar').empty();
					//Quitamos el icono de carga
					$('#cargando').empty();
					//Quitamos el titulo y agregamos uno nuevo
					$('.tituloModal').empty();
					$('.tituloModal').append('<p>Datos cargado exitosamente.<p>');
					//Quitamos el mensaje y agremaos uno nuevo
					$('#mensaje').empty();
					$('#mensaje').append('<br><h5 style="margin-left: 3%">La pagina se redireccionara en 3 segundos...</h5><br>');
					//Dejamos el modal abierto 3 segundos
					setTimeout(function(){
						$('#loadingPersona').modal('hide');
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





