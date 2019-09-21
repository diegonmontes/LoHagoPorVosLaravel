<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTrabajo extends Model
{
    //
    protected $table='tipoTrabajo';
    protected $primaryKey='idTipoTrabajo';
    protected $fillable = ['idTipoTrabajo', 'nombreTipo'];

    public function Trabajo()
    {
        return $this->hasMany('App\Trabajo', 'idTipoTrabajo', 'idTipoTrabajo');
    }

}
