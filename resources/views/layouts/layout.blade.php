<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    @yield('jsHead')
    
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css"  href="{{ asset('styles/imagenTrabajo.css') }}">

    <link rel="stylesheet" type="text/css"  href="{{ asset('css/fontawesome-free/css/all.css') }}"> 
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="http://localhost/LoHagoPorVosLaravel/public/js/app.js"></script>
      <!-- Scripts -->


    <script defer>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
        ]) !!};
    </script>



    @yield('css')



</head>
<body>
@include('layouts.partials.nav')

@yield('content')

@include('layouts.partials.footer')
@include('layouts.partials.footer-scripts')

@yield('js')

</body>
</html>
