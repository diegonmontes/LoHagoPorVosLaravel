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
					<h3>Editar aspirante a un trabajo</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formTrabajoAspirante" name="formTrabajoAspirante" action="{{ route('trabajoaspirante.update',$trabajoAspirante->idTrabajoAspirante) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">

						<div class="row">
							<label for="idTrabajo">Trabajo:</label>
							<select class="form-control" name="idTrabajo" id="idTrabajo">
							<option value="" selected disabled>Seleccione un trabajo</option>

								@foreach($listaTrabajos as $trabajo)
									<option value="{{$trabajo->idTrabajo}}"
										@if($trabajoAspirante->trabajo->idTrabajo == $trabajo->idTrabajo){
											selected
											}
										@endif>
										{{$trabajo->idTrabajo." - ".$trabajo->titulo}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<label for="idPersona">Persona:</label>
							<select class="form-control" name="idPersona" id="idPersona">
							<option value="" selected disabled>Seleccione una persona</option>
								@foreach($listaPersonas as $persona)
									<option value="{{$persona->idPersona}}"
										@if($trabajoAspirante->persona->idPersona == $persona->idPersona){
											selected
											}
										@endif>
										{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}
									</option>
								@endforeach
							</select>
						</div>

						
						<br/>
						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('trabajoaspirante.indexpanel') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
			<script>
			$("#formTrabajoAspirante").validate({
				rules: {
					idTrabajo: {
						required: true,
						digits: true
					},
					idPersona: {
						required: true,
						digits: true,
						distintasPersonas: true,
					},
				},
				messages: {
					idTrabajo: {
						required: "Por favor seleccione un trabajo",
					},
					idPersona: {
						required: "Por favor seleccione una persona",
					},
				}
			});
		</script>
	</section>
	@endsection