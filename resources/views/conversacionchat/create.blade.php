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
						<h3>Nueva Conversacion</h3>
					</div>
					<div class="card-body">
						<form method="POST" id="formConversacionChat" name="formConversacionChat" action="{{ route('conversacionchat.store') }}"  role="form">
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
								<label for="idPersona1">Persona 1:</label>
								<select class="form-control" name="idPersona1" id="idPersona1">
								<option value="" selected disabled>Seleccione una persona</option>
									@foreach($listaPersonas as $persona)
										<option value="{{$persona->idPersona}}">
										{{$persona->idPersona." - ".$persona->nombrePersona." - ".$persona->apellidoPersona}}</option>
									@endforeach
								</select>
							</div>

							<div class="row">
								<label for="idPersona2">Persona 2:</label>
									<select class="form-control" name="idPersona2" id="idPersona2">
									<option value="" selected disabled>Seleccione una persona</option>
										@foreach($listaPersonas as $persona)
											<option value="{{$persona->idPersona}}">
											{{$persona->idPersona." - ".$persona->nombrePersona." - ".$persona->apellidoPersona}}</option>
										@endforeach
									</select>
							</div>

							


							<br>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('conversacionchat.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
		<script>
			$.validator.addMethod("distintasPersonas", function(value, element) {
				return $('#idPersona1').val() != $('#idPersona2').val()
				}, "Debe seleccionar otra persona. No pueden ser las mismas.");

			$("#formConversacionChat").validate({
				rules: {
					idTrabajo: {
						required: true,
						digits: true
					},
					idPersona1: {
						required: true,
						digits: true,
						distintasPersonas: true,
					},
					idPersona2: {
						required: true,
						digits: true,
						distintasPersonas: true,				
					},
				},
				messages: {
					idTrabajo: {
						required: "Por favor seleccione un trabajo",
					},
					idPersona1: {
						required: "Por favor seleccione una persona",
					},
					idPersona2: {
						required: "Por favor seleccione una persona",
					},
				}
			});
		</script>
	</section>
	@endsection


