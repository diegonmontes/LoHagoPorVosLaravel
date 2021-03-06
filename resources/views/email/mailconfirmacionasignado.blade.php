<!DOCTYPE html>
<html lang='es'>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>¡Se te ha asignado un anuncio!</title>
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
                &iexcl;Hola {{$nombrePersonaAsignada}} {{$apellidoPersonaAsignada}}! Tenemos una buena noticia para darte. Un anuncio al que te hab&iacute;as postulado para realizar, se te ha asignado. <br/>

                <h3>Descripci&oacute;n del anuncio: </h3>
                <Strong> T&iacute;tulo:</strong> {{$tituloTrabajo}} <br/>
                <Strong> Descripci&oacute;n:</strong> {{$descripcionTrabajo}} <br/>
                <Strong> Monto:</strong> ${{$montoTrabajo}} <br/>
                <br>
                La persona creadora del anuncio se llama <strong>{{$nombrePersonaCreador}} {{$apellidoPersonaCreador}}</strong>. A partir de ahora se ha habilitado un chat en nuestra aplicaci&oacute;n para que puedan coordinar lo que falta.

                &iexcl;&Eacute;xitos realiz&aacute;ndolo! Recuerda que una vez que lo hagas, debes confirmarlo en la aplicaci&oacute;n para que se te libere el pago. Tambi&eacute;n podr&aacute;s valorar al anunciante y subir una imagen del anuncio realizado. 
            </center>
        </div>
    </div>
</body>

</html>