@extends('layouts.layout')
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
 
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Nueva Localidad</h3>
				</div>
				<div class="panel-body">					
					<div class="table-container">
						<form method="POST" action="{{ route('localidad.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Nombre localidad:</label><br>
										<input type="text" name="nombreLocalidad" id="nombreLocalidad" class="form-control input-sm">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Codigo Postal:</label><br>
										<input type="number" name="codigoPostal" id="codigoPostal" class="form-control input-sm">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<label for="idProvincia">Provincia:</label>
									<select class="form-control" name="idProvincia" id="idProvincia">
										@foreach($provincias as $unaProvincia)
											<option value="{{$unaProvincia->idProvincia}}">
												{{$unaProvincia->nombreProvincia}}</option>
										@endforeach
									</select>
								</div>
							</div><br>				
							<div class="row">
 
								<div class="col-xs-6 col-sm-6 col-md-6">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('localidad.index') }}" class="btn btn-info btn-block" >Atrás</a>
								</div>	
 
							</div>
						</form>
					</div>
				</div>
 
			</div>
		</div>
	</section>
	@endsection

	
