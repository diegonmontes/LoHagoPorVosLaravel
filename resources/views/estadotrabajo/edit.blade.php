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
					<h3>Editar un estado a un trabajo</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formEstadoTrabajo" name="formEstadoTrabajo" action="{{ route('estadotrabajo.update',$estadoTrabajo->idEstadoTrabajo) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						
						<div class="row">
							<label for="idTrabajo">Trabajo:</label>
							<select class="form-control" name="idTrabajo" id="idTrabajo">
								<option value="" selected disabled>Seleccione un trabajo</option>
								@foreach($listaTrabajos as $trabajo)
									<option value="{{$trabajo->idTrabajo}}"
										@if($estadoTrabajo->trabajo->idTrabajo == $trabajo->idTrabajo){
											selected
											}
										@endif>
										{{$trabajo->idTrabajo." - ".$trabajo->titulo}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<label for="idEstado">Estado:</label>
							<select class="form-control" name="idEstado" id="idEstado">
							<option value="" selected disabled>Seleccione un estado</option>
								@foreach($listaEstados as $estado)
									<option value="{{$estado->idEstado}}"
										@if($estadoTrabajo->estado->idEstado == $estado->idEstado){
											selected
											}
										@endif>
										{{$estado->idEstado." - ".$estado->nombreEstado}}
									</option>
								@endforeach
							</select>
						</div>

						<br/>

						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('estadotrabajo.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
			<script>
			$("#formEstadoTrabajo").validate({
				rules: {
					idTrabajo: {
						required: true,
						digits: true
					},
					idEstado: {
						required: true,
						digits: true,
					},
				},
				messages: {
					idTrabajo: {
						required: "Por favor seleccione un trabajo",
						digits: "El trabajo seleccionado es incorrecto",
					},
					idEstado: {
						required: "Por favor seleccione un estado",
						digits: "El estado seleccionado es incorrecto",
					},
				}
			});
		</script>
	</section>
	@endsection