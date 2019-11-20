<nav id="navbarmenu" class="navbar navbar-expand-lg navbar-light bg-light fixed-top sombraNavbar">
    <a href="{{route('inicio')}}">
        <img class="logoNavbar" src="{{asset('images/logoLoHagoPorVosNavar.png')}}" alt="Logo Lo hago por vos" style="width: 6%; left: -20%;"/>
        <span class="tituloNavbar">LO HAGO POR VOS</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    @if(Request::path() != 'login' && Request::path() != 'register')
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <i class="fas fa-search iconoBusqueda"></i>
                            <input type="text" class="form-control buscador" placeholder="Buscar" name="tituloAnuncio">
                        </div>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('inicio')}}">INICIO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('trabajo.index')}}">CREAR ANUNCIO</a>
                </li>
                @if (Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->nombreUsuario}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('persona.create')}}"><i class="fas fa-user"></i> Mi Perfil</a>
                        <a class="dropdown-item" href="{{route('historial')}}"><i class="fas fa-list"></i> Mis Anuncios</a>
                        <a class="dropdown-item" href="{{route('mispostulaciones')}}"><i class="fas fa-hands-helping"></i> Mis Postulaciones</a>
                        <a class="dropdown-item" href="{{route('conversaciones')}}"><i class="fas fa-envelope"></i> Conversaciones </a>
                        
                        @if (Auth::user()->idRol==1) <a class="dropdown-item" href="{{route('categoriatrabajo.index')}}"><i class="fas fa-hands-helping"></i> Administrador</a> @endif 
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i>
                            {{ __('Cerrar sesion') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="login">INGRESAR</a></li>
                @endif
            </ul>
        </div>
    @endif
</nav>
