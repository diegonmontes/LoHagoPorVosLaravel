<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="utf-8">
    <title>Lo hago por vos</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <!-- Icono -->
    <link rel="shortcut icon" href={{asset("images/lohagoporvos.ico")}}>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/estiloPropio.css') }}">
    <link rel="stylesheet" type="text/css"  href="{{ asset('css/fontawesome-free/css/all.css') }}">   
    <link rel="stylesheet" type="text/css"  href="{{ asset('styles/imagenTrabajo.css') }}">
    
    <!-- Script -->
    <script src="{{asset('js/app.js')}}"  ></script>
    <script src="{{asset('js/jquery.js')}}"></script>

<!--    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script> -->
   
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> 
    <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/additional-methods.js"></script>


    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />

    @yield('css')
    @yield('jsHead')

</head>
<body>
@include('layouts.partials.nav')
<div class="container-fluid">
    <div class="row" style="margin: 0px !important;">
        <h1>Panel de Administraci&oacute;n</h1>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar content-box" style="display: block;">

                <ul class="list-group">

                    <li class="list-group-item">
                        <a href="{{ route('categoriatrabajo.index') }}">
                            Categor&iacute;as de trabajo
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('comentario.index') }}">
                            Comentarios
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('conversacionchat.index') }}">
                            Conversaciones
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('estado.index') }}">
                            Estados
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('estadotrabajo.index') }}">
                            Historial de estados de los trabajos
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('habilidad.index') }}">
                            Habilidades
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('habilidadpersona.index') }}">
                            Habilidades de las personas
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('localidad.index') }}">
                            Localidades
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('mensajechat.index') }}">
                            Mensajes
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('multa.indexpanel') }}">
                            Multas
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('pagorecibido.index') }}">
                            Pagos recibidos
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('persona.index') }}">
                            Personas
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('preferenciapersona.index') }}">
                            Preferencias de las personas
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('provincia.index') }}">
                            Provincias
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('rol.index') }}">
                        Roles
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('trabajo.indexpanel') }}">
                            Trabajos 
                        </a>
                    </li>
                    
                    <li class="list-group-item">
                        <a href="{{ route('trabajoasignado.index') }}">
                            Trabajo Asignado
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('trabajoaspirante.indexpanel') }}">
                            Trabajos Aspirantes
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('usuario.index') }}">
                            Usuarios
                        </a>
                    </li>
                    

                    <li class="list-group-item">
                        <a href="{{ route('valoracion.index') }}">
                            Valoracion
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

@yield('js')
@yield('jsAbrirModalImagen')
</body>
</html>
