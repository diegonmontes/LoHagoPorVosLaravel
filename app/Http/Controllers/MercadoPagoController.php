<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;

class MercadoPagoController extends Controller
{
    public function crearPago(Request $produto){
        MercadoPago\SDK::setClientId("8231008415125275");
        MercadoPago\SDK::setClientSecret("SZtF1oMaavyNlIAUezLXcnHfmjZxsKnT");
        $id=$produto['idTrabajo'];
        $titulo=$produto['titulo'];
        $monto=$produto['monto'];
        
        $preference = new MercadoPago\Preference();
        //print_r($preference);
        $item2 = new MercadoPago\Item();
        $item2->id = $id;
        $item2->title = $titulo; 
        $item2->quantity = 1;
        $item2->unit_price = str_replace(',', '.', $monto);
        $redirectSuccess = "localhost/LoHagoPorVosLaravel/public/anuncio/procesarpago?idTrabajo=".$id;
        $preference->items = array($item2);
        $preference->back_urls = array(
            "success" => $redirectSuccess,
            "failure" => "http://www.google.com/failure",
            "pending" => "http://www.google.com/pending"
        );
        $preference->auto_return='approved';
        $preference->save();

        return json_encode($preference->sandbox_init_point);
    }

    public function obtenerInformacionPago($idPago){
        MercadoPago\SDK::setClientId("8231008415125275");
        MercadoPago\SDK::setClientSecret("SZtF1oMaavyNlIAUezLXcnHfmjZxsKnT");
        MercadoPago\SDK::setAccessToken("TEST-8231008415125275-100820-23f7f80f6828cbdb826456b4d1858568-478055454");
        $pago = MercadoPago\Payment::find_by_id($idPago);
      //  print_R($pago);
     //   die();
        return $pago;
    }
}
