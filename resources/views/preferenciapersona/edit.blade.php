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
					<h3>Editar Preferencia Persona</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formPreferenciaPersona" name="formPreferenciaPersona" action="{{ route('preferenciapersona.update',$preferenciaPersona->idPreferenciaPersona) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						<div class="row">
							<label for="idPersona">Persona:</label>
							<select class="form-control" name="idPersona" id="idPersona">
								@foreach($listaPersonas as $persona)
									<option value="{{$persona->idPersona}}"
										@if($preferenciaPersona->persona->idPersona == $persona->idPersona){
											selected
											}
										@endif>
										{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}
									</option>
								@endforeach
							</select>
						</div>
						<div class="row">
							<label for="idCategoriaTrabajo">Categoria Trabajo:</label>
							<select class="form-control" name="idCategoriaTrabajo" id="idCategoriaTrabajo">
								@foreach($listaCategorias as $categoria)
									<option value="{{$categoria->idCategoriaTrabajo}}"
										@if($preferenciaPersona->categoriaTrabajo->idCategoriaTrabajo == $categoria->idCategoriaTrabajo){
											selected
											}
										@endif>
										{{$categoria->idCategoriaTrabajo." - ".$categoria->nombreCategoriaTrabajo}}
									</option>
								@endforeach
							</select>
						</div>
						<br/>
						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('preferenciapersona.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
			<script>
			$("#formPreferenciaPersona").validate({
				rules: {
					idCategoriaTrabajo: {
						required: true,
						digits: true
					},
					idPersona: {
						required: true,
						digits: true,
					},
				},
				messages: {
					idCategoriaTrabajo: {
						required: "Por favor seleccione una categoria",
						digits: "La categoria seleccionada es incorrecta",
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