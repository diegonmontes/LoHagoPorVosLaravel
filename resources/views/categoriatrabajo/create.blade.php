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
						<h3>Nueva Categoria</h3>
					</div>
					<div class="card-body">
						<form method="POST" action="{{ route('categoriatrabajo.store') }}" id="formCategoriaTrabajo" name="formCategoriaTrabajo" role="form">
							{{ csrf_field() }}
							<div class="row">
								<div class="form-group">
									<label>Nombre:</label>
									<input type="text" name="nombreCategoriaTrabajo" id="nombreCategoriaTrabajo" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Descripci&oacute;n:</label>
									<input type="text" name="descripcionCategoriaTrabajo" id="descripcionCategoriaTrabajo" class="form-control input-sm">
								</div>
							</div>

							<br>
							<div class="row">
								<input type="submit"  value="Guardar" class="btn btn-success btn-block">
								<a href="{{ route('categoriatrabajo.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
		<script>
			jQuery.validator.addMethod("lettersonly", function(value, element) {
				return this.optional(element) || /^[a-z ]+$/i.test(value);
				}, "Solo puede ingresar letras");
			$("#formCategoriaTrabajo").validate({
				rules: {
					nombreCategoriaTrabajo: {
						required: true,
						minlength: 4,
						maxlength: 80,
						lettersonly: true,
					},
					descripcionCategoriaTrabajo: {
						required: true,
						minlength: 4,
						maxlength: 80,
						lettersonly: true,
					}
				},
				messages: {
					nombreCategoriaTrabajo: {
						required: "Por favor ingrese el nombre de la categor&iacute;a",
						minlength: "El m&iacute;nimo de letras que debe ingresar son 4",
						maxlength: "M&aacute;ximo de letras sobrepasado",
					},
					descripcionCategoriaTrabajo: {
						required: "Por favor ingrese una descripci&oacute;n de la categor&iacute;a",
						minlength: "El m&iacute;nimo de letras que debe ingresar son 4",
						maxlength: "M&aacute;ximo de letras sobrepasado"
					},
				}
			});
		</script>
	</section>
	@endsection


