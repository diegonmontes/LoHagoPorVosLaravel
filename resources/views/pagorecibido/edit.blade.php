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
					<h3>Editar Pago Recibido</h3>
				</div>
				<div class="card-body">
					<form method="POST" id="formPagoRecibido" name="formPagoRecibido" action="{{ route('pagorecibido.update',$pagoRecibido->idPagoRecibido) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						
						<div class="row">
							<label for="idTrabajo">Trabajo:</label>
							<select class="form-control" name="idTrabajo" id="idTrabajo">
								@foreach($listaTrabajos as $trabajo)
									<option value="{{$trabajo->idTrabajo}}"
										@if($pagoRecibido->trabajo->idTrabajo == $trabajo->idTrabajo){
											selected
											}
										@endif>
										{{$trabajo->idTrabajo." - ".$trabajo->titulo}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Pago:</label><br>
								<input type="text" name="idPago" id="idPago" class="form-control input-sm" value="{{$pagoRecibido->idPago}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Monto:</label><br>
								<input type="text" name="monto" id="monto" class="form-control input-sm" value="{{$pagoRecibido->monto}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Metodo:</label><br>
								<input type="text" name="metodo" id="metodo" class="form-control input-sm" value="{{$pagoRecibido->metodo}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Tarjeta:</label><br>
								<input type="text" name="tarjeta" id="tarjeta" class="form-control input-sm" value="{{$pagoRecibido->tarjeta}}">
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Fecha Pago:</label><br>
								<input type="text"  id="datepickerPago" class="form-control inputBordes" value="{{$pagoRecibido->fechapago}}" style="background-color: #fff;" readonly>
                                <input type="text" id="datepickerPagoAlt" name="fechapago" class="datepicker-picker"  >	
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label>Fecha Aprobado:</label><br>
								<input type="text"  id="datepickerAprobado" value="{{$pagoRecibido->fechaaprobado}}"  class="form-control inputBordes" style="background-color: #fff;" readonly>
                                <input type="text" id="datepickerAprobadoAlt" name="fechaaprobado" class="datepicker-picker" >
							</div>
						</div>


						<div class="row">
							<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
							<a href="{{ route('pagorecibido.index') }}" class="btn btn-info btn-block" >Atrás</a>
						</div>
					</form>
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
					return this.optional(element) || /^[a-z]+$/i.test(value);
				}, "Solo puede ingresar letras");
					
				jQuery.validator.addMethod("validDate", function (value, element) {
						var stamp = value.split(" "); // Dividimos el input en fecha(0) y hora-min(1)
						var validDate = !/Invalid|NaN/.test(new Date(stamp[0]).toString()); // verificamos que la fecha sea correcta
						return this.optional(element) || (validDate);
					}, "Por favor ingrese una fecha correcta (DD/MM/AA HH-MM)");
				
							
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
								required: "Por favor ingrese un metodo",
								maxlength: "M&aacute;ximo de letras sobrepasado",
							},
							tarjeta: {
								required: "Por favor ingrese el nombre de la tarjeta con la que realiz&oacute; el pago",
								maxlength: "M&aacute;ximo de letras sobrepasado",
							},
							fechapago:{
								required: "Por favor ingrese una fecha de pago correcta (DD/MM/AA HH-MM)",	
							},
							fechaaprobado:{
								required: "Por favor ingrese una fecha de aprobado correcta (DD/MM/AA HH-MM)",	
							},
						}
					});
			</script>
	</section>
	@endsection