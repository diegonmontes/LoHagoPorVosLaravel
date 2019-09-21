<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<link rel="stylesheet" type="text/css" href="{{asset('styles/bootstrap4/bootstrap.min.css')}}">
	<link href="{{asset('plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
	<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('styles/bootstrap4/popper.js')}}"></script>
	<script src="{{asset('styles/bootstrap4/bootstrap.min.js')}}"></script>
	<script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
	<script src="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
	<script src="{{asset('plugins/easing/easing.js')}}"></script>
	<script src="{{asset('js/custom.js')}}"></script>
	<script src="{{asset('js/buscarLocalidades.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('styles/main_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('styles/responsive.css')}}">
</head>
<body>
@include('layouts.partials.nav')


	<div class="container-fluid" style="margin-top: 100px">

		@yield('content')
	</div>
	<style type="text/css">
	.table {
		border-top: 2px solid #ccc;

	}
</style>
</body>
</html>
