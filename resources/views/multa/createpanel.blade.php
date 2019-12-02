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
						<h3>Nueva Multa</h3>
					</div>
					<div class="card-body">
						<form method="POST" id="formMulta" name="formMulta" action="{{ route('multa.storepanel') }}"  role="form">
							{{ csrf_field() }}
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
								<label for="idPersona">Persona:</label>
								<select class="form-control" name="idPersona" id="idPersona">
								<option value="" selected disabled>Seleccione una persona</option>
									@foreach($listaPersonas as $persona)
										<option value="{{$persona->idPersona}}">
										{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}</option>
									@endforeach
								</select>
							</div>
							<div class="row">
								<div class="form-group">
									<label>Valor:</label>
									<input type="text" name="valor" id="valor" class="form-control input-sm">
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<label>Motivo:</label>
									<input type="text" name="motivo" id="motivo" class="form-control input-sm">
								</div>
							</div>
							<br>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('multa.indexpanel') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
		<script>
			
			$("#formMulta").validate({
				rules: {
					idTrabajo: {
						required: true,
						digits: true
					},
					idPersona: {
						required: true,
						digits: true,
					},
					motivo: {
							required: true,
							minlength: 1,
							maxlength: 511,
						},
					valor: {
						required: true,
						minlength: 1,
						maxlength: 511,
					},
					
				},
				messages: {
					idTrabajo: {
						required: "Por favor seleccione un trabajo",
					},
					idPersona: {
						required: "Por favor seleccione una persona",
					},	
					motivo: {
						required: "Por favor ingrese un motivo",
						minlength: "El m&iacute;nimo de letras que debe ingresar es 1",
						maxlength: "M&aacute;ximo de letras sobrepasado",
					},
					valor: {
						required: "Por favor ingrese un valor",
						minlength: "El m&iacute;nimo de letras que debe ingresar es 1",
						maxlength: "M&aacute;ximo de letras sobrepasado",
					},
				}
			});
		</script>
	</section>
	@endsection


