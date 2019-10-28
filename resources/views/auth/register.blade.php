@extends('layouts.app')
@section('content')
<div class="fondoLogin">
</div>
@if(Session::has('errors'))
<div class="alert alert-info">
    {{Session::get('errors')}}
</div>
@endif
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <form id="formRegistro" method="POST" action="{{ route('register') }}">
                    <div class="card fondoTarjeta sombraTarjeta">
                        <div class="card-body">
                            <div class="row justify-content-center align-items-center">
                                <img src={{asset('images/LogoLoHagoPorVos.png')}} alt="Logo Lo hago por vos" style="width: 35%;"/>
                                <h3 class="h3 mb-3 font-weight-normal" style="color: #FFF; font-weight: 600">{{ __('Completá el formulario') }}</h3>
                            </div>
                                @csrf
                                
                            <div class="form-group">
                                <input id="nombreUsuario" type="text" class="form-control redondearInput fondoInput @error('nombreUsuario') is-invalid @enderror" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required autocomplete="nombreUsuario" placeholder="Usuario" autofocus>                                
                                <span id="msgnombreUsuario" class="text-danger" role="alert"></span>

                            </div>

                            <div class="form-group">
                                <input id="mailUsuario" type="email" class="form-control redondearInput fondoInput @error('emailUsuario') is-invalid @enderror" name="mailUsuario" value="{{ old('emailUsuario') }}" required autocomplete="mailUsuario" placeholder="Corre electrónico">
                                <span id="msgmailUsuario" class="text-danger" role="alert"></span>
                            </div>

                            <div class="form-group">
                                <input id="claveUsuario" type="password" class="form-control redondearInput fondoInput @error('claveUsuario') is-invalid @enderror" name="claveUsuario" required autocomplete="new-claveUsuario" placeholder="Contraseña">
                                <span id="msgclaveUsuario" class="text-danger" role="alert"></span>

                            </div>

                            <div class="form-group">
                                <input id="claveUsuario-confirm" type="password" class="form-control redondearInput fondoInput " name="claveUsuario_confirmation" required autocomplete="new-claveUsuario" placeholder="Repetir la contraseña para confirmar">
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
<script type="text/javascript">
    $(document).ready(function (e){
        $("#formRegistro").on('submit',(function(e){
            e.preventDefault();
            //Seteamos las variables ingresadas
            var nombreUsuario = $("#nombreUsuario").val();
            var mailUsuario = $("#mailUsuario").val();
            var claveUsuario = $("#claveUsuario").val(); 
            var data={nombreUsuario:nombreUsuario,mailUsuario:mailUsuario,claveUsuario:claveUsuario};
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('register') }}",
                method: "POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    alert('enviando')
                },
                success: function(data){
                    alert('se envio')
                    setTimeout(function(){
							//$('#loading').modal('hide');
							window.location = data.url
						},3000);
                },
                error: function(msg){
                    var errors = $.parseJSON(msg.responseText);
                    $.each(errors.errors, function (key, val) {
                        $("#msg" + key).text(val[0]);
                    });
                }                      
            });
        }));
    });
    </script>
@endsection
