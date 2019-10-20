<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajoasignado extends Model
{
    //
    protected $table='trabajoasignado';
    protected $primaryKey='idTrabajoasignado';
    protected $fillable = ['idTrabajoaspirante', 'idTrabajo', 'idPersona','eliminado'];


    public function Trabajo() {
        return $this->belongTo('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Persona() {
        return $this->belongTo('App\Persona', 'idPersona', 'idPersona');
    }
}
