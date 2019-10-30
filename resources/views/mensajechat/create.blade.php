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
						<h3>Nuevo Mensaje</h3>
					</div>
					<div class="card-body">
						<form method="POST" action="{{ route('mensajechat.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
								<label for="idConversacionChat">Conversacion:</label>
								<select class="form-control" name="idConversacionChat" id="idConversacionChat">
									@foreach($listaConversaciones as $conversacion)
										<option value="{{$conversacion->idConversacionChat}}">
										{{$conversacion->idConversacionChat}}</option>
									@endforeach
								</select>
							</div>

							<div class="row">
								<label for="idPersona">Persona:</label>
								<select class="form-control" name="idPersona" id="idPersona">
									@foreach($listaPersonas as $persona)
										<option value="{{$persona->idPersona}}">
										{{$persona->idPersona." - ".$persona->nombrePersona." - ".$persona->apellidoPersona}}</option>
									@endforeach
								</select>

							</div>

							<div class="row">
								<div class="form-group">
									<label>Mensaje:</label>
									<input type="text" name="mensaje" id="mensaje" class="form-control input-sm">
								</div>
							</div>


							<br>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('mensajechat.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</section>
	@endsection

