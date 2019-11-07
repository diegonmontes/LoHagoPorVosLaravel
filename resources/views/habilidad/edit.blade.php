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
					<h3>Editar Habilidad</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formHabilidad" name="formHabilidad" enctype="multipart/form-data" action="{{ route('habilidad.update',$habilidad->idHabilidad) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						<div class="row">
							<div class="form-group">
								<label>Nombre:</label><br>
								<input type="text" name="nombreHabilidad" id="nombreHabilidad" class="form-control input-sm" value="{{$habilidad->nombreHabilidad}}">
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label>Descripcion:</label><br>
								<input type="text" name="descripcionHabilidad" id="descripcionHabilidad" class="form-control input-sm" value="{{$habilidad->descripcionHabilidad}}">
							</div>
						</div>

						<div class="row margenImagenHabilidad">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="drag-drop-imagenHabilidad imagenHabilidad">
									<input type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenHabilidad" />
									<output id="thumbnil" class="preview-imagenHabilidad">
										<img  class="preview-imagenHabilidad" src="
												@if($habilidad->imagenHabilidad != null)
													{{ asset('storage/habilidad/'.$habilidad->imagenHabilidad)}}
												@else{{asset('images/fotoPerfil.png')}}@endif
										">
									</output>
								</div>
							</div>
						</div>

						<br/>
						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('habilidad.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
				</div>
			</div>
			<script>
			jQuery.validator.addMethod("lettersonly", function(value, element) {
				return this.optional(element) || /^[a-z ]+$/i.test(value);
				}, "Solo puede ingresar letras");
			$("#formHabilidad").validate({
				rules: {
					nombreHabilidad: {
						required: true,
						minlength: 4,
						maxlength: 80,
						lettersonly: true,
					},
					descripcionHabilidad: {
						required: true,
						minlength: 4,
						maxlength: 255,
						lettersonly: true,
					}
				},
				messages: {
					nombreHabilidad: {
						required: "Por favor ingrese el nombre de la habilidad",
						minlength: "El m&iacute;nimo de letras que debe ingresar son 4",
						maxlength: "M&aacute;ximo de letras sobrepasado",
					},
					descripcionHabilidad: {
						required: "Por favor ingrese una descripci&oacute;n de la habilidad",
						minlength: "El m&iacute;nimo de letras que debe ingresar son 4",
						maxlength: "M&aacute;ximo de letras sobrepasado"
					},
				}
			});
		</script>
	</section>
	@endsection