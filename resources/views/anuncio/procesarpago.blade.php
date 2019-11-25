@php
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PagorecibidoController;
use App\Http\Controllers\TrabajoasignadoController;
use App\Http\Controllers\ConversacionChatController;
use App\Http\Controllers\MensajeChatController;
use App\Http\Controllers\TrabajoController;
use Illuminate\Http\Request;
use App\Estadotrabajo;
use App\Trabajo;
use App\ConversacionChat;
@endphp

<?php

    if ($_GET!=null){
        try {
            $idPago = $_GET['collection_id'];
            $MPController= new MercadoPagoController;
            $PagoRecibidoController= new PagoRecibidoController;
            $informacionPago = $MPController->obtenerInformacionPago($idPago);
            $metodo = $informacionPago->payment_type_id;
            $monto = $informacionPago->transaction_details->total_paid_amount;
            $tarjeta = $informacionPago->payment_method_id;
            $fechapagoSinEditar = $informacionPago->date_created; // fecha que viene por defecto sin editar
            $diaFechaPago = substr($fechapagoSinEditar,0,10); // seleccionamos solo la fecha
            $horaFechaPago = substr($fechapagoSinEditar,11,8); // seleccionamos solo la hora
            $fechapago = $diaFechaPago." ".$horaFechaPago;
            $fechaaprobadoSinEditar = $informacionPago->date_approved;
            $diaFechaAprobado = substr($fechaaprobadoSinEditar,0,10); // seleccionamos solo la fecha
            $horaFechaAprobado = substr($fechaaprobadoSinEditar,11,8); // seleccionamos solo la hora
            $fechaaprobado = $diaFechaAprobado." ".$horaFechaAprobado;
            $idTrabajo = $_GET['idTrabajo'];
            $informacionPagoRecibido = ['idTrabajo'=>$idTrabajo,'idPago'=>$idPago,'metodo'=>$metodo,'monto'=>$monto,'tarjeta'=>$tarjeta,'fechapago'=>$fechapago,'fechaaprobado'=>$fechaaprobado];
            $requestInformacionPagoRecibido = new Request($informacionPagoRecibido);
            $PagoRecibidoController->store($requestInformacionPagoRecibido);
            //Actualizamos el estado del trabajo
            $paramTrabajo = ['idTrabajo'=>$idTrabajo,'idEstado'=>3];
            $requesTrabajo = new Request($paramTrabajo);
            Trabajo::find($idTrabajo)->update($requesTrabajo->all());
            //LLenamos la tabla estadoTrabajo
            $paramEstadotrabajo = ['idTrabajo'=>$idTrabajo,'idEstado'=>3];
            $requesEstadoTrabajo = new Request($paramEstadotrabajo);
            Estadotrabajo::create($requesEstadoTrabajo->all());
            $trabajoAsignadoController = new TrabajoasignadoController();
            $arregloIdTrabajo = ['idTrabajo'=>$idTrabajo];
            $requestIdTrabajo = new Request($arregloIdTrabajo);
            //para crear la conversacion:
            $controllerConversacion= new ConversacionChatController;
            $mensajeChatController = new MensajeChatController;
            //busco la persona asignada
            $trabajoAsignado=$trabajoAsignadoController->buscar($requestIdTrabajo);
            $trabajoAsignado= json_decode($trabajoAsignado);
            $trabajoAsignado = $trabajoAsignado[0];
            $idPersona1= $trabajoAsignado->idPersona;
            //busco la persona que creo el trabajo
            $trabajoController= new TrabajoController;
            $trabajo=$trabajoController->buscar($requestIdTrabajo);
            $trabajo= json_decode($trabajo);
            $trabajo = $trabajo[0];
            $tituloTrabajo = $trabajo->titulo;
            $idPersona2= $trabajo->idPersona;

            
            //creo la conversacion
            $arregloConversacion = ['idTrabajo'=>$idTrabajo,'idPersona1'=>$idPersona1,'idPersona2'=>$idPersona2];
            $arregloConversacion = new Request($arregloConversacion);
            $controllerConversacion->store($arregloConversacion);
            $ultimaConversacion = ConversacionChat::orderby('idConversacionChat', 'desc')->first();
            $idConversacionChat = $ultimaConversacion->idConversacionChat;
            $trabajoAsignadoController->enviarMailConfirmacionAsignado($requestIdTrabajo);
            $mensaje = 'Se ha habilitado un chat por el anuncio: ' . $tituloTrabajo;
            $arregloMensaje = ['idPersona'=>7,'mensaje'=>$mensaje,'idConversacionChat'=>$idConversacionChat,'visto'=>true, 'fechaVisto'=>now()];
            $arregloMensaje = new Request($arregloMensaje);
            $mensajeChatController->store($arregloMensaje);
            header("Location: http://localhost/LoHagoPorVosLaravel/public");
            exit;
        } catch (Exception $e){

        }
        
    } else {
        echo "La información proporcionada no es suficiente para poder realizar la acción";
    }
?>