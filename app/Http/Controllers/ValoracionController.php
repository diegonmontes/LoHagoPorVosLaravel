<?php

namespace App\Http\Controllers;
//Autenticacion
use Auth;

use Illuminate\Http\Request;
use App\Valoracion;
use App\Trabajo;
use App\Persona;
use App\Estadotrabajo;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ValoracionController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $valoraciones=Valoracion::orderBy('idValoracion','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('valoracion.index',compact('valoraciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        return view('valoracion.create',['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        //Validamos los datos antes de guardar el elemento nuevo
        $this->validate($request,[ 'valor'=>'required', 'idTrabajo'=>'required']);
        $usandoFlutter = false; // Inicializamos en false
        $controller= new Controller;

        $idTrabajo = $request->idTrabajo;
        $trabajoController = new TrabajoController();
        $arregloBuscarTrabajo = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
        $trabajo = Trabajo::where('idTrabajo',$idTrabajo)->get();
        $trabajo = $trabajo[0];
            
        if (isset($request['flutter']) && $request['flutter']==true){ // Significa que la peticion viene desde flutter
            $usandoFlutter = true; // Si viene de flutter, seteamos a true
            $idPersonaLogeada = $request->idPersona;  
        } else { // Significa que esta en laravel y obtenemos el id persona
            $personaController = new PersonaController();
            $idUsuario = Auth::user()->idUsuario; // Obtenemos el id usuario para obtener el id persona
            $arregloBuscarPersona = ['idUsuario'=>$idUsuario];
            $arregloBuscarPersona = new Request($arregloBuscarPersona);
            $listaPersona = $personaController->buscar($arregloBuscarPersona);
            $listaPersona = json_decode($listaPersona);
            $persona = $listaPersona[0];
            $idPersonaLogeada = $persona->idPersona;
        }

        if ($trabajo->idPersona==$idPersonaLogeada){ // Significa que esta valorando el creador del anuncio
            // Hacemos la busqueda del trabajo en trabajo aspirante para obtener el id del aspirante
            $trabajoAspiranteController = new TrabajoaspiranteController();
            $arregloBuscarTrabajoAspirante = ['idTrabajo'=>$idTrabajo];
            $arregloBuscarTrabajoAspirante = new Request($arregloBuscarTrabajoAspirante);
            $listaTrabajoAspirante = $trabajoAspiranteController->buscar($arregloBuscarTrabajoAspirante);
            $listaTrabajoAspirante = json_decode($listaTrabajoAspirante);
            $trabajoAspirante = $listaTrabajoAspirante[0]; // Obtenemos el obj
            $request['idPersona'] = $trabajoAspirante->idPersona;
        } else { // Significa que el aspirante esta valorando al creador del anuncio
            $request['idPersona'] = $trabajo->idPersona;  // Seteamos al id persona del creador del anuncio
        }



        if(isset($request['imagenValoracion']) && $request['imagenValoracion']!=null){
            if ($usandoFlutter){ // Significa que el nombre de la img viene por parametro
                $nombreImagen = $request['nombreImagen'];
                $posicion = strrpos($nombreImagen,'.');
                $extension = substr($nombreImagen,$posicion);
                $imagen = base64_decode($request['imagenValoracion']); // Decodificamos la img
                $request['imagenValoracion'] = 'valoracion'.$request['idPersona'].'-'.date("YmdHms").'.'.$extension; // Definimos el nombre
                //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                Storage::disk('valoracion')->put($request['imagenValoracion'], $imagen);            
            } else { // Significa que esta en laravel, no tenemos el nombre de la img ni su formato
                $imagen=$request->file('imagenValoracion'); // Obtenemos el obj de la img
                $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
                $nombreImagen = 'valoracion'.$request['idPersona'].'-'.date("YmdHms").'.'.$extension; // Definimos el nombre
                $request = $request->except('imagenValoracion'); // Guardamos todo el obj sin la clave imagen valoracion
                $request['imagenValoracion']=$nombreImagen; // Asignamos de nuevo a imagenValoracion, su nombre
                $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                $imagen = File::get($imagen);
                
                Storage::disk('valoracion')->put($nombreImagen, $imagen);        
            }
            //llamamos a la funcion que valida la imagen
            $validoImagen = $controller->validarImagen($imagen,1);
            
        } else { // Si no carga ninguna imagen, seteamos por defecto el valor a true
            $validoImagen = true;
        }

        if(isset($request->comentarioValoracion) && $request['comentarioValoracion'] !=null){ // Significa que escribio un comentario
            $comentarioValoracion = $request->comentarioValoracion;
            $validoComentario=$controller->moderarTexto($comentarioValoracion,1); // 1 Significa que evaluamos la variable terms
        } else { // Significa que no ingreso ningun comentario
            $validoComentario = true;
        }
        
        $errores="";
        if (!($validoComentario)){
            $errores.="Comentario ";
        }

        if (!($validoImagen)){
            $errores.= "Imagen ";
        }
        
        if ($validoImagen && $validoComentario){ // Si estan valodado los dos campos
            if (Valoracion::create($request->all())){ // Si crea la valoracion
                if ($usandoFlutter){ // Si esta en flutter
                    return $respuesta = ['success'=>true];
                } else { // Si esta en laravel
                    return response()->json([
                        'url' => route('inicio'),
                        'success'   => true,
                        'message'   => 'Los datos se han guardado correctamente.' 
                        ], 200);
                }
            } else {
                $respuesta = ['success'=>false];
            }
        } else {
            $errores.='con contenido indebido. Por favor cambielo.';
            if ($usandoFlutter){
                $respuesta = ['success'=>false, 'error'=>$errores];
            } else {
                $errores = array();
                if (!($validoComentario)){
                    $errores["comentario"] = [0 => "Comentario con contenido indebido. Por favor cambielo."];
                }
        
                if (!($validoImagen)){
                    $errores["imagen"] = [0=>"Imagen con contenido indebido. Por favor cambielo."];
                }
                return response()->json([
                    'success'   => false,
                    'errors'   =>  $errores 
                    ], 422);
            }
        }
        return response()->json($respuesta);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $valoraciones=Valoracion::find($id); //Buscamos el elemento para mostrarlo
        return  view('valoracion.show',compact('valoraciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        $valoracion=Valoracion::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('valoracion.edit',compact('valoracion'),['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        //Buscamos el usuario
        //Validamos los datos antes de guardar el elemento nuevo
        $this->validate($request,[ 'valor'=>'required', 'idTrabajo'=>'required']);
        Valoracion::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('valoracion.index')->with('success','Registro actualizado satisfactoriamente');
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
        Valoracion::where('idValoracion',$id)->update(['eliminado'=>1]);
        //Valoracion::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('valoracion.index')->with('success','Registro eliminado satisfactoriamente');
    }

    // Permite buscar todas las valoraciones de un trabajo
    public function buscar(Request $param){      
        $query = Valoracion::OrderBy('idValoracion','ASC'); // Ordenamos las valoraciones por este medio

            if (isset($param->idValoracion)){
                $query->where("valoracion.idValoracion",$param->idValoracion);
            }

            if (isset($param->valor)){
                $query->where("valoracion.valor",$param->valor);
            }

            if (isset($param->idTrabajo)){
                $query->where("valoracion.idTrabajo",$param->idTrabajo);
            }

            if (isset($param->idPersona)){
                $query->where("valoracion.idPersona",$param->idPersona);
            }

            if (isset($param->eliminado)){
                $query->where("valoracion.eliminado",$param->eliminado);
            }

            $listaValoraciones=$query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaValoraciones);
    }

    public function valorarpersona(Request $request){
        $idTrabajo = $request->idTrabajo;
        //Buscamos la persona asignada que termino el trabajo
        $controlTrabajoAsignado = new TrabajoasignadoController;
        //Creamos el arreglo $param que lo utilizaremos para crear el Request y buscar el trabajo asignado
        $paramTrabajoAsignado = new Request(['idTrabajo'=>$idTrabajo,'eliminado'=>0]);
        $trabajoAsignado = $controlTrabajoAsignado->buscar($paramTrabajoAsignado);
        $trabajoAsignado = json_decode($trabajoAsignado);
        //Ahora obtenemos el idPersona
        $idPersona = $trabajoAsignado[0]->idPersona;
        //Y buscamos la persona
        $controlPersona = new PersonaController;
        $paramControlPersona = new Request(['idPersona'=>$idPersona, 'eliminado'=>0]);
        $persona = $controlPersona->buscar($paramControlPersona);
        $persona = json_decode($persona);
        $persona = $persona[0];
        //valoracion
        $stars = $request->stars;
        $valoracion = new Valoracion;
        $paramValoracion = ['idTrabajo'=>$idTrabajo,'idPersona'=>$idPersona,'valor'=>$stars];
        $valoracion::create($paramValoracion);
        //Actualizamos el estado del trabajo a finalizado
        $trabajo = new Trabajo;
        $trabajo->where('idTrabajo','=', $idTrabajo)->update(['idEstado'=>5]);
        //Creamos estadotrabajo con el estado en 1
        $paramEstadotrabajo = ['idTrabajo'=>$idTrabajo,'idEstado'=>5];
        $requesEstadoTrabajo = new Request($paramEstadotrabajo);
        Estadotrabajo::create($requesEstadoTrabajo->all());
        return redirect()->route('inicio')->with('success','Gracias por valorar');

    }
}
