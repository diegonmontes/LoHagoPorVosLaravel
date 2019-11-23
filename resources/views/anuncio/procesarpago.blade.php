@php
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PagorecibidoController;
use App\Http\Controllers\TrabajoasignadoController;
use Illuminate\Http\Request;
use App\Estadotrabajo;
use App\Trabajo;



    if ($_GET!=null){
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
        //busco la persona asignada
        $trabajoAsignado=$trabajoAsignadoController->buscar($requestIdTrabajo);
        $trabajoAsginado= json_decode($trabajoAsignado);
        $idPersona1= $trabajoAsignado->idPersona;
        //busco la persona que creo el trabajo
        $trabajoController= new TrabajoController;
        $trabajo=$trabajoController->buscar($requestIdTrabajo);
        $trabajo= json_decode($trabajo);
        $idPersona2= $trabajo->idPersona;
        //creo la conversacion
        $arregloConversacion = ['idTrabajo'=>$idTrabajo,'idPersona1'=>$idPersona1,'idPersona2'=>$idPersona2];
        $arregloConversacion = new Request($arregloConversacion);
        ConversacionChat::create($arregloConversacion);
        $trabajoAsignadoController->enviarMailConfirmacionAsignado($requestIdTrabajo);

        header("Location: http://localhost/LoHagoPorVosLaravel/public/");
        exit;
    } else {
        echo "La información proporcionada no es suficiente para poder realizar la acción";
    }
@endphp
