<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('js/buscarLocalidades.js')}}"></script>

    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/app.css') }}">



</head>
<body>
@include('layouts.partials.nav')

@yield('content')

@include('layouts.partials.footer')
@include('layouts.partials.footer-scripts')
</body>
</html>
