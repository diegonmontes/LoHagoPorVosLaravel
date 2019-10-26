<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    protected $table='persona';
    protected $primaryKey = 'idPersona';
    protected $fillable = ['idPersona', 'nombrePersona','apellidoPersona','dniPersona','telefonoPersona', 'imagenPersona','idLocalidad','idUsuario','eliminado'];

    public function Localidad()
    {
        return $this->hasMany('App\Localidad', 'idLocalidad', 'idPersona');
    }

    public function User()
    {
        return $this->hasOne('App\User', 'idUsuario', 'idUsuario');
    }

    public function Trabajo()
    {
        return $this->hasMany('App\Trabajo', 'idPersona', 'idPersona');
    }

    public function Valoracion()
    {
        return $this->hasMany('App\Valoracion', 'idValoracion', 'idValoracion');
    }

    public function Trabajoaspirante() {
        return $this->hasMany('App\Trabajoaspirante', 'idPersona', 'idPersona');
    }

    public function PreferenciaPersona() {
        return $this->hasMany('App\PreferenciaPersona', 'idPersona', 'idPersona');
    }

    public function HabilidadPersona() {
        return $this->hasMany('App\HabilidadPersona', 'idPersona', 'idPersona');
    }

    public function ConversacionChat() {
        return $this->hasMany('App\ConversacionChat', 'idPersona', 'idPersona1');
    }

    public function MensajeChat() {
        return $this->hasMany('App\MensajeChat', 'idPersona', 'idPersona');
    }



}
