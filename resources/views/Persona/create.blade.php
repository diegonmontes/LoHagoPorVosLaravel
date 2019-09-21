@extends('layouts.layout')
@section('content')
    <br>
    <br>
	<section class="content" style="margin-left: 5%; margin-right: 5%;">
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
		<form method="GET" action="{{ route('persona.store') }}"  role="form">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<label>NOMBRE</label><br>
						<input type="text" name="nombrePersona" id="nombrePersona" class="form-control input-sm">
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<label>APELLIDO</label><br>
						<input type="text" name="apellidoPersona" id="apellidoPersona" class="form-control input-sm">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<label>DNI</label><br>
						<input type="text" name="dniPersona" id="dniPersona" class="form-control input-sm">
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<label>TELEFONO</label><br>
						<input type="text" name="telefonoPersona" id="telefonoPersona" class="form-control input-sm">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<label for="idProvincia">PROVINCIA</label>
						<select class="form-control" name="idProvincia" id="idProvincia" style="color: #1e1e27">
						@foreach ($provincias as $unaProvincia)
							<option value="{{$unaProvincia->idProvincia}}"
								@if($unaProvincia->idProvincia == 20)
									selected
								@endif>
							{{$unaProvincia->nombreProvincia}}</option>
							@endforeach
					</select>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<label for="idLocalidad" class="control-label">LOCALIDAD</label>
					<select name="idLocalidad" id="idLocalidad" class="form-control" style="color: #1e1e27">
							<option value="">Seleccione una opcion</option>
						</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<input type="submit"  value="Guardar mis datos" class="btn btn-success btn-block">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<a href="{{ route('home') }}" class="btn btn-info btn-block" >Atrás</a>
				</div>
			</div>
		</form>
        </div>
    </section>
@endsection





