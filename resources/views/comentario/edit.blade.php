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
					<h3>Editar Comentario</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formComentario" name="formComentario" action="{{ route('comentario.update',$comentario->idComentario) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						
						<input type="hidden" id="idComentario" name="idComentario" value={{$comentario->idComentario}}>
						<div class="row">
							<label for="idPersona">Persona:</label>
							<select class="form-control" name="idPersona" id="idPersona">
								<option value="" selected disabled>Seleccione una persona </option>
								@foreach($listaPersonas as $persona)
									<option value="{{$persona->idPersona}}"
										@if($comentario->persona->idPersona == $persona->idPersona){
											selected
											}
										@endif>
										{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<label for="idTrabajo">Trabajo:</label>
							<select class="form-control" name="idTrabajo" id="idTrabajo">
							<option value="" selected disabled>Seleccione un trabajo </option>
								@foreach($listaTrabajos as $trabajo)
									<option value="{{$trabajo->idTrabajo}}"
										@if($comentario->trabajo->idTrabajo == $trabajo->idTrabajo){
											selected
											}
										@endif>
										{{$trabajo->idTrabajo." - ".$trabajo->titulo}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<label for="idComentarioPadre">Comentario Padre:</label>
							<select class="form-control" name="idComentarioPadre" id="idComentarioPadre">
							<option value="" selected disabled>Comentario padre </option>
								@foreach($listaComentarios as $objComentario)
									<option value="{{$objComentario->idComentario}}"
										@if($comentario->idComentarioPadre == $objComentario->idComentario){
											selected
											}
										@endif>
										{{$objComentario->idComentario}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Contenido:</label><br>
								<input type="text" name="contenido" id="contenido" class="form-control input-sm" value="{{$comentario->contenido}}">
							</div>
						</div>

						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('comentario.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
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