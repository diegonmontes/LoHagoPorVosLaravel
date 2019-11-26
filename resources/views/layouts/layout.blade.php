<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Lo hago por vos') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Icono -->
    <link rel="shortcut icon" href="{{asset('images/lohagoporvos.ico')}}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css"  href="{{ asset('styles/imagenTrabajo.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/estiloPropio.css') }}">
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/fontawesome-free/css/all.css') }}">

    <!-- CDN Styles -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />

    <!-- Script -->
    <script src="{{asset('js/app.js')}}" defer></script>

    <script src="{{asset('js/popper.js')}}"></script>

    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>

    @yield('jsHead')

    <!-- CDN JQuery -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <!-- Pusher -->
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
