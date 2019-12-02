
<!DOCTYPE html>
<html lang='es'>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Anuncio cancelado</title>
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
                &iexcl;Hola {{$nombrePersonaCreador}} {{$nombrePersonaCreador}}!  <br/>

                Has notificado que deseas cancelar un anuncio que hab&iacute;as creado y pagado.                 
                &iexcl;Recuerde que debe abonar una multa de ${{$valor}},! se le sumar&aacute; en el importe en el pr&oacute;ximo anuncio que pague.

                <h3>Descripci&oacute;n del anuncio cancelado: </h3>
                <Strong> T&iacute;tulo:</strong> {{$tituloTrabajo}} <br/>
                <Strong> Descripci&oacute;n:</strong> {{$descripcionTrabajo}} <br/>
                <Strong> Motivo:</strong> {{$motivo}} <br/>
                <Strong> Fecha de cancelaci&oacute;n:</strong> {{$fechaMulta}}
            </center>
        </div>
    </div>
</body>

</html>