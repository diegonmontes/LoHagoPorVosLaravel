@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
        <form method="POST" action="{{ route('register') }}">
            <h1 class="h3 mb-3 font-weight-normal">{{ __('Completar el formulario para registrarse') }}</h1>
            @csrf
            <div class="form-group">

                <input id="nombreUsuario" type="text" class="form-control inputBordes @error('nombreUsuario') is-invalid @enderror" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required autocomplete="nombreUsuario" placeholder="Usuario" autofocus>                                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="mailUsuario" type="email" class="form-control inputBordes @error('emailUsuario') is-invalid @enderror" name="mailUsuario" value="{{ old('emailUsuario') }}" required autocomplete="mailUsuario" placeholder="Corre electrónico">
                @error('emailUsuario')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="claveUsuario" type="password" class="form-control inputBordes @error('claveUsuario') is-invalid @enderror" name="claveUsuario" required autocomplete="new-claveUsuario" placeholder="Contraseña">
                @error('claveUsuario')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="claveUsuario-confirm" type="password" class="form-control inputBordes " name="claveUsuario_confirmation" required autocomplete="new-claveUsuario" placeholder="Repetir la contraseña">
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block inputBordes">
                {{ __('Registrarse') }}
            </button>
        </form>
        </div>
    </div>
</div>
@endsection
