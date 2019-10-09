<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadotrabajo extends Model
{
    //
    protected $table='estadotrabajo';
    protected $primaryKey='idEstadotrabajo';
    protected $fillable = ['idEstadotrabajo', 'idTrabajo', 'idEstado'];

    public function Trabajo() {
        return $this->belongTo('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Estado() {
        return $this->belongTo('App\Estado', 'idEstado', 'idEstado');
    }
}
