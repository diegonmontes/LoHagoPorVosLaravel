<!DOCTYPE html>
<html lang='es'>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>¡Bienvenido!</title>
    <style type="text/css">
        .im {
           color: #000000 !important;
        }
    </style>
</head>

<body>
    <div style='width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px'>
        <div class='col-lg-12 col-xs-6' style='position:relative; margin: auto; max-width: 700px; background:white; padding:20px'>
            <center>  
                &iexcl;Hola! Gracias por registrarte {{$nombreUsuario}}.  <br/>
                <br/>
                Para seguir con el registro primero debés validar tu correo electronico haciendo click en el siguiente boton
                <br/>
                <a href="{{ route('validarmail',[$auth_key,$id]) }}"><button>Validar mi email</button></a>
                <br/>
                En caso que no funcione el boton copia y pega el siguiente enlace en tu navegador web
                <br/>
                <a href="{{ route('validarmail',[$auth_key,$id]) }}">{{ route('validarmail',[$auth_key,$id]) }}</a>
                <br/>
            </center>
        </div>
    </div>
</body>

</html>