<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    //
    protected $table='valoracion';
    protected $primaryKey='idValoracion';
    protected $fillable = ['idValoracion', 'imagenValoracion', 'comentarioValoracion', 'valor', 'idTrabajo', 'idPersona','eliminado'];

    public function Trabajo() {
        return $this->hasOne('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Persona() {
        return $this->hasOne('App\Persona', 'idPersona', 'idPersona');
    }
}
