<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Comentario extends Model
{
    protected $table='comentario';
    protected $primaryKey = 'idComentario';
    protected $fillable = [
        'contenido', 'idComentarioPadre', 'idTrabajo', 'idPersona','idComentario'
    ];
 
    public function Trabajo() 
    {
        return $this->belongsTo('App\Trabajo', 'idTrabajo');
    }
 
    public function Persona() 
    {
        return $this->belongsTo('App\Persona', 'idPersona');
    }
 
    public function Parent() 
    {
        return $this->belongsTo('App\Comentario', 'idComentarioPadre');
    }
 
    public function Replies() 
    {
        return $this->hasMany('App\Comentario', 'idComentarioPadre');
    }

    
    public function User() 
    {
        return $this->belongsTo('App\User', 'idPersona');
    }

}