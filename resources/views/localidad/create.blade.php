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
					<h3>Nueva Localidad</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formLocalidad" name="formLocalidad" action="{{ route('localidad.store') }}"  role="form">
						{{ csrf_field() }}
						<div class="row">
							<div class="form-group">
								<label>Nombre:</label>
								<input type="text" name="nombreLocalidad" id="nombreLocalidad" class="form-control input-sm">
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label>Codigo Postal:</label>
								<input type="number" name="codigoPostal" id="codigoPostal" class="form-control input-sm">
							</div>
						</div>
						<div class="row">
							<label for="idProvincia">Provincia:</label>
							<select class="form-control" name="idProvincia" id="idProvincia">
							<option value="" selected disabled>Seleccione una provincia </option>
								@foreach($provincias as $unaProvincia)
									<option value="{{$unaProvincia->idProvincia}}">
									{{$unaProvincia->nombreProvincia}}</option>
								@endforeach
							</select>
						</div>
						<br>
						<div class="row">
							<input type="submit"  value="Guardar" class="btn btn-success btn-block">
							<a href="{{ route('localidad.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>	
					</form>
				</div>
			</div>
			<script>
				jQuery.validator.addMethod("lettersonly", function(value, element) {
					return this.optional(element) || /^[a-z]+$/i.test(value);
					}, "Solo puede ingresar letras");
				$("#formLocalidad").validate({
					rules: {
						nombreLocalidad: {
							required: true,
							minlength: 4,
							maxlength: 50,
							lettersonly: true,
						},
						codigoPostal: {
							required: true,
							minlength: 4,
							maxlength: 255,
							digits: true,
						},
						idProvincia:{
							required:true,
							digits: true,
						}
					},
					messages: {
						nombreLocalidad: {
							required: "Por favor ingrese el nombre de la localidad",
							minlength: "El m&iacute;nimo de letras que debe ingresar son 4",
							maxlength: "M&aacute;ximo de letras sobrepasado",
						},
						codigoPostal: {
							required: "Por favor ingrese el c&oacute;digo postal de la localidad",
							minlength: "El m&iacute;nimo de letras que debe ingresar son 4",
							maxlength: "M&aacute;ximo de letras sobrepasado",
							number: "Solo debe ingresar n&uacute;meros",
						},
						idProvincia: {
							required: "Por favor seleccione una provincia",
							digits: "La provincia seleccionada es incorrecta",
						},
					}
				});
			</script>
		</section>
	</div>
@endsection

	
