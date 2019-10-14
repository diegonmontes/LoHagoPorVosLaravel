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
				<h3>Editar Localidad</h3>
			</div>
			<div class="card-body">
				<form method="POST" action="{{ route('localidad.update',$localidad->idLocalidad) }}"  role="form">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="PATCH">
					<div class="row">
						<div class="form-group">
							<label>Nombre Localidad:</label>
							<input type="text" name="nombreLocalidad" id="nombreLocalidad" class="form-control input-sm" value="{{$localidad->nombreLocalidad}}">
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label>Codigo Postal:</label>
							<input type="number" name="codigoPostal" id="codigoPostal" class="form-control input-sm" value="{{$localidad->codigoPostal}}">
						</div>
					</div>
					<div class="row">
						<label for="idProvincia">Provincia:</label>
						<select class="form-control" name="idProvincia" id="idProvincia">
							@foreach($provincias as $unaProvincia)
								<option value="{{$unaProvincia->idProvincia}}"
									@if($localidad->provincia->idProvincia == $unaProvincia->idProvincia){
										selected
										}
									@endif>
									{{$unaProvincia->nombreProvincia}}
								</option>
							@endforeach
						</select>
					</div>
					<br>
					<div class="row">
						<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
						<a href="{{ route('localidad.index') }}" class="btn btn-info btn-block" >Atrás</a>
					</div>	
				</form>
			</div>
		</div>
	</section>
</div>
@endsection