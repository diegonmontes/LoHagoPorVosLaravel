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
					<h3>Editar Mensaje</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formUsuario" name="formUsuario" action="{{ route('usuario.update',$usuario->idUsuario) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						

						<div class="row">
							<label for="idRol">ID Rol:</label>
							<select class="form-control" name="idRol" id="idRol">
								@foreach($listaRoles as $rol)
									<option value="{{$rol->idRol}}"
										@if($usuario->rol->idRol == $rol->idRol){
											selected
											}
										@endif>
										{{$rol->idRol."- ".$rol->nombreRol}}
									</option>
								@endforeach
							</select>
						</div>

						
						<div class="row">
							<div class="form-group">
								<label>Nombre de usuario:</label><br>
								<input type="text" name="nombreUsuario" id="nombreUsuario" class="form-control input-sm" value="{{$usuario->nombreUsuario}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Mail:</label><br>
								<input type="text" name="mailUsuario" id="mailUsuario" class="form-control input-sm" value="{{$usuario->mailUsuario}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Clave:</label><br>
								<input type="text" name="claveUsuario" id="claveUsuario" class="form-control input-sm" value="{{$usuario->claveUsuario}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Auth Key:</label><br>
								<input type="text" name="auth_key" id="auth_key" class="form-control input-sm" value="{{$usuario->auth_key}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Mail verificado:</label><br>
								<input type="text"  id="datepickerMail"  class="form-control inputBordes" style="background-color: #fff;" value="{{$usuario->email_verified_at}}" readonly>
                                <input type="text" id="datepickerMailAlt" name="email_verified_at" class="datepicker-picker" >

							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Remember token:</label><br>
								<input type="text" name="remember_token" id="remember_token" class="form-control input-sm" value="{{$usuario->remember_token}}">
							</div>
						</div>

						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('usuario.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
			<script type="text/javascript">
				$('#datepickerMail').datetimepicker({
					altField: "#datepickerMailAlt",
					altFieldTimeOnly: false,
					altFormat: "yy-mm-dd",
					controlType: 'select',
					oneLine: true,
					altTimeFormat: "H:m",
					dateFormat: "yy-mm-dd",
					timeFormat: "HH:mm:ss",
					minDate: 0
				});   
			</script>
			<script>
		jQuery.validator.addMethod("lettersonly", function(value, element) {
				return this.optional(element) || /^[a-z]+$/i.test(value);
			}, "Solo puede ingresar letras");
			
			$("#formUsuario").validate({
					rules: {
						idRol: {
							required: true,
							digits: true,
						},
						nombreUsuario: {
							required: true,
							maxlength: 80,
							lettersonly: true,
						},
						mailUsuario: {
							required: true,
							maxlength: 80,
						},
						claveUsuario: {
							required: true,
							maxlength: 255,
						},
						auth_key: {
							required: true,
							maxlength: 255,
						},
					},
					messages: {
						idRol: {
							required: "Por favor seleccione un rol",
							digits: "El rol seleccionado es incorrecta",
						},
						nombreUsuario: {
							required: "Por favor ingrese un nombre de usuario",
							maxlength: "M&aacute;ximo de letras sobrepasado",
						},
						mailUsuario: {
							required: "Por favor ingrese un mail",
							maxlength: "M&aacute;ximo de letras sobrepasado",
						},
						claveUsuario: {
							required: "Por favor ingrese una clave",
							maxlength: "M&aacute;ximo de letras sobrepasado",
						},
						auth_key: {
							required: "Por favor ingrese una clave de autenticaci&oacute;n",
							maxlength: "M&aacute;ximo de letras sobrepasado",
						},
					}
				});
		</script>
	</section>
	@endsection