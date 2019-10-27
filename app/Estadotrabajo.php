<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadotrabajo extends Model
{
    protected $table='estadotrabajo';
    protected $primaryKey='idEstadoTrabajo';
    protected $fillable = ['idEstadoTrabajo', 'idTrabajo', 'idEstado','eliminado'];

    public function Trabajo() {
        return $this->hasOne('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Estado() {
        return $this->hasOne('App\Estado', 'idEstado', 'idEstado');
    }
}
