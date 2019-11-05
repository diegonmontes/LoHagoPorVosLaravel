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
						<h3>Nueva Pago Recibido</h3>
					</div>
					<div class="card-body">
						<form method="POST" id="formPagoRecibido" name="formPagoRecibido" action="{{ route('pagorecibido.storepanel') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
							<label for="idTrabajo">Trabajo:</label>
								<select class="form-control" name="idTrabajo" id="idTrabajo">
									<option value="" selected disabled>Seleccione un trabajo </option>
									@foreach($listaTrabajos as $trabajo)
										<option value="{{$trabajo->idTrabajo}}">
										{{$trabajo->idTrabajo." - ".$trabajo->titulo}}</option>
									@endforeach
								</select>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Id Pago:</label>
									<input type="text" name="idPago" id="idPago" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Monto:</label>
									<input type="text" name="monto" id="monto" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Metodo:</label>
									<input type="text" name="metodo" id="metodo" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Tarjeta:</label>
									<input type="text" name="tarjeta" id="tarjeta" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Fecha Pago:</label>
									<input type="text"  id="datepickerPago" class="form-control inputBordes" style="background-color: #fff;" readonly>
                                    <input type="text" id="datepickerPagoAlt" name="fechapago" class="datepicker-picker" >
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Fecha Aprobado:</label>
									<input type="text"  id="datepickerAprobado"  class="form-control inputBordes" style="background-color: #fff;" readonly>
                                    <input type="text" id="datepickerAprobadoAlt" name="fechaaprobado" class="datepicker-picker" >
								</div>
							</div>

							<br>
							<div class="row">
								<input type="submit"  value="Guardar" class="btn btn-success btn-block">
								<a href="{{ route('pagorecibido.index') }}" class="btn btn-info btn-block" >Atrás</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
		<script type="text/javascript">
			$('#datepickerPago').datetimepicker({
				altField: "#datepickerPagoAlt",
				altFieldTimeOnly: false,
				altFormat: "yy-mm-dd",
				controlType: 'select',
				oneLine: true,
				altTimeFormat: "H:m",
				dateFormat: "yy-mm-dd",
				timeFormat: "HH:mm:ss",
				minDate: 0
			});   
	
			$('#datepickerAprobado').datetimepicker({
				altField: "#datepickerAprobadoAlt",
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
				return this.optional(element) || /^[a-z ]+$/i.test(value);
			}, "Solo puede ingresar letras");
				
			jQuery.validator.addMethod("validDate", function (value, element) {
					var stamp = value.split(" "); // Dividimos el input en fecha(0) y hora-min(1)
					var validDate = !/Invalid|NaN/.test(new Date(stamp[0]).toString()); // verificamos que la fecha sea correcta
					return this.optional(element) || (validDate);
				}, "Por favor ingrese una fecha correcta (DD/MM/AAAA HH-MM)");
			
						
			$("#formPagoRecibido").validate({
					rules: {
						idTrabajo: {
							required: true,
							digits: true,
						},
						idPago: {
							required: true,
							maxlength: 255,
							digits: true,
						},
						fechapago:{
							required: true,
							validDate: true,
						},
						monto: {
							required: true,
							maxlength: 10,
							number: true,
						},
						metodo: {
							required: true,
							maxlength: 255,
						},
						tarjeta: {
							required: true,
							maxlength: 16,
							lettersonly: true,
						},		
						fechaaprobado:{
							required: true,
							validDate: true,
						},
					},
					messages: {
						idTrabajo: {
							required: "Por favor seleccione un trabajo",
							digits: "El trabajo seleccionado es incorrecto",
						},
						idPago: {
							required: "Por favor ingrese un ID de pago",
							maxlength: "M&aacute;ximo de letras sobrepasado",
							digits: "Por favor, ingrese solo numeros",
						},
						monto: {
							required: "Por favor ingrese un monto",
							maxlength: "M&aacute;ximo de letras sobrepasado",
							number: "Por favor, ingrese solo numeros y separados por un punto(.)",
						},
						metodo: {
							required: "Por favor ingrese un m&eacute;todo",
							maxlength: "M&aacute;ximo de letras sobrepasado",
						},
						tarjeta: {
							required: "Por favor ingrese el nombre de la tarjeta con la que realiz&oacute; el pago",
							maxlength: "M&aacute;ximo de letras sobrepasado",
						},
						fechapago:{
							required: "Por favor ingrese una fecha de pago correcta (DD-MM-AAAA HH-MM)",	
						},
						fechaaprobado:{
							required: "Por favor ingrese una fecha de aprobado correcta (DD-MM-AAAA HH-MM)",	
						},
					}
				});
		</script>
	</section>
	@endsection


