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
				<h3>Editar Trabajo</h3>
			</div>
                
			<div class="card-body">
				<form method="POST" id="formTrabajo" name="formTrabajo" action="{{ route('trabajo.updatepanel',$trabajo->idTrabajo) }}"  role="form">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="PATCH">
                    <div class="row">
						<label for="idEstado">Estado:</label>
						<select class="form-control" name="idEstado" id="idEstado">
							@foreach($listaEstados as $estado)
								<option value="{{$estado->idEstado}}"
									@if($trabajo->idEstado == $estado->idEstado){
										selected
										}
									@endif>
									{{$estado->idEstado." - ".$estado->nombreEstado}}
								</option>
							@endforeach
						</select>
					</div>

					<div class="row">
						<label for="idCategoriaTrabajo">Categoria:</label>
						<select class="form-control" name="idCategoriaTrabajo" id="idCategoriaTrabajo">
							@foreach($listaCategorias as $categoria)
								<option value="{{$categoria->idCategoriaTrabajo}}"
									@if($trabajo->idCategoriaTrabajo == $categoria->idCategoriaTrabajo){
										selected
										}
									@endif>
									{{$categoria->idCategoriaTrabajo." - ".$categoria->nombreCategoriaTrabajo}}
								</option>
							@endforeach
						</select>
					</div>

					<div class="row">
						<label for="idPersona">Persona:</label>
						<select class="form-control" name="idPersona" id="idPersona">
							@foreach($listaPersonas as $persona)
								<option value="{{$persona->idPersona}}"
									@if($trabajo->idPersona == $persona->idPersona){
										selected
										}
									@endif>
									{{$persona->idPersona." - ".$persona->nombrePersona." ".$persona->apellidoPersona}}
								</option>
							@endforeach
						</select>
					</div>

					<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 inputSelect">
								<label for="idProvincia">PROVINCIA</label>
									<select class="form-control" name="idProvincia" id="idProvincia" style="color: #1e1e27" required>
									@foreach ($listaProvincias as $provincia)
										<option value="{{$provincia->idProvincia}}"
											@if($provincia->idProvincia == $trabajo->persona->localidad->idProvincia)
												selected
											@endif
														
													
										>{{$provincia->nombreProvincia}}</option>
										@endforeach
								</select>
								<span id="msgidProvincia" class="text-danger">{{ $errors->first('idProvincia') }}</span>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 inputSelect">
								<label for="idLocalidad" class="control-label">LOCALIDAD</label>
								<select name="idLocalidad" id="idLocalidad" class="form-control" style="color: #1e1e27" required>
									<option value="">Seleccione una opcion</option>
								</select>
								<span id="msgidLocalidad" class="text-danger">{{ $errors->first('idLocalidad') }}</span>
							</div>
						</div>

					<br/>
					<div class="row">
						<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
						<a href="{{ route('trabajo.indexpanel') }}" class="btn btn-info btn-block" >Atrás</a>
					</div>
		    	</form>
			</div>
		
		</div>





    </section>
@endsection