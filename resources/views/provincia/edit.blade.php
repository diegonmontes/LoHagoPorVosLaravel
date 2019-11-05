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
				<h3>Editar Provincia</h3>
			</div>
			<div class="card-body">
				<form method="POST" id="formProvincia" name="formProvincia" action="{{ route('provincia.update',$provincia->idProvincia) }}"  role="form">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="PATCH">
					<div class="row">
						<div class="form-group">
							<label>Nombre:</label><br>
							<input type="text" name="nombreProvincia" id="nombreProvincia" class="form-control input-sm" value="{{$provincia->nombreProvincia}}">
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label>Codigo Iso 31662:</label><br>
							<input type="text" name="codigoIso31662" id="codigoIso31662" class="form-control input-sm" value="{{$provincia->codigoIso31662}}">
						</div>
					</div>
					<div class="row">
						<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
						<a href="{{ route('provincia.index') }}" class="btn btn-info btn-block" >Atrás</a>
					</div>	
				</form>
			</div>
		</div>
		<script>
			jQuery.validator.addMethod("lettersonly", function(value, element) {
					return this.optional(element) || /^[a-z ]+$/i.test(value);
					}, "Solo puede ingresar letras");
				$("#formProvincia").validate({
					rules: {
						nombreProvincia: {
							required: true,
							minlength: 4,
							maxlength: 50,
							lettersonly: true,
						},
						codigoIso31662: {
							required: true,
							minlength: 4,
							maxlength: 4,
						}
					},
					messages: {
						nombreProvincia: {
							required: "Por favor ingrese el nombre de la provincia",
							minlength: "El m&iacute;nimo de letras que debe ingresar son 4",
							maxlength: "M&aacute;ximo de letras sobrepasado(4)",
						},
						codigoIso31662: {
							required: "Por favor ingrese el c&oacute;digo iso de la provincia",
							minlength: "El m&iacute;nimo de letras que debe ingresar son 4",
							maxlength: "M&aacute;ximo de letras sobrepasado(4)",
						},
					}
				});	
		</script>
	</section>
</div>
@endsection