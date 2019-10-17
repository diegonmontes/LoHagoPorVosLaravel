<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use MercadoPago;


class MercadoPagoController extends Controller{

    public function crearPago(Request $produto){
        MercadoPago\SDK::setClientId("7175237490278996");
        MercadoPago\SDK::setClientSecret("bCl5t1V2TZAKKJKZ3Ss7qYebcqu6j33J");
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

        $preference->items = array($item2);
        $preference->save();

        return json_encode($preference->sandbox_init_point);
    }
}