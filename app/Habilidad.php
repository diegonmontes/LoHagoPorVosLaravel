<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    protected $table='habilidad';
    protected $primaryKey = 'idHabilidad';
    protected $fillable = ['idHabilidad', 'nombreHabilidad','descripcionHabilidad','imagenHabilidad','eliminado'];

    public function HabilidadPersona()
    {
        return $this->hasMany('App\HabilidadPersona', 'idHabilidad', 'idHabilidad');
    }

}
