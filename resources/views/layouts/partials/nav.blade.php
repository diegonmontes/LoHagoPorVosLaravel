<nav id="navbarmenu" class="navbar navbar-expand-lg navbar-light bg-light fixed-top sombraNavbar">
    <a href="{{route('inicio')}}">
        <img class="logoNavbar" src="{{asset('images/logoLoHagoPorVosNavar.png')}}" alt="Logo Lo hago por vos" style="width: 6%; left: -20%;"/>
        <span>LO HAGO POR VOS</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    @if(Request::path() != 'login' && Request::path() != 'register')
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
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
                        <a class="dropdown-item" href="/LoHagoPorVosLaravel/public/usuario/perfil">Mi Perfil</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
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
            {{-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> --}}
        </div>
    @endif
</nav>
