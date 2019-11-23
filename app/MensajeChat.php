<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeChat extends Model
{

    protected $table='mensajechat';
    protected $primaryKey='idMensajeChat';
    protected $fillable = ['idMensajeChat','idConversacionChat', 'idPersona', 'mensaje', 'visto', 'fechaVisto','eliminado'];  

    public function ConversacionChat() {
        return $this->hasOne('App\ConversacionChat', 'idConversacionChat', 'idConversacionChat');
    }

    public function Persona() {
        return $this->belongsTo('App\Persona', 'idPersona', 'idPersona');
    }

}
