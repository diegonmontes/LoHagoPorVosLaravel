<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajoaspirante extends Model
{
    //
    protected $table='trabajoaspirante';
    protected $primaryKey='idTrabajoAspirante';
    protected $fillable = ['idTrabajoAspirante', 'idTrabajo', 'idPersona','eliminado'];

    public function Trabajo() {
        return $this->hasOne('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Persona() {
        return $this->hasMany('App\Persona', 'idPersona', 'idPersona');
    }
}
