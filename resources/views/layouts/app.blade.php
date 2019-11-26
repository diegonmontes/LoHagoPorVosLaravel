<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Icono -->
    <link rel="shortcut icon" href="{{asset('images/lohagoporvos.ico')}}">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lo hago por vos') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/estiloPropio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('styles/signin.css')}}">


    <!-- Script -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
        ]) !!};
    </script>
        <script src="{{asset('js/app.js')}}"></script>

    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>



   


    @yield('css')



    

</head>
<body>
    <main class="py-4">
        @yield('content')
    </main>
    @yield('js')


</body>
</html>
