@extends('admin')
@section('jsHead')
	<script src="{{asset('js/previaImagen.js')}}"></script>
@endsection
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
						<h3>Nueva Habilidad</h3>
					</div>
					<div class="card-body">
						<form method="POST" id="formHabilidad" enctype="multipart/form-data" name="formHabilidad" action="{{ route('habilidad.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
									<div class="form-group">
										<label>Nombre:</label>
										<input type="text" name="nombreHabilidad" id="nombreHabilidad" class="form-control input-sm">
									</div>
								</div>
							<div class="row">
								<div class="form-group">
									<label>Descripci&oacute;n:</label>
									<input type="text" name="descripcionHabilidad" id="descripcionHabilidad" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label>INGRESE UNA IMAGEN(opcional)</label>
                                    <div class="drag-drop-imagenHabilidad imagenHabilidad">
                                        <input class="inputImagenHabilidad" type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenHabilidad" />
                                        <output id="thumbnil" class="preview-imagenHabilidad">
                                                <img class="preview-imagenHabilidad" src="{{asset('images/subirImagen.png')}}" style="width: 30%; margin: auto;">
                                        </output>
                                    </div>
                                </div>
                            </div>
							<br>
							<div class="row">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('habilidad.index') }}" class="btn btn-info btn-block" >Atrás</a>
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


