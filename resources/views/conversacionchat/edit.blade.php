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
					<h3>Editar Conversacion</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formConversacionChat" name="formConversacionChat" action="{{ route('conversacionchat.update',$conversacion->idConversacionChat) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						<input type="hidden" name="idTrabajo" id="idTrabajo"value="{{$conversacion->trabajo->idTrabajo}}">

						<div class="row">
							<label for="idTrabajo">Trabajo:</label>
							<select class="form-control" name="idTrabajo" id="idTrabajo">
								@foreach($listaTrabajos as $trabajo)
									<option value="{{$trabajo->idTrabajo}}"
										@if($conversacion->trabajo->idTrabajo == $trabajo->idTrabajo){
											selected
											}
										@endif>
										{{$trabajo->idTrabajo." - ".$trabajo->titulo}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<label for="idPersona1">Persona 1:</label>
							<select class="form-control" name="idPersona1" id="idPersona1">
								@foreach($listaPersonas as $persona)
									<option value="{{$persona->idPersona}}"
										@if($conversacion->persona1->idPersona == $persona->idPersona){
											selected
											}
										@endif>
										{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<label for="idPersona2">Persona 2:</label>
							<select class="form-control" name="idPersona2" id="idPersona2">
								@foreach($listaPersonas as $persona)
									<option value="{{$persona->idPersona}}"
										@if($conversacion->persona2->idPersona == $persona->idPersona){
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
							<a href="{{ route('conversacionchat.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
			<script>
			$.validator.addMethod("distintasPersonas", function(value, element) {
				return $('#idPersona1').val() != $('#idPersona2').val()
				}, "Debe seleccionar otra persona. No pueden coincidir");

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
						required: "Por favor ingrese el nombre del estado",
					},
					idPersona1: {
						required: "Por favor ingrese una persona",
					},
					idPersona2: {
						required: "Por favor ingrese una persona",
					},
				}
			});
		</script>
	</section>
	@endsection