<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    protected $table='multa';
    protected $primaryKey='idMulta';
    protected $fillable = ['idMulta', 'idTrabajo', 'idPersona', 'valor', 'motivo', 'fechaPagado','pagado','eliminado'];

    public function Trabajo() {
        return $this->hasOne('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }

    public function Persona() {
        return $this->hasOne('App\Persona', 'idPersona', 'idPersona');
    }
}
