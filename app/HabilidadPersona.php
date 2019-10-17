<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HabilidadPersona extends Model
{
    protected $table='habilidadpersona';
    protected $primaryKey='idHabilidadPersona';
    protected $fillable = ['idHabilidadPersona', 'idHabilidad', 'idPersona','eliminado'];


    public function Habilidad() {
        return $this->hasOne('App\Habilidad', 'idHabilidad', 'idHabilidad');
    }

    public function Persona() {
        return $this->hasOne('App\Persona', 'idPersona', 'idPersona');
    }
}
