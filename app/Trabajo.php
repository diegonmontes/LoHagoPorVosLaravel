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
        return $this->hasOne('App\CategoriaTrabajo', 'idCategoriaTrabajo', 'idCategoriaTrabajo');
    }

    public function Persona() {
        return $this->hasOne('App\Persona', 'idPersona', 'idPersona');
    }

    public function Localidad() {
        return $this->hasOne('App\Localidad', 'idLocalidad', 'idLocalidad');
    }

    public function Estado() {
        return $this->belongsTo('App\Estado', 'idEstado', 'idEstado');
    }

    public function Pagorecibido() {
        return $this->hasOne('App\Pagorecibido', 'idTrabajo', 'idTrabajo');
    }

    public function Trabajoaspirante() {
        return $this->hasMany('App\Trabajoaspirante', 'idTrabajo', 'idTrabajo');
    }

    public function Trabajoasignado() {
        return $this->hasMany('App\Trabajoasignado', 'idTrabajo', 'idTrabajo');
    }

    public function ConversacionChat() {
        return $this->hasMany('App\ConversacionChat', 'idTrabajo', 'idTrabajo');
    }

    public function Valoracion()
    {
        return $this->hasMany('App\Valoracion', 'idValoracion', 'idValoracion');
    }
    
    public function Comentarios() 
    {
        return $this->hasMany('App\Comentario', 'idTrabajo')->whereNull('idComentarioPadre');
    }

    public function Multa() {
        return $this->hasOne('App\Multa', 'idTrabajo', 'idTrabajo');
    }


}