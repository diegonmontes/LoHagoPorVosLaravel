@extends('layouts.layout')
@section('content')
  	<section class="container">
        <div class="row justify-content-center">
			@if(Session::has('success'))
				<div class="alert alert-info">
					{{Session::get('success')}}
				</div>
			@endif
        </div>
		<form id="formPersona" method="post" enctype="multipart/form-data" action="@if($existePersona){{ route('persona.update') }}@else{{ route('persona.store') }}@endif"  role="form">
			{{ csrf_field() }}
			<div class="card">
				<div class="card-header">
					<h4> Completar para terminar el registro </h4>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<span id="msgvalido" class="text-danger"></span>
						</div>
					</div>

					<div class="row">
						<div class="drag-drop-imagenPersona imagenPersona">
							<input type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenPersona" />
							<output id="thumbnil" class="preview-imagenPersona">
								<img  class="preview-imagenPersona" src="@if($existePersona){{ asset('storage/perfiles/'.$persona->imagenPersona) }}@endif" style="width: 30%; margin: auto;">
							</output>
						</div>
						<span id="msgimagenPersona" class="text-danger">{{ $errors->first('imagenPersona') }}</span>
					</div>
					<br>
					<div class="row">
						<input type="hidden" name="idPersona" id="idPersona" value="{{$persona->idPersona}}">
						<div class="col-xs-6 col-sm-4 col-md-4">
							<div class="form-group">
								<label>NOMBRE</label>
								<br>
								<input type="text" name="nombrePersona" id="nombrePersona" class="form-control input-sm inputBordes" style="color: #1e1e27" value="@if($existePersona){{ $persona->nombrePersona }}@endif">
								<span id="msgnombrePersona" class="text-danger">{{ $errors->first('nombrePersona') }}</span>

							</div>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-4">
							<div class="form-group">
								<label>APELLIDO</label>
								<br>
								<input type="text" name="apellidoPersona" id="apellidoPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" value="@if($existePersona){{ $persona->apellidoPersona }}@endif">
								<span id="msgapellidoPersona" class="text-danger">{{ $errors->first('apellidoPersona') }}</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-4 col-md-4">
							<div class="form-group">
								<label>DNI</label><br>
								<input type="text" name="dniPersona" id="dniPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" value="@if($existePersona){{ $persona->dniPersona }}@endif">
								<span id="msgdniPersona" class="text-danger">{{ $errors->first('dniPersona') }}</span>

							</div>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-4">
							<div class="form-group">
								<label>TELEFONO</label><br>
								<input type="text" name="telefonoPersona" id="telefonoPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" value="@if($existePersona){{ $persona->telefonoPersona }}@endif">
								<span id="msgtelefonoPersona" class="text-danger">{{ $errors->first('telefonoPersona') }}</span>

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-4 col-md-4">
							<label for="idProvincia">PROVINCIA</label>
								<select class="form-control inputSelect" name="idProvincia" id="idProvincia" style="color: #1e1e27">
								@foreach ($provincias as $unaProvincia)
									<option value="{{$unaProvincia->idProvincia}}"
											@if($existePersona)
												@if($unaProvincia->idProvincia == $persona->idLocalidad)
													selected
												@endif
											@else
												@if($unaProvincia->idProvincia == 20)
													selected
												@endif
											@endif
									>{{$unaProvincia->nombreProvincia}}</option>
									@endforeach
							</select>
							<span id="msgidProvincia" class="text-danger">{{ $errors->first('idProvincia') }}</span>

						</div>
						<div class="col-xs-6 col-sm-4 col-md-4">
							<label for="idLocalidad" class="control-label">LOCALIDAD</label>
							<select name="idLocalidad" id="idLocalidad" class="form-control inputSelect" style="color: #1e1e27">
								<option value="">Seleccione una opcion</option>
							</select>
							<span id="msgidLocalidad" class="text-danger">{{ $errors->first('idLocalidad') }}</span>
						</div>
					</div>
				</div>
			<br>
			
			@php
			if (count($habilidades)>0){ // Si existe alguna habilidad cargada en la base de datos
				echo '<h6>HABILIDADES</h6>';
				if ($listaHabilidadesSeleccionadas!=null){ // Si lista de habilidades no es null, significa que esta editando el perfil y vamos a poner en checked las habilidades que selecciono antes
					foreach ($habilidades as $habilidad){ // por cada habilidad cargada en la bd
						$cantidadHabilidadesSeleccionadas = count($listaHabilidadesSeleccionadas); // obtenemos la cantidad de habilidades que cargo previamente
						$seleccionoHabilidad=false; // seteamos a falso
						$i=0; // inicializamos
						while ($seleccionoHabilidad!=true && $i<$cantidadHabilidadesSeleccionadas){
							$habilidadActual=$listaHabilidadesSeleccionadas[$i]; // seteamos el obj de la habilidad actual
							if ($habilidad->idHabilidad==$habilidadActual->idHabilidad){ // si coinciden seteamos a true. es para que no recorra de mas el arreglo
								$seleccionoHabilidad=true;
							};
							$i++;
						};
						if ($seleccionoHabilidad){ // si lo selecciono, asignamos checked
							echo '<input type="checkbox" id="habilidades" name="habilidades[]" checked value="' .$habilidad->idHabilidad.'">'.$habilidad->nombreHabilidad;
							echo '<br/>';
						} else {
							echo '<input type="checkbox" id="habilidades" name="habilidades[]" value="' .$habilidad->idHabilidad.'">'.$habilidad->nombreHabilidad;
							echo '<br/>';
						}
					};

				} else { // si ingresa aca es porque esta creando un perfil y nunca selecciono ninguna habilidad
					foreach ($habilidades as $habilidad){
					echo '<input type="checkbox" id="habilidades" name="habilidades[]" value="' .$habilidad->idHabilidad.'">'.$habilidad->nombreHabilidad;
					echo '<br/>';
					}
				}
			}
			

			@endphp
			<span id="msghabilidades" class="text-danger">{{ $errors->first('habilidades') }}</span>
			<br/>
			<div class="col-md-4">
			@php
			if (count($categoriasTrabajo)>0){
				echo '<h6>Preferencia de categorias a mostrar</h6><br>';

				if ($listaPreferenciasSeleccionadas!=null){ // Si lista de preferencias no es null, significa que esta editando el perfil y vamos a poner en checked las habilidades que selecciono antes
					foreach ($categoriasTrabajo as $categoriaTrabajo){ // por cada categoria trabajo cargada en la bd
						$cantidadPreferenciasSeleccionadas = count($listaPreferenciasSeleccionadas); // obtenemos la cantidad de preferencias que cargo previamente
						$seleccionoPreferencia=false; // seteamos a falso
						$i=0; // inicializamos
						while ($seleccionoPreferencia!=true && $i<$cantidadPreferenciasSeleccionadas){
							$preferenciaActual=$listaPreferenciasSeleccionadas[$i]; // seteamos el obj de la categoria actual
							if ($categoriaTrabajo->idCategoriaTrabajo==$preferenciaActual->idCategoriaTrabajo){ // si coinciden seteamos a true. es para que no recorra de mas el arreglo
								$seleccionoPreferencia=true;
							};
							$i++;
						};
						if ($seleccionoPreferencia){ // si lo selecciono, asignamos checked
							echo '<input type="checkbox" id="preferenciaPersona" checked name="preferenciaPersona[]" value="' .$categoriaTrabajo->idCategoriaTrabajo.'">'.$categoriaTrabajo->nombreCategoriaTrabajo;
							echo '<br/>';
						} else {
							echo '<input type="checkbox" id="preferenciaPersona" name="preferenciaPersona[]" value="' .$categoriaTrabajo->idCategoriaTrabajo.'">'.$categoriaTrabajo->nombreCategoriaTrabajo;
							echo '<br/>';
						}
					};

				} else { // si ingresa aca es porque esta creando un perfil y nunca selecciono ninguna preferencia
					foreach ($categoriasTrabajo as $categoriaTrabajo){
						echo '<input type="checkbox" id="preferenciaPersona" name="preferenciaPersona[]" value="' .$categoriaTrabajo->idCategoriaTrabajo.'">'.$categoriaTrabajo->nombreCategoriaTrabajo;
					echo '<br/>';
					}
				}
			}
			@endphp
			</div>
			<span id="msgpreferenciaPersona" class="text-danger">{{ $errors->first('preferenciaPersona') }}</span>


		
			<br>
			<div class="row">
				<div class="col-xs-6 col-sm-4 col-md-4">
					<input id="borrarCampos" type="button"  value="Borrar" class="btn btn-primary btn-block inputBordes">
				</div>
				<div class="col-xs-6 col-sm-4 col-md-4">
					<input type="submit"  value="Guardar mis datos" class="btn btn-success btn-block inputBordes">
				</div>
			</div>
		</form>

		<script type="text/javascript">
        
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
					var data={nombrePersona:nombrePersona,apellidoPersona:apellidoPersona,dniPersona:dniPersona,telefonoPersona:telefonoPersona,imagenPersona:imagenPersona,idProvincia:idProvincia,idLocalidad:idLocalidad,habilidades:habilidades,preferenciaPersona:preferenciaPersona};
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': "{{ csrf_token() }}"
						},
						url: "@if($existePersona){{ route('persona.update') }}@else{{ route('persona.store') }}@endif",
						method: "POST",
						data:new FormData(this),
						dataType:'json',
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





