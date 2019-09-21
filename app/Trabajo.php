<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    //
    protected $table='trabajo';
    protected $primaryKey='idTrabajo';
    protected $fillable = ['idTrabajo', 'idPersona','idTipoTrabajo','idCategoriaTrabajo','titulo','descripcion','monto','eliminado'];
}
