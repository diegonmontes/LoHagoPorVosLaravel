@extends('admin')
@section('jsHead')
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
					<h3>Editar Valoracion</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formValoracion" enctype="multipart/form-data" name="formValoracion" action="{{ route('valoracion.update',$valoracion->idValoracion) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">

						<div class="row">
							<label for="idTrabajo">Trabajo:</label>
							<select class="form-control" name="idTrabajo" id="idTrabajo">
							<option value="" selected disabled>Seleccione un trabajo</option>
								@foreach($listaTrabajos as $trabajo)
									<option value="{{$trabajo->idTrabajo}}"
										@if($valoracion->trabajo->idTrabajo == $trabajo->idTrabajo){
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
										@if($valoracion->persona->idPersona == $persona->idPersona){
											selected
											}
										@endif>
										{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Valor</label><br>
								<input type="text" name="valor" id="valor" class="form-control input-sm" value="{{$valoracion->valor}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Comentario</label><br>
								<input type="text" name="comentarioValoracion" id="comentarioValoracion" class="form-control input-sm" value="{{$valoracion->comentarioValoracion}}">
							</div>
						</div>
						<label>Imagen Valoraci&oacute;n</label>
						<div class="row">
								<div class="drag-drop-imagenTrabajo imagenTrabajo">
									<input type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenValoracion" />
									<output id="thumbnil" class="preview-imagenTrabajo">
										<img  class="preview-imagenTrabajo" src="
												@if($valoracion->imagenValoracion != null)
													{{ asset('storage/valoracion/'.$valoracion->imagenValoracion)}}
												@else{{asset('images/fotoPerfil.png')}}@endif
										">
									</output>
								</div>
						</div>


						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('valoracion.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
			<script>
				$("#formValoracion").validate({
					rules: {
						idTrabajo: {
							required: true,
							digits: true,
						},
						valor: {
							required: true,
							maxlength: 1,
							max:5,
							min:1,
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
						valor: {
							required: "Por favor ingrese un valor",
							min: "El valor m&iacute;nimo que puede ingresar es 1",
							max: "El valor m&aacute;ximo que puede ingresar es 5",
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