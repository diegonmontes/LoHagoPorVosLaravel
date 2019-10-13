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
					<form method="POST" action="{{ route('categoriatrabajo.update',$categoriaTrabajo->idCategoriaTrabajo) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						<div class="row">
							<div class="form-group">
								<label>Nombre:</label><br>
								<input type="text" name="nombreCategoriaTrabajo" id="nombreCategoriaTrabajo" class="form-control input-sm" value="{{$categoriaTrabajo->nombreCategoriaTrabajo}}">
							</div>
						</div>
						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('categoriatrabajo.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
	</section>
	@endsection