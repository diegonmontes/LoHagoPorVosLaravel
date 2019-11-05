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
						<h3>Nuevo Comentario</h3>
					</div>
					<div class="card-body">
						<form method="POST" id="formComentario" name="formComentario" action="{{ route('comentario.store') }}"  role="form">
							{{ csrf_field() }}

							<div class="row">
								<label for="idPersona">Persona:</label>
								<select class="form-control" name="idPersona" id="idPersona">
								<option value="" selected disabled>Seleccione una persona </option>
									@foreach($listaPersonas as $persona)
										<option value="{{$persona->idPersona}}">
										{{$persona->idPersona." - ".$persona->nombrePersona." - ".$persona->apellidoPersona}}</option>
									@endforeach
								</select>
							</div>

							<div class="row">
								<label for="idTrabajo">Trabajo:</label>
								<select class="form-control" name="idTrabajo" id="idTrabajo">
								<option value="" selected disabled>Seleccione un trabajo</option>
									@foreach($listaTrabajos as $trabajo)
										<option value="{{$trabajo->idTrabajo}}">
										{{$trabajo->idTrabajo." - ".$trabajo->titulo}}</option>
									@endforeach
								</select>		
							</div>

							<div class="row">
								<label for="idComentarioPadre">Comentario Padre:</label>
								<select class="form-control" name="idComentarioPadre" id="idComentarioPadre">
								<option value="" selected disabled>Menu Padre</option>
									@foreach($listaComentarios as $comentario)
										<option value="{{$comentario->idComentario}}">
										{{$comentario->idComentario}}</option>
									@endforeach
								</select>		
							</div>

							<div class="row">
								<div class="form-group">
									<label>Contenido:</label>
									<input type="text" name="contenido" id="contenido" class="form-control input-sm">
								</div>
							</div>


							<br>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('mensajechat.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
		<script>
			$("#formComentario").validate({
					rules: {
						idTrabajo: {
							required: true,
							digits: true,
						},
						contenido: {
							required: true,
							maxlength: 255,
						},
						idPersona:{
							required:true,
							digits: true,
						}
					},
					messages: {
						idTrabajo: {
							required: "Por favor seleccione un trabajo",
							digits: "El trabajo seleccionado es incorrecto",
						},
						contenido: {
							required: "Por favor ingrese un contenido",
							maxlength: "M&aacute;ximo de letras sobrepasado",
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


