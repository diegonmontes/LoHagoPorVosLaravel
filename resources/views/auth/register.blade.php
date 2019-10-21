@extends('layouts.app')
@section('content')
<div class="fondoLogin">
</div>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <form method="POST" action="{{ route('register') }}">
                    <div class="card fondoTarjeta sombraTarjeta">
                        <div class="card-body">
                            <div class="row justify-content-center align-items-center">
                                <img src={{asset('images/LogoLoHagoPorVos.png')}} alt="Logo Lo hago por vos" style="width: 35%;"/>
                                <h3 class="h3 mb-3 font-weight-normal" style="color: #FFF; font-weight: 600">{{ __('Completá el formulario') }}</h3>
                            </div>
                                @csrf
                            <div class="form-group">
                                <input id="nombreUsuario" type="text" class="form-control redondearInput fondoInput @error('nombreUsuario') is-invalid @enderror" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required autocomplete="nombreUsuario" placeholder="Usuario" autofocus>                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="mailUsuario" type="email" class="form-control redondearInput fondoInput @error('emailUsuario') is-invalid @enderror" name="mailUsuario" value="{{ old('emailUsuario') }}" required autocomplete="mailUsuario" placeholder="Corre electrónico">
                                @error('emailUsuario')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="claveUsuario" type="password" class="form-control redondearInput fondoInput @error('claveUsuario') is-invalid @enderror" name="claveUsuario" required autocomplete="new-claveUsuario" placeholder="Contraseña">
                                @error('claveUsuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="claveUsuario-confirm" type="password" class="form-control redondearInput fondoInput " name="claveUsuario_confirmation" required autocomplete="new-claveUsuario" placeholder="Repetir la contraseña">
                            </div>
                            <button type="submit" class="btn btn-light btn-block btn-block redondearInput botonIngresar">
                                {{ __('REGISTRARME') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
