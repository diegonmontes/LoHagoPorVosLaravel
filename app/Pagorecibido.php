<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagorecibido extends Model
{
    //
    protected $table='pagorecibido';
    protected $primaryKey = 'idPagorecibido';
    protected $fillable = ['idPagorecibido', 'idTrabajo','idPago','monto','metodo','tarjeta','fechapago','fechaaprobado'];

    public function Trabajo() {
        return $this->belongTo('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

}
