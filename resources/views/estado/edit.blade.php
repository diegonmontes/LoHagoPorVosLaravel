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
					<h3>Editar categoria</h3>
				</div>
				<div class="card-body">
					<form method="POST" action="{{ route('estado.update',$estado->idEstado) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						<div class="row">
							<div class="form-group">
								<label>Estado:</label><br>
								<input type="text" name="nombreEstado" id="nombreEstado" class="form-control input-sm" value="{{$estado->nombreEstado}}">
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label>Descripcion:</label><br>
								<input type="text" name="descripcionEstado" id="descripcionEstado" class="form-control input-sm" value="{{$estado->descripcionEstado}}">
							</div>
						</div>
						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('estado.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
	</section>
	@endsection