@extends('admin')
@section('content')
<div class="row">
	<section class="content">
		<div class="col-md-8 col-md-offset-2">
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
						<h3>Nueva Habilidad Persona</h3>
					</div>
					<div class="card-body">
						<form method="POST" action="{{ route('habilidadpersona.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
							<label for="idHabilidad">Habilidad:</label>
								<select class="form-control" name="idHabilidad" id="idHabilidad">
									@foreach($listaHabilidades as $habilidad)
										<option value="{{$habilidad->idHabilidad}}">
										{{$habilidad->idHabilidad." - ".$habilidad->nombreHabilidad}}</option>
									@endforeach
								</select>		
							</div>

							<div class="row">
								<label for="idPersona">Persona:</label>
								<select class="form-control" name="idPersona" id="idPersona">
									@foreach($listaPersonas as $persona)
										<option value="{{$persona->idPersona}}">
										{{$persona->idPersona." - ".$persona->nombrePersona." - ".$persona->apellidoPersona}}</option>
									@endforeach
								</select>
							</div>
							<br>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('habilidadpersona.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
<<<<<<< Updated upstream
=======
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
>>>>>>> Stashed changes
	</section>
	@endsection


