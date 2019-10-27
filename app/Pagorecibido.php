<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagorecibido extends Model
{
    //
    protected $table='pagorecibido';
    protected $primaryKey = 'idPagoRecibido';
    protected $fillable = ['idPagoRecibido', 'idTrabajo','idPago','monto','metodo','tarjeta','fechapago','fechaaprobado','eliminado'];

    public function Trabajo()
    {
        return $this->hasOne('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

}
