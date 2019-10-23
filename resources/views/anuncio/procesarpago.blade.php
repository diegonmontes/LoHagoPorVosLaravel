@php
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PagorecibidoController;
use Illuminate\Http\Request;

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
        header("Location: http://localhost/LoHagoPorVosLaravel/public/");
        exit;
    } else {
        echo "La información proporcionada no es suficiente para poder realizar la acción";
    }
@endphp
