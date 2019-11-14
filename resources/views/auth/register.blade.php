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
                                <input id="nombreUsuario" type="text" class="form-control redondearInput fondoInput @error('nombreUsuario') is-invalid @enderror" name="nombreUsuario" value="{{ old('nombreUsuario') }}"  autocomplete="nombreUsuario" placeholder="Usuario" autofocus>                                
                                <span id="msgnombreUsuario" class="text-danger" role="alert"></span>

                            </div>

                            <div class="form-group">
                                <input id="mailUsuario" type="email" class="form-control redondearInput fondoInput @error('emailUsuario') is-invalid @enderror" name="mailUsuario" value="{{ old('emailUsuario') }}"  autocomplete="mailUsuario" placeholder="Correo electrónico">
                                <span id="msgmailUsuario" class="text-danger" role="alert"></span>
                            </div>

                            <div class="form-group">
                                <input id="claveUsuario" type="password" class="form-control redondearInput fondoInput @error('claveUsuario') is-invalid @enderror" name="claveUsuario"  autocomplete="new-claveUsuario" placeholder="Contraseña">
                                <span id="msgclaveUsuario" class="text-danger" role="alert"></span>

                            </div>

                            <div class="form-group">
                                <input id="claveUsuario-confirm" type="password" class="form-control redondearInput fondoInput " name="claveUsuario_confirmation" autocomplete="new-claveUsuario" placeholder="Repetir la contraseña para confirmar">
                            </div>
                            <button type="submit" class="btn btn-light btn-block btn-block redondearInput botonIngresar">
                                {{ __('REGISTRARME') }}
                            </button>

                            <div class="row justify-content-center align-items-center">

                                    @if (Route::has('login'))
                                        <a class="btn btn-link enlacesLogin" href="{{ route('login') }}">{{ __('YA TENGO UNA CUENTA') }}</a>
                                    @endif
                                   

                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
		<div id="registroUsuario" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title tituloModal" id="exampleModalLabel">
                            
                        </h5>
                    </div>
                    <div class="content align-content-center align-self-center" id="cargando">

                    </div>
                    <div class="content" id="mensaje">

                    </div>
                    <div class="modal-footer botonAceptar">
                    </div>
                </div>
            </div>
        </div>
@endsection


@section('js')

<script type="text/javascript">


    //Control nombre usuario
    $("#nombreUsuario").on("keyup",function(){
        controlNombreUsuario();
    })
    $("#nombreUsuario").on("click",function(){
        controlNombreUsuario();
    })

    function controlNombreUsuario(){
        var nombreUsuario = $("#nombreUsuario").val();
        if(nombreUsuario.length<1){
            $("#msgnombreUsuario").empty();
            $("#msgnombreUsuario").css("display","block");
            $("#msgnombreUsuario").append("El nombre de usuario es obligatorio.")
        }else{
            $("#msgnombreUsuario").empty();
        }
    }

    //Control ingreso de mail
    $("#mailUsuario").on("click",function(){
        controlMailUsuario();
    })
    $("#mailUsuario").on("keyup",function(){
        controlMailUsuario();
    })

    function controlMailUsuario(){
        var mailUsuario = $("#mailUsuario").val();
        patron = /^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/; //Patron a respetar
        if(mailUsuario == ""){
            $("#msgmailUsuario").empty();
            $("#msgmailUsuario").css("display","block");
            $("#msgmailUsuario").append("El mail es obligatorio.");
        }else if (!patron.test(mailUsuario)) {
            $("#msgmailUsuario").empty();
            $("#msgmailUsuario").css("display","block");
            $("#msgmailUsuario").append("Ingrese un mail valido.");
        
        }else{
            $("#msgmailUsuario").empty();
        }
    }

    //Control ingreso contraseña
    $("#claveUsuario").on("keyup",function(){
        controlClave();
    })
    function controlClave(){
        var claveUsuario = $("#claveUsuario").val();
        if(claveUsuario.length<1){
            $("#msgclaveUsuario").empty();
            $("#msgclaveUsuario").css("display","block");
            $("#msgclaveUsuario").append("La contraseña es obligatoria.");
        }else if(claveUsuario.length>0 && claveUsuario.length<8){
            $("#msgclaveUsuario").empty();
            $("#msgclaveUsuario").css("display","block");
            $("#msgclaveUsuario").append("La contraseña debe contener como minimo 8 caracteres.");
        }else{
            $("#msgclaveUsuario").empty();
        }

    }

    //Control ingreso contraseña confirm
    $("#claveUsuario-confirm").on("keyup",function(){
        controlClaveConfirm();
    })
    function controlClaveConfirm(){
        var claveUsuario = $("#claveUsuario").val();
        var claveConfirm = $("#claveUsuario-confirm").val();
        if(claveConfirm != claveUsuario){
            $("#msgclaveUsuario").empty();
            $("#msgclaveUsuario").css("display","block");
            $("#msgclaveUsuario").append("Las contraseñas no coinciden.");
        }else{
            $("#msgclaveUsuario").empty();
        }
    }



    $(document).ready(function (e){
        $("#formRegistro").on('submit',(function(e){
            controlMailUsuario();
            controlNombreUsuario();
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
                    //Quitamos el boton cerrar
                    $('.botonAceptar').empty();
                    //Quitamos el mensaje
                    $('#mensaje').empty();
                    //Quitamos el titulo y agregamos uno nuevo
                    $('.tituloModal').empty();
                    $('.tituloModal').append('Cargando datos ...')
                    //Agregamos el icono de carga
                    $('#cargando').empty();
                    $('#cargando').append('<p><div class="lds-ring"><div></div><div></div><div></div><div></div></div></p>');
                    //Abrimos el modal
                    $('#registroUsuario').modal('show');
                },
                success: function(data){
                    //Quitamos el boton cerrar
                    $('.botonAceptar').empty();
                    //Quitamos el icono de carga
                    $('#cargando').empty();
                    //Quitamos el titulo y agregamos uno nuevo
                    $('.tituloModal').empty();
                    $('.tituloModal').append('<p>Usuario creado exitosamente.<p>');
                    //Quitamos el mensaje y agremaos uno nuevo
                    $('#mensaje').empty();
                    $('#mensaje').append('<br><h5 style="margin-left: 3%">Se envio un mail con el sigueinte paso. Por favor revise su correo y valide su email.</h5><br>');
                    //Agregamos el boton cerrar
                    $('.botonAceptar').append('<a href="{{route('login')}}" class="btn btn-success">Aceptar</a>');
                },
                error: function(msg){
                    //Quitamos el titulo y agregamos uno nuevo
                    $('.tituloModal').empty();
                    $('.tituloModal').append('Datos erroneos');
                    //Quitamso el icono de carga
                    $('#cargando').empty();
                    //Agregamos un mensaje
                    $('#mensaje').append('<br><h5 style="margin-left: 3%">Por favor revise todos los campos del formulario.</h5><br>');
                    //Agregamos el boton cerrar
                    $('.botonAceptar').append('<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>');
                    //Mostramos el mensaje de error
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
