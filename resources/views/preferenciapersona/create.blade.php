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
						<h3>Nueva Preferencia Persona</h3>
					</div>
					<div class="card-body">
						<form method="POST" id="formPreferenciaPersona" name="formPreferenciaPersona" action="{{ route('preferenciapersona.store') }}"  role="form">
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
							<label for="idCategoriaTrabajo">Categoria Trabajo:</label>
								<select class="form-control" name="idCategoriaTrabajo" id="idCategoriaTrabajo">
								<option value="" selected disabled>Seleccione una categor&iacute;a </option>
									@foreach($listaCategorias as $categoria)
										<option value="{{$categoria->idCategoriaTrabajo}}">
										{{$categoria->idCategoriaTrabajo." - ".$categoria->nombreCategoriaTrabajo}}</option>
									@endforeach
								</select>
							</div>
							<br>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('preferenciapersona.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

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
						required: "Por favor seleccione una categor&iacute;a",
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


