@extends('layouts.app')

@section('content')

<div class="container">
    <div class="text-center formingreso">
        <div class="sombra-ingreso">
                    <form class="form-signin" method="POST" action="{{ route('login') }}">
                        <h1 class="h3 mb-3 font-weight-normal">{{ __('Ingresar los siguientes datos para continuar:') }}</h1>

                        @csrf

                            <label for="mailUsuario" class="sr-only">{{ __('Mail') }}</label>

                                <input id="mailUsuario" type="email" class="form-control @error('emailUsuario') is-invalid @enderror" name="mailUsuario" value="{{ old('emailUsuario') }}" required autocomplete="mailUsuario" autofocus placeholder="Correo electonico">

                                

                            <label for="claveUsuario" class="sr-only">{{ __('Contraseña') }}</label>

                                <input id="claveUsuario" type="password" class="form-control @error('claveUsuario') is-invalid @enderror" name="claveUsuario" required autocomplete="current-claveUsuario" placeholder="Contraseña">

                                @error('emailUsuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('claveUsuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recordarme') }}
                                    </label>
                                </div><br>

                                <button class="btn btn-lg btn-primary btn-block" type="submit">
                                    {{ __('Ingresar') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Olvide mi contraseña') }}
                                    </a>
                                @endif

                                @if (Route::has('register'))
                                <br>
                                    <a class="btn btn-link" href="{{ route('register') }}">{{ __('Crear cuenta') }}</a>
                            @endif
                    </form>
                </div>
</div>
@endsection
