<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Trabajo;
use App\Comentario;
use App\Persona;

use Auth;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $idUsuario = Auth::user()->idUsuario; // Obtenemos el id usuario para obtener el id persona
        $persona = Persona::where('idUsuario','=',$idUsuario)->get();
        $idPersona=$persona[0]->idPersona;

        $idTrabajo = $request->idTrabajo;
        $trabajo = Trabajo::find($idTrabajo);
        $comentario = new Comentario();
        $comentario->contenido = $request->contenido;
        $comentario->idComentarioPadre = $request->idComentarioPadre;
        $comentario->idPersona = $idPersona;
        $comentario->idTrabajo = $idTrabajo;
 
        $trabajo->Comentarios()->save($comentario);
 
        return \redirect()->route('veranuncio', $idTrabajo);
    }
}