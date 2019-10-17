<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    protected $table='habilidad';
    protected $primaryKey = 'idHabilidad';
    protected $fillable = ['idHabilidad', 'nombreHabilidad','descripcionHabilidad','eliminado'];

    public function Localidad()
    {
        return $this->hasMany('App\HabilidadPersona', 'idHabilidadPersona', 'idHabilidad');
    }

}
