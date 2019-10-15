@extends('layouts.layout')
@section('content')
  	<section class="container">
        <div class="row justify-content-center">
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
		<form method="post" enctype="multipart/form-data" action="@if($existePersona){{ route('persona.update') }}@else{{ route('persona.store') }}@endif"  role="form" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="row">
				<div class="drag-drop">
					<input type="file" id="files" name="imagenPersona" />
					<output id="list" class="preview" style="z-index: -10"></output>
					<span class="desc">Pulse aquí para añadir archivos</span>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-6 col-sm-4 col-md-4">
					<div class="form-group">
						<label>NOMBRE</label><br>
						<input type="text" name="nombrePersona" id="nombrePersona" class="form-control input-sm inputBordes" style="color: #1e1e27" value="@if($existePersona){{ $persona->nombrePersona }}@endif">
					</div>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-4">
					<div class="form-group">
						<label>APELLIDO</label><br>
						<input type="text" name="apellidoPersona" id="apellidoPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" value="@if($existePersona){{ $persona->apellidoPersona }}@endif">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-4 col-md-4">
					<div class="form-group">
						<label>DNI</label><br>
						<input type="text" name="dniPersona" id="dniPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" value="@if($existePersona){{ $persona->dniPersona }}@endif">
					</div>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-4">
					<div class="form-group">
						<label>TELEFONO</label><br>
						<input type="text" name="telefonoPersona" id="telefonoPersona" class="form-control input-sm inputBordes" style="color: #1e1e27" value="@if($existePersona){{ $persona->telefonoPersona }}@endif">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-4 col-md-4">
					<label for="idProvincia">PROVINCIA</label>
						<select class="form-control inputSelect" name="idProvincia" id="idProvincia" style="color: #1e1e27">
						@foreach ($provincias as $unaProvincia)
							<option value="{{$unaProvincia->idProvincia}}"
									@if($existePersona)
										@if($unaProvincia->idProvincia == $persona->idLocalidad)
											selected
										@endif
									@else
										@if($unaProvincia->idProvincia == 20)
											selected
										@endif
									@endif
							>{{$unaProvincia->nombreProvincia}}</option>
							@endforeach
					</select>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-4">
					<label for="idLocalidad" class="control-label">LOCALIDAD</label>
					<select name="idLocalidad" id="idLocalidad" class="form-control inputSelect" style="color: #1e1e27">
						<option value="">Seleccione una opcion</option>
					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-6 col-sm-4 col-md-4">
					<input id="borrarCampos" type="button"  value="Borrar" class="btn btn-primary btn-block inputBordes">
				</div>
				<div class="col-xs-6 col-sm-4 col-md-4">
					<input type="submit"  value="Guardar mis datos" class="btn btn-success btn-block inputBordes">
				</div>
			</div>
		</form>
		<img src="/storage/4fotoperfil20191009221052.png" alt="image">
    </section>
@endsection





