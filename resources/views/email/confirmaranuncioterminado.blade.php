
<!DOCTYPE html>
<html lang='es'>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Confirmacion de anuncio realizado</title>
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
                &iexcl;Hola {{$nombrePersonaCreador}} {{$apellidoPersonaCreador}}!  <br/>

                <strong> {{$nombrePersonaAsignada}} {{$apellidoPersonaAsignada}} </strong> nos ha indicado que ya realiz&oacute; el anuncio de forma correcta. &iquest;Nos puedes confirmar esto por favor? Recuerda que una vez que confirme, se le deposita el dinero a la persona que lo realiz&oacute;. &iexcl;Muchas gracias!

                <h3>Descripci&oacute;n del anuncio: </h3>
                <Strong> T&iacute;tulo:</strong> {{$tituloTrabajo}} <br/>
                <Strong> Descripci&oacute;n:</strong> {{$descripcionTrabajo}} <br/>
                <Strong> Monto:</strong> ${{$montoTrabajo}} <br/>
                <br/>
                
                <a href="{{route('trabajorealizado',$idTrabajo)}}" class="btn btn-sm btn-primary">Valorar y terminar el anuncio</a>
                <br>
                En caso que no funcione el boton, ingresa con tu cuenta a nuestra p&aacute;gina web y completa el formulario.
                <br/>
            </center>
        </div>
    </div>
</body>

</html>