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

    public function misAsignaciones(Request $request){
        $idPersona=$request->idPersona;
        //Con el idPersona buscamos los trabajos asignados
        $listaTrabajosAsignados = Trabajoasignado::select('trabajoasignado.idTrabajo')
                                                    ->join('trabajo','trabajo.idTrabajo','=','trabajoasignado.idTrabajo')
                                                    ->join('pagorecibido','trabajo.idTrabajo','=','pagorecibido.idTrabajo')
                                                    ->where('trabajoasignado.idPersona','=',$idPersona)
                                                    ->where('trabajoasignado.eliminado','=',0)
                                                    ->where('trabajo.idEstado','=',3)
                                                    ->get();
                                                    $lista=array();
                                                    $trabajoController= new TrabajoController;
                                                    foreach($listaTrabajosAsignados as $trabajo){
                                                        $idTrabajo=$trabajo->idTrabajo;
                                                        $param=['idTrabajo'=>$idTrabajo];
                                                        $param=new Request($param);
                                                        $objTrabajo=$trabajoController->buscar($param);
                                                        $objTrabajo=\json_decode($objTrabajo);
                                                        array_push($lista,$objTrabajo);
                                                    }
                                                    return \json_encode($lista);
    }
    // Recibimos por parametro el id trabajo. Enviamos a la funcion del email controller el obj trabajo, obj persona creador de este, objpersona y objusuario del asignado 
    public function enviarMailConfirmacionAsignado(request $request){

        // Hacemos la creacion de los objs controladores
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $usuarioController = new UserController();
        
        $idTrabajo = $request->idTrabajo; // Obtenemos el id del trabajo para buscar el trabajo 

        // Obtenemos el trabajo que se asigno
        $arregloBuscarTrabajo = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
        $listaTrabajo = $trabajoController->buscar($arregloBuscarTrabajo);
        $listaTrabajo = json_decode($listaTrabajo);
        $objTrabajo = $listaTrabajo[0];

        // Obtenemos el idPersona del creador del trabajo

        $idPersonaCreador = $objTrabajo->idPersona;
        $arregloBuscarPersonaCreador = ['idPersona'=>$idPersonaCreador];
        $arregloBuscarPersonaCreador = new Request($arregloBuscarPersonaCreador);
        $listaPersonaCreador = $personaController->buscar($arregloBuscarPersonaCreador);
        $listaPersonaCreador = json_decode($listaPersonaCreador);
        $objPersonaCreador = $listaPersonaCreador[0];

        // Buscamos el trabajo asignado
        $arregloBuscarTrabajoAsignado = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajoAsignado = new Request($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = $this->buscar($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = json_decode($listaTrabajoAsignado);
        $objTrabajoAsignado = $listaTrabajoAsignado[0]; // Obtenemos el trabajo asignado

        // Obtenemos el idPersona de la persona asignada del trabajo

        $idPersonaAsignado = $objTrabajoAsignado->idPersona;
        $arregloBuscarPersonaAsignada = ['idPersona'=>$idPersonaAsignado];
        $arregloBuscarPersonaAsignada = new Request($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = $personaController->buscar($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = json_decode($listaPersonaAsignada);
        $objPersonaAsignado = $listaPersonaAsignada[0];

        // Obtenemos el usuario de la persona asignada del trabajo (en ella esta su mail)
       
        $idUsuarioAsignado = $objPersonaAsignado->idUsuario;
        $arregloBuscarUsuarioAsignado = ['idUsuario'=>$idUsuarioAsignado];
        $arregloBuscarUsuarioAsignado = new Request($arregloBuscarUsuarioAsignado);
        $listaUsuarioAsignado = $usuarioController->buscar($arregloBuscarUsuarioAsignado);
        $listaUsuarioAsignado = json_decode($listaUsuarioAsignado);
        $objUsuarioAsignado = $listaUsuarioAsignado[0];

        $mail = new EmailController;
        if ($mail->enviarMailConfirmacionAsignado($objUsuarioAsignado,$objPersonaAsignado,$objTrabajo,$objPersonaCreador)){
            $respuesta = true;
        } else {
            $respuesta = false;
        }
        return $respuesta;
    }

    // Recibimos por parametro el id trabajo. Enviamos a la funcion del email controller el obj trabajo, obj persona creador de este, objpersona y objusuario del asignado 
    public function enviarMailFinalizado(request $request){
        // Hacemos la creacion de los objs controladores
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $usuarioController = new UserController();
        
        $idTrabajo = $request->idTrabajo; // Obtenemos el id del trabajo para buscar el trabajo 

        // Obtenemos el trabajo que se asigno
        $arregloBuscarTrabajo = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
        $listaTrabajo = $trabajoController->buscar($arregloBuscarTrabajo);
        $listaTrabajo = json_decode($listaTrabajo);
        $objTrabajo = $listaTrabajo[0];

        // Obtenemos el idPersona del creador del trabajo

        $idPersonaCreador = $objTrabajo->idPersona;
        $arregloBuscarPersonaCreador = ['idPersona'=>$idPersonaCreador];
        $arregloBuscarPersonaCreador = new Request($arregloBuscarPersonaCreador);
        $listaPersonaCreador = $personaController->buscar($arregloBuscarPersonaCreador);
        $listaPersonaCreador = json_decode($listaPersonaCreador);
        $objPersonaCreador = $listaPersonaCreador[0];

        // Buscamos el trabajo asignado
        $arregloBuscarTrabajoAsignado = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajoAsignado = new Request($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = $this->buscar($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = json_decode($listaTrabajoAsignado);
        $objTrabajoAsignado = $listaTrabajoAsignado[0]; // Obtenemos el trabajo asignado

        // Obtenemos el idPersona de la persona asignada del trabajo

        $idPersonaAsignado = $objTrabajoAsignado->idPersona;
        $arregloBuscarPersonaAsignada = ['idPersona'=>$idPersonaAsignado];
        $arregloBuscarPersonaAsignada = new Request($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = $personaController->buscar($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = json_decode($listaPersonaAsignada);
        $objPersonaAsignado = $listaPersonaAsignada[0];

        // Obtenemos el usuario de la persona asignada del trabajo (en ella esta su mail)
    
        $idUsuarioAsignado = $objPersonaAsignado->idUsuario;
        $arregloBuscarUsuarioAsignado = ['idUsuario'=>$idUsuarioAsignado];
        $arregloBuscarUsuarioAsignado = new Request($arregloBuscarUsuarioAsignado);
        $listaUsuarioAsignado = $usuarioController->buscar($arregloBuscarUsuarioAsignado);
        $listaUsuarioAsignado = json_decode($listaUsuarioAsignado);
        $objUsuarioAsignado = $listaUsuarioAsignado[0];

        $mail = new EmailController;
        if ($mail->enviarMailFinalizado($objUsuarioAsignado,$objPersonaAsignado,$objTrabajo,$objPersonaCreador)){
            $respuesta = true;
        } else {
            $respuesta = false;
        }
        return $respuesta;
    }


  
}
