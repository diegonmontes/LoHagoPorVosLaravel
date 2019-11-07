<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Trabajoasignado;
use App\Persona;
use App\Trabajo;
use App\Trabajoaspirante;
use App\Estadotrabajo;

class TrabajoasignadoController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $trabajosAsignados=Trabajoasignado::orderBy('idTrabajoAsignado','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('trabajoasignado.index',compact('trabajosAsignados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $arregloBuscarTrabajos=['eliminado'=>0,'idEstado'=>3]; //Estado evaluando postulaciones
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaTrabajos=json_decode($listaTrabajos);
        $listaPersonas=json_decode($listaPersonas);
        return view('trabajoasignado.create',['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]); //Vista para crear el elemento nuevo
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
        $this->validate($request,[ 'idTrabajo'=>'required', 'idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        Trabajoasignado::create($request->all()); //Creamos el elemento nuevo

    
        if(isset($request->flutter)){
            return $respuesta = ['success'=>true];
        }else{
            return redirect()->route('veranuncio',$request->idTrabajo)->with('success','Registro actualizado satisfactoriamente');
        }
    }

    public function storepanel(Request $request)
    {   
        $this->validate($request,[ 'idTrabajo'=>'required', 'idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        Trabajoasignado::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('trabajoasignado.index')->with('success','Registro actualizado satisfactoriamente');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $trabajoasignado=Trabajoasignado::find($id); //Buscamos el elemento para mostrarlo
        return  view('trabajoasignado.show',compact('trabajoasignado'));
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
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaTrabajos=json_decode($listaTrabajos);
        $listaPersonas=json_decode($listaPersonas);
        $trabajoAsignado=Trabajoasignado::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('trabajoasignado.edit',compact('trabajoAsignado'),['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]);
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
        //
        $this->validate($request,[ 'idTrabajo'=>'required' ,'idPersona'=>'required']); //Validamos los datos antes de actualizar
        Trabajoasignado::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('trabajoasignado.index')->with('success','Registro actualizado satisfactoriamente');
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
        Trabajoasignado::where('idTrabajoAsignado',$id)->update(['eliminado'=>1]);
        //Trabajoasignado::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('trabajoasignado.index')->with('success','Registro eliminado satisfactoriamente');
    }

    // Permite buscar todas las asignaciones a un trabajo
    public function buscar(Request $param){      
        $query = Trabajoasignado::OrderBy('idTrabajoAsignado','ASC'); // Ordenamos las asignaciones por este medio

            if (isset($param->idTrabajoAsignado)){
                $query->where("trabajoasignado.idTrabajoAsignado",$param->idTrabajoAsignado);
            }

            if (isset($param->idTrabajo)){
                $query->where("trabajoasignado.idTrabajo",$param->idTrabajo);
            }

            if (isset($param->idPersona)){
                $query->where("trabajoasignado.idPersona",$param->idPersona);
            }

            if (isset($param->eliminado)){
                $query->where("trabajoasignado.eliminado",$param->eliminado);
            }

            $listaTrabajoAsignado=$query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaTrabajoAsignado);
    }

    // Funcion donde generamos todo el arreglo para mostrar los datos en la parte de valoracion
    public function buscarDatosPostulacion(request $request){
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $usuarioController = new UserController();
        $datosPostulacion = array();
        // Realizamos la busqueda del trabajo asignado con ese id trabajo
        $idTrabajo = $request->idTrabajo;
        $arregloBuscarTrabajoAsignado = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajoAsignado = new Request($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = $this->buscar($arregloBuscarTrabajoAsignado);
        $trabajoAsignado = json_decode($listaTrabajoAsignado);
        $trabajoAsignado = $trabajoAsignado[0];

        // Hacemos la busqueda del trabajo
        $arregloBuscarTrabajo = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
        $listaTrabajo = $trabajoController->buscar($arregloBuscarTrabajo);
        $trabajo = json_decode($listaTrabajo);
        $trabajo = $trabajo[0];

        // Realizamos la busqueda de la persona
        $idPersona=$trabajoAsignado->idPersona;
        $arregloBuscarPersona = ['idPersona'=>$idPersona];
        $arregloBuscarPersona = new Request($arregloBuscarPersona);
        $listaPersona = $personaController->buscar($arregloBuscarPersona);
        $persona = json_decode($listaPersona);
        $persona = $persona[0];    
        
        // Realizamos la busqueda del usuario
        $idUsuario=$persona->idUsuario;
        $arregloBuscarUsuario = ['idUsuario'=>$idUsuario];
        $arregloBuscarUsuario = new Request($arregloBuscarUsuario);
        $listaUsuario = $usuarioController->buscar($arregloBuscarUsuario);
        $usuario = json_decode($listaUsuario);
        $usuario = $usuario[0];     

        $datosPostulacion[0] = $usuario;
        $datosPostulacion[1] = $persona;
        $datosPostulacion[2] = $trabajo;

        return json_encode($datosPostulacion);
        
    }

  
}
