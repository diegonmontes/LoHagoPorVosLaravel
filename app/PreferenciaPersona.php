<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreferenciaPersona extends Model
{
    protected $table='preferenciapersona';
    protected $primaryKey='idPreferenciaPersona';
    protected $fillable = ['idPreferenciaPersona', 'idCategoriaTrabajo', 'idPersona','eliminado'];


    public function CategoriaTrabajo() {
        return $this->hasOne('App\CategoriaTrabajo', 'idCategoriaTrabajo', 'idCategoriaTrabajo');
    }

    public function Persona() {
        return $this->hasOne('App\Persona', 'idPersona', 'idPersona');
    }
}
