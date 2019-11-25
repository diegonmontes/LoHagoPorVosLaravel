<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversacionChat extends Model
{
    protected $table='conversacionchat';
    protected $primaryKey='idConversacionChat';
    protected $fillable = ['idConversacionChat', 'idTrabajo', 'idPersona1', 'idPersona2','deshabilitado','eliminado'];  

    public function Trabajo() {
        return $this->hasOne('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Persona1() {
        return $this->hasOne('App\Persona', 'idPersona', 'idPersona1');
    }

    public function Persona2() {
        return $this->hasOne('App\Persona', 'idPersona', 'idPersona2');
    }

    public function MensajeChat() {
        return $this->hasMany('App\MensajeChat', 'idPersona', 'idPersona');
    }

}
