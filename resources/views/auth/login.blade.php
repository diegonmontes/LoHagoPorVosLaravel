@extends('layouts.app')
@section('content')
<div class="fondoLogin">
</div>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
                <div class="row">
                        @if(Session::has('error'))
                            <div class="alert alert-info col-md-8">
                                {{Session::get('error')}}
                            </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-info col-md-3" style="position: absolute;z-index: 2;top: 30px;">
                                {{Session::get('success')}}
                            </div>
                        @endif
                </div>
            <div class="col-md-4">
                <form class="form-signin" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="card fondoTarjeta sombraTarjeta">
                            
                        <div class="card-body">
                            <a href="{{route('inicio')}}" style="text-decoration:none;">
                                <div class="row justify-content-center align-items-center">
                                <img src={{asset('images/LogoLoHagoPorVos.png')}} alt="Logo Lo hago por vos" style="width: 35%;"/>
                                    <h3 style="color: #FFF; font-weight: 600">LO HAGO POR VOS</h3>
                                </div>
                            </a>
                            <br>                 
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label for="mailUsuario" class="sr-only">{{ __('Mail') }}</label>
                                    <input id="mailUsuario" type="email" class="form-control redondearInput fondoInput @error('emailUsuario') is-invalid @enderror" name="mailUsuario" value="{{ old('emailUsuario') }}" required autocomplete="mailUsuario" autofocus placeholder="Correo electr&oacute;nico">
                                    @error('emailUsuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            <br>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label for="claveUsuario" class="sr-only">{{ __('Contraseña') }}</label>
                                    <input id="claveUsuario" type="password" class="form-control redondearInput fondoInput @error('claveUsuario') is-invalid @enderror" name="claveUsuario" required autocomplete="current-claveUsuario" placeholder="Contraseña">
                                    @error('claveUsuario')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            
                            <div class="row justify-content-center align-items-center">
                                <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember" style="color: #FFF">
                                        {{ __('Recordarme') }}
                                    </label>
                                </div>
                            </div>
                            <br>
                                

                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button class=" btn btn-light btn-block redondearInput botonIngresar" type="submit">
                                    {{ __('INGRESAR') }}
                                </button>
                            </div>
                                <div class="row justify-content-center align-items-center">

                                    @if (Route::has('register'))
                                        <a class="btn btn-link enlacesLogin" href="{{ route('register') }}">{{ __('REGISTRARME') }}</a>
                                    @endif
                                    <span class="enlacesLogin">|</span>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link enlacesLogin" href="{{ route('password.request') }}">
                                            {{ __('OLVIDE MI CONTRASEÑA') }}
                                        </a>
                                    @endif

                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
