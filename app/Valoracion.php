<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    //
    protected $table='valoracion';
    protected $primaryKey='idValoracion';
    protected $fillable = ['idValoracion', 'valor', 'idTrabajo', 'idPersona'];

    public function Trabajo() {
        return $this->belongTo('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Persona() {
        return $this->belongTo('App\Trabajo', 'idPersona', 'idPersona');
    }
}
