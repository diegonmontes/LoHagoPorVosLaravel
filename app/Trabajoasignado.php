<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajoasignado extends Model
{
    //
    protected $table='trabajoasignado';
    protected $primaryKey='idTrabajoAsignado';
    protected $fillable = ['idTrabajoAsignado', 'idTrabajo', 'idPersona','eliminado'];


    public function Trabajo() {
        return $this->hasOne('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Persona() {
        return $this->hasOne('App\Persona', 'idPersona', 'idPersona');
    }
}
