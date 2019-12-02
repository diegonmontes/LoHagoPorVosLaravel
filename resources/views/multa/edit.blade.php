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
					<h3>Editar mULTA</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formMulta" name="formMulta" action="{{ route('multa.update',$multa->idMulta) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">

						<div class="row">
							<label for="idTrabajo">Trabajo:</label>
							<select class="form-control" name="idTrabajo" id="idTrabajo">
							<option value="" selected disabled>Seleccione un trabajo</option>
								@foreach($listaTrabajos as $trabajo)
									<option value="{{$trabajo->idTrabajo}}"
										@if($multa->trabajo->idTrabajo == $trabajo->idTrabajo){
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
										@if($multa->persona->idPersona == $persona->idPersona){
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
								<label>Motivo</label><br>
								<input type="text" name="motivo" id="motivo" class="form-control input-sm" value="{{$multa->motivo}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Valor</label><br>
								<input type="text" name="valor" id="valor" class="form-control input-sm" value="{{$multa->valor}}">
							</div>
						</div>

						
						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('multa.indexpanel') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
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