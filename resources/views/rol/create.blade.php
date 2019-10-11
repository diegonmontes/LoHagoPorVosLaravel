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
						<h3>Nuevo Rol</h3>
					</div>
					<div class="card-body">
						<form method="POST" action="{{ route('rol.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
									<div class="form-group">
										<label>Nombre:</label><br>
										<input type="text" name="nombreRol" id="nombreRol" class="form-control input-sm">
									</div>
								</div>
							<div class="row">
								<div class="form-group">
									<label>Descripcion:</label><br>
									<input type="text" name="descripcionRol" id="descripcionRol" class="form-control input-sm">
								</div>
							</div>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('rol.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</section>
	@endsection

