<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valoracion;
use App\Trabajo;
use App\Persona;


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
        $valoraciones=Valoracion::orderBy('idValoracion','DESC')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
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
        //Creamos el elemento nuevo
        Valoracion::create($request->all());
        return redirect()->route('valoracion.index')->with('success','Registro creado satisfactoriamente');
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
        Valoracion::find($id)->delete(); //Buscamos y eliminamos el elemento
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

            $listaTrabajoAsignado=$query->get();   // Hacemos el get y seteamos en lista
            return $listaTrabajoAsignado;
    }

}
