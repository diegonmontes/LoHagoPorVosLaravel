<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    protected $table='persona';
    protected $primaryKey = 'idPersona';
    protected $fillable = ['idPersona', 'nombrePersona','apellidoPersona','dniPersona','telefonoPersona','idLocalidad','idUsuario','eliminado'];

    public function Localidad()
    {
        return $this->hasMany('App\Localidad', 'idLocalidad', 'idPersona');
    }

    public function User()
    {
        return $this->hasMany('App\User', 'idUsuario', 'idUsuario');
    }

    public function Trabajo()
    {
        return $this->hasMany('App\Trabajo', 'idPersona', 'idPersona');
    }
}