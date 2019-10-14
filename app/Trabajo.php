<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    //
    protected $table='trabajo';
    protected $primaryKey='idTrabajo';
    protected $fillable = ['idTrabajo', 'idEstado', 'idCategoriaTrabajo', 'idPersona', 'idLocalidad','titulo','descripcion','monto', 'imagenTrabajo', 'tiempoExpiracion','eliminado'];

    public function CategoriaTrabajo() {
        return $this->belongTo('App\CategoriaTrabajo', 'idCategoriaTrabajo', 'idCategoriaTrabajo');
    }

    public function Persona() {
        return $this->belongTo('App\Persona', 'idPersona', 'idPersona');
    }

    public function Localidad() {
        return $this->belongTo('App\Localidad', 'idLocalidad', 'idLocalidad');
    }

    public function Estado() {
        return $this->belongTo('App\Estado', 'idEstado', 'idEstado');
    }

    public function Valoracion() {
        return $this->hasMany('App\Valoracion', 'idTrabajo', 'idTrabajo');
    }

    public function Trabajoaspirantes() {
        return $this->hasMany('App\Trabajoaspirantes', 'idTrabajo', 'idTrabajo');
    }

    

}

