<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="utf-8">
    <title>Lo hago por vos</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <!-- Icono -->
    <link rel="shortcut icon" href="images/lohagoporvos.ico">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/app.css') }}">

</head>
<body>
@include('layouts.partials.nav')
<div class="container-fluid">
    <div class="row" style="margin: 0px !important;">
        <h1>Administrador</h1>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar content-box" style="display: block;">

                <ul class="list-group">

                    <li class="list-group-item">
                        Opción 1
                    </li>
                    <li class="list-group-item">
                        Opción 2
                    </li>
                    <li class="list-group-item">
                        Opción 3
                    </li>
                    <li class="list-group-item">
                        Opción 4
                    </li>
                    <li class="list-group-item">
                        Opción 5
                    </li>
                    <li class="list-group-item">
                        Opción 6
                    </li>
                    <li class="list-group-item">
                        Opción 7
                    </li>
                    <li class="list-group-item">
                        Opción 8
                    </li>
                    <li class="list-group-item">
                        Opción 9
                    </li>
                    <li class="list-group-item">
                        Opción 10
                    </li>
                </ul>
            </div>
        </div>
        <div class="content col-md-9">
            @yield('content')
        </div>
    </div>
</div>

<!-- Footer -->
@include('layouts.partials.footer')

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/navbar.js') }}"></script>


</body>
</html>
