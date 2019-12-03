<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Estadotrabajo;
use App\Trabajo;
use App\Estado;

class EstadotrabajoController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $Estadotrabajos=Estadotrabajo::orderBy('idEstadoTrabajo','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('estadotrabajo.index',compact('Estadotrabajos'));
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
        $arregloBuscarEstados=['eliminado'=>0];
        $arregloBuscarEstados = new Request($arregloBuscarEstados);
        $trabajoController = new TrabajoController();
        $estadoController = new EstadoController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaEstados=$estadoController->buscar($arregloBuscarEstados);
        $listaEstados = json_decode($listaEstados);

        return view('estadotrabajo.create',['listaTrabajos'=>$listaTrabajos,'listaEstados'=>$listaEstados]); //Vista para crear el elemento nuevo
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
        $this->validate($request,[ 'idTrabajo'=>'required', 'idEstado'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        Estadotrabajo::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('estadotrabajo.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $Estadotrabajos=Estadotrabajo::find($id); //Buscamos el elemento para mostrarlo
        return  view('estadotrabajo.show',compact('Estadotrabajos'));
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
        $arregloBuscarEstados=['eliminado'=>0];
        $arregloBuscarEstados = new Request($arregloBuscarEstados);
        $trabajoController = new TrabajoController();
        $estadoController = new EstadoController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaEstados=$estadoController->buscar($arregloBuscarEstados);
        $listaEstados = json_decode($listaEstados);
        $estadoTrabajo=Estadotrabajo::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('estadotrabajo.edit',compact('estadoTrabajo'),['listaTrabajos'=>$listaTrabajos,'listaEstados'=>$listaEstados]);
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
        $this->validate($request,[ 'idTrabajo'=>'required' ,'idEstado'=>'required']); //Validamos los datos antes de actualizar
        Estadotrabajo::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('estadotrabajo.index')->with('success','Registro actualizado satisfactoriamente');
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
        Estadotrabajo::where('idEstadoTrabajo',$id)->update(['eliminado'=>1,'updated_at'=>now()]);
        //Estadotrabajo::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('estadotrabajo.index')->with('success','Registro eliminado satisfactoriamente');
    }

    // Esta funcion busca todas los estados del trabajo con parametros que le enviemos
    public function buscar(Request $param){      
        $query = EstadoTrabajo::OrderBy('idEstadoTrabajo','ASC'); // Ordenamos los estados del trabajo por este medio

            if (isset($param->idEstadoTrabajo)){
                $query->where("estadotrabajo.idEstadoTrabajo",$param->idEstadoTrabajo);
            }

            if (isset($param->idTrabajo)){
                $query->where("estadotrabajo.idTrabajo",$param->idTrabajo);
            }

            if (isset($param->idEstado)){
                $query->where("estadotrabajo.idEstado",$param->idEstado);
            }

            if (isset($param->eliminado)){
                $query->where("estadotrabajo.eliminado",$param->eliminado);
            }

            $listaEstadoTrabajo=$query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaEstadoTrabajo);
    }
}
