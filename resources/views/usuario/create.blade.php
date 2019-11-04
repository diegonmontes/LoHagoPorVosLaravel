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
						<h3>Nuevo Usuario</h3>
					</div>
					<div class="card-body">
						<form method="POST" id="formUsuario" name="formUsuario" action="{{ route('usuario.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
								<label for="idRol">Rol:</label>
								<select class="form-control" name="idRol" id="idRol">
								<option value="" selected disabled>Seleccione un rol</option>
									@foreach($listaRoles as $rol)
										<option value="{{$rol->idRol}}">
										{{$rol->idRol." - ".$rol->nombreRol}}</option>
									@endforeach
								</select>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Nombre de usuario:</label>
									<input type="text" name="nombreUsuario" id="nombreUsuario" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Mail usuario:</label>
									<input type="text" name="mailUsuario" id="mailUsuario" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Auth Key:</label>
									<input type="text" name="auth_key" id="auth_key" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Clave Usuario:</label>
									<input type="text" name="claveUsuario" id="claveUsuario" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Remember token:</label>
									<input type="text" name="remember_token" id="remember_token" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Fecha Mail verificado</label>
									<input type="text"  id="datepickerMail"  class="form-control inputBordes" style="background-color: #fff;" readonly>
                                    <input type="text" id="datepickerMailAlt" name="email_verified_at" class="datepicker-picker" >
								</div>
							</div>

							<br>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('usuario.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

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


