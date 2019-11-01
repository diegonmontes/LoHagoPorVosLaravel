@extends('admin')
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
					<h3>Editar Habilidad Persona</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formHabilidadPersona" name="formHabilidadPersona" action="{{ route('habilidadpersona.update',$habilidadPersona->idHabilidadPersona) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						
						<div class="row">
							<label for="idHabilidad">Habilidad:</label>
							<select class="form-control" name="idHabilidad" id="idHabilidad">
								@foreach($listaHabilidades as $habilidad)
									<option value="{{$habilidad->idHabilidad}}"
										@if($habilidadPersona->habilidad->idHabilidad == $habilidad->idHabilidad){
											selected
											}
										@endif>
										{{$habilidad->idHabilidad." - ".$habilidad->nombreHabilidad}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<label for="idPersona">Persona:</label>
							<select class="form-control" name="idPersona" id="idPersona">
								@foreach($listaPersonas as $persona)
									<option value="{{$persona->idPersona}}"
										@if($habilidadPersona->persona->idPersona == $persona->idPersona){
											selected
											}
										@endif>
										{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}
									</option>
								@endforeach
							</select>
						</div>


						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('habilidadpersona.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>

			<script>
			$("#formHabilidadPersona").validate({
				rules: {
					idHabilidad: {
						required: true,
						digits: true
					},
					idPersona: {
						required: true,
						digits: true,
					},
				},
				messages: {
					idHabilidad: {
						required: "Por favor seleccione una habilidad",
						digits: "La habilidad seleccionada es incorrecta",
					},
					idPersona: {
						required: "Por favor seleccione una persona",
						digits: "La persona seleccionada es incorrecta",
					},
				}
			});
		</script>

	</section>
	@endsection