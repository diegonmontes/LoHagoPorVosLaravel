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
						<form method="POST" action="{{ route('pagorecibido.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
								<div class="form-group">
									<label>Trabajo:</label>
									<input type="text" name="idTrabajo" id="idTrabajo" class="form-control input-sm">
								</div>
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
									<input type="text" name="fechapago" id="fechapago" class="form-control input-sm">
								</div>
							</div>

							<div class="row">
								<div class="form-group">
									<label>Fecha Aprobado:</label>
									<input type="text" name="fechaaprobado" id="fechaaprobado" class="form-control input-sm">
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
	</section>
	@endsection


