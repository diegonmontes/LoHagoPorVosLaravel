@extends('layouts.layout')
@section('content')
	<section class="content">
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
				<div class="col-xs-6 col-sm-6 col-md-3">
					<div class="form-group">
						<label>Nombre:</label><br>
						<input type="text" name="nombrePersona" id="nombrePersona" class="form-control input-sm">
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-3">
					<div class="form-group">
						<label>Apellido:</label><br>
						<input type="text" name="apellidoPersona" id="apellidoPersona" class="form-control input-sm">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-3">
					<div class="form-group">
						<label>DNI:</label><br>
						<input type="text" name="dniPersona" id="dniPersona" class="form-control input-sm">
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-3">
					<div class="form-group">
						<label>Telefono:</label><br>
						<input type="text" name="telefonoPersona" id="telefonoPersona" class="form-control input-sm">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-3">
					<label for="idProvincia">Provincia:</label>
						<select class="form-control" name="idProvincia" id="idProvincia">
						@foreach ($provincias as $unaProvincia)
							<option value="{{$unaProvincia->idProvincia}}"
								@if($unaProvincia->idProvincia == 20)
									selected
								@endif>
							{{$unaProvincia->nombreProvincia}}</option>
							@endforeach
					</select>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-3">
					<label for="idLocalidad" class="control-label">Localidad:</label>
					<select name="idLocalidad" id="idLocalidad" class="form-control">
							<option value="">Seleccione una opcion</option>
						</select>
				</div>
			</div>
			<br>				
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6">
					<input type="submit"  value="Guardar" class="btn btn-success btn-block">
				</div>	
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6">
					<a href="{{ route('home') }}" class="btn btn-info btn-block" >Atrás</a>
				</div>	
			</div>
		</form>		 
	</section>
@endsection


		  

	
