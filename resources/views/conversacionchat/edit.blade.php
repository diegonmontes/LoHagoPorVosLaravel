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
					<h3>Editar Conversacion</h3>
				</div>
				<div class="card-body">
					<form method="POST" action="{{ route('conversacionchat.update',$conversacion->idConversacionChat) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						<input type="hidden" name="idTrabajo" id="idTrabajo"value="{{$conversacion->trabajo->idTrabajo}}">

						<div class="row">
							<div class="form-group">
								<label>Persona 1:</label><br>
								<input type="text" name="idPersona1" id="idPersona1" class="form-control input-sm" value="{{$conversacion->persona1->idPersona1}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Persona 2:</label><br>
								<input type="text" name="idPersona2" id="idPersona2" class="form-control input-sm" value="{{$conversacion->persona2->idPersona2}}">
							</div>
						</div>

						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('conversacionchat.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
	</section>
	@endsection