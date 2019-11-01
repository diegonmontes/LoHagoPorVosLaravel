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
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/fontawesome-free/css/all.css') }}">   
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> 
    <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/additional-methods.js"></script>
<<<<<<< Updated upstream
=======
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
@yield('jsHead');
>>>>>>> Stashed changes

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
                        <a href="{{ route('rol.index') }}">
                        Roles
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('provincia.index') }}">
                        Provincias
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('localidad.index') }}">
                            Localidades
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('categoriatrabajo.index') }}">
                            Categorias de trabajo
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('estado.index') }}">
                            Lista de estados
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('habilidad.index') }}">
                            Lista de habilidades
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('habilidadpersona.index') }}">
                            Lista de habilidades persona
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('preferenciapersona.index') }}">
                            Lista de Preferencias persona
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('conversacionchat.index') }}">
                            Lista de Conversaciones
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('mensajechat.index') }}">
                            Lista de Mensajes
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('estadotrabajo.index') }}">
                            Estados Trabajos
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('pagorecibido.index') }}">
                            Pago Recibido
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('trabajoaspirante.index') }}">
                            Trabajo Aspirante
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('trabajoasignado.index') }}">
                            Trabajo asignado
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('valoracion.index') }}">
                            Valoracion
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('usuario.index') }}">
                            Lista usuarios
                        </a>
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

@yield('js')
</body>
</html>
