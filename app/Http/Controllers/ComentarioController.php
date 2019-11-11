<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Trabajo;
use App\Comentario;
use App\Persona;

use Auth;

class ComentarioController extends Controller
{

    public function index()
    {
        $comentarios=Comentario::orderBy('idComentario','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('comentario.index',compact('comentarios'));
    }

    public function create()
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $comentarioController = new ComentarioController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        $arregloBuscarComentarios=['eliminado'=>0];
        $arregloBuscarComentarios = new Request($arregloBuscarComentarios);
        $listaComentarios = $comentarioController->buscar($arregloBuscarComentarios);
        $listaComentarios = json_decode($listaComentarios);
       
        return view('comentario.create',['listaComentarios'=>$listaComentarios,'listaPersonas'=>$listaPersonas,'listaTrabajos'=>$listaTrabajos]); //Vista para crear el elemento nuevo
    }

    public function store(Request $request)
    {
        if(isset($request['flutter'])){
            $comentario = new Comentario();
            $comentario->contenido = $request->contenido;
            $comentario->idComentarioPadre = $request->idComentarioPadre;
            $comentario->idPersona = $request->idPersona;
            $comentario->idTrabajo = $request->idTrabajo;
     
            $success=Comentario::create($request->all());
        }else{

            $controlTexto = new Controller;
            if($request->contenido == ''){
                $respuesta = response()->json([
                    'success'   => false,
                    'errors'   =>  'Por favor escriba un comentario antes de enviar.'
                    ], 422);
            }else{
                $correcto = $controlTexto->moderarTexto($request->contenido,1);
                if($correcto){
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
                    $respuesta = response()->json([
                        'url' => route('veranuncio', $idTrabajo),
                        'success'   => true,
                        'message'   => 'Se envio el comentario.'
                    ],200);
                }else{
                    $respuesta = response()->json([
                        'success'   => false,
                        'errors'   =>  'Comentario con contenido indebido. Por favor cambielo.'
                        ], 422);
                }
            }
        }
        if(isset($request['flutter'])&& $success){
            return $respuesta = ['success'=>true];
        }elseif(isset($request['flutter']) && !$success){
            return $respuesta = ['success'=>false,
            'error'=>'Ha ocurrido un error'];
        }
        return $respuesta;
    }

    public function edit($id)
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $comentarioController = new ComentarioController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        $arregloBuscarComentarios=['eliminado'=>0];
        $arregloBuscarComentarios = new Request($arregloBuscarComentarios);
        $listaComentarios = $comentarioController->buscar($arregloBuscarComentarios);
        $listaComentarios = json_decode($listaComentarios);
       
        $comentario=Comentario::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('comentario.edit',compact('comentario'),['listaComentarios'=>$listaComentarios,'listaPersonas'=>$listaPersonas,'listaTrabajos'=>$listaTrabajos]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,['idComentario'=>'required','contenido'=>'required','idTrabajo'=>'required','idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        Comentario::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('comentario.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // Actualizamos eliminado a 1 (Borrado lógico)
        Comentario::where('idComentario',$id)->update(['eliminado'=>1]);
        //Comentario::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('comentario.index')->with('success','Registro eliminado satisfactoriamente');
    }

    // Permite buscar todas los comentarios
    public function buscar(Request $param){      
        $query = Comentario::OrderBy('idComentario','ASC'); // Ordenamos los mensajes este medio

            if (isset($param->idComentario)){
                $query->where("comentario.idComentario",$param->idComentario);
            }

            if (isset($param->contenido)){
                $query->where("comentario.contenido",$param->contenido);
            }

            if (isset($param->idComentarioPadre)){
                $query->where("comentario.idComentarioPadre",$param->idComentarioPadre);
            }

            if (isset($param->idTrabajo)){
                $query->where("comentario.idTrabajo",$param->idTrabajo);
            }

            if (isset($param->idPersona)){
                $query->where("comentario.idPersona",$param->idPersona);
            }

            if (isset($param->eliminado)){
                $query->where("comentario.eliminado",$param->eliminado);
            }

            $listaComentarios=$query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaComentarios);
    }

    // Funcion para ordenar los comentarios y mandarselo a flutter flutter
    public function buscarComentarios(Request $param){
        $query = Comentario::OrderBy('idComentario','ASC'); // Ordenamos las postulaciones por este medio
        $query->where("comentario.idTrabajo",$param->idTrabajo);
        $query->where("comentario.idComentarioPadre",null);
        $listaComentariosPadre=$query->get();
        $usuarioController= new UserController;
        $personaController= new PersonaController;
        $listaComentarios=array();
        foreach ($listaComentariosPadre as $comentarioPadre){
            $listaComentariosHijos= array();
            //busco los comentarios hijos y los coloco dentro del padre
            $arregloBuscarHijo = ['eliminado'=>0,'idComentarioPadre'=>$comentarioPadre->idComentario];
            $arregloBuscarHijo = new Request($arregloBuscarHijo);
            $listaHijos = $this->buscar($arregloBuscarHijo);
            $listaHijos = json_decode($listaHijos);
                foreach($listaHijos as $hijo){
                    //busco la persona que hizo el comentario y traigo su usuario
                    $buscarPersona = ['idPersona'=>$hijo->idPersona];
                    $buscarPersona = new Request($buscarPersona);
                    $persona = $personaController->buscar($buscarPersona);
                    $persona = json_decode($persona);
                    $idUsuario= $persona[0]->idUsuario;
                    $buscarUsuario = ['idUsuario'=>$idUsuario];
                    $buscarUsuario = new Request($buscarUsuario);
                    $usuario = $usuarioController->buscar($buscarUsuario);
                    $usuario = json_decode($usuario);
                    $hijo->idPersona = $usuario;
                    array_push($listaComentariosHijos,$hijo);
                }
            $comentarioPadre->hijos = $listaComentariosHijos;
            //busco la persona que hizo el comentario y traigo su usuario
            $buscarPersona = ['idPersona'=>$comentarioPadre->idPersona];
            $buscarPersona = new Request($buscarPersona);
            $persona = $personaController->buscar($buscarPersona);
            $persona = json_decode($persona);
            //print_r($persona);
            $idUsuario= $persona[0]->idUsuario;
            $buscarUsuario = ['idUsuario'=>$idUsuario];
            $buscarUsuario = new Request($buscarUsuario);
            $usuario = $usuarioController->buscar($buscarUsuario);
            $usuario = json_decode($usuario);
            $comentarioPadre->idPersona = $usuario;
            array_push($listaComentarios,$comentarioPadre);
        }
        return json_encode($listaComentarios);
    }


}