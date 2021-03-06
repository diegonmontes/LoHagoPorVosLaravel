<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\CategoriaTrabajo;
use App\PreferenciaPersona;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PreferenciaPersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preferenciasPersona=PreferenciaPersona::orderBy('idPreferenciaPersona','DESC')->where('eliminado','0')->paginate(15);
        return view('preferenciapersona.index',compact('preferenciasPersona'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriaTrabajoController = new CategoriaTrabajoController();
        $personaController = new PersonaController();

        $arregloBuscarCategorias=['eliminado'=>0];
        $arregloBuscarCategorias = new Request($arregloBuscarCategorias);
        $listaCategorias = $categoriaTrabajoController->buscar($arregloBuscarCategorias);
        $listaCategorias = json_decode($listaCategorias);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $listaPersonas = $personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);

        return view('preferenciapersona.create',['listaPersonas'=>$listaPersonas,'listaCategorias'=>$listaCategorias]); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 'idCategoriaTrabajo'=>'required', 'idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        PreferenciaPersona::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('preferenciapersona.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $preferenciaPersona=PreferenciaPersona::find($id); //Buscamos el elemento para mostrarlo
        return  view('preferenciapersona.show',compact('preferenciaPersona'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoriaTrabajoController = new CategoriaTrabajoController();
        $personaController = new PersonaController();

        $arregloBuscarCategorias=['eliminado'=>0];
        $arregloBuscarCategorias = new Request($arregloBuscarCategorias);
        $listaCategorias = $categoriaTrabajoController->buscar($arregloBuscarCategorias);
        $listaCategorias = json_decode($listaCategorias);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $listaPersonas = $personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);

        $preferenciaPersona=PreferenciaPersona::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('preferenciapersona.edit',compact('preferenciaPersona'),['listaPersonas'=>$listaPersonas,'listaCategorias'=>$listaCategorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[ 'idCategoriaTrabajo'=>'required' ,'idPersona'=>'required']); //Validamos los datos antes de actualizar
        PreferenciaPersona::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('preferenciapersona.index')->with('success','Registro actualizado satisfactoriamente');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Actualizamos eliminado a 1 (Borrado lógico)
        PreferenciaPersona::where('idPreferenciaPersona',$id)->update(['eliminado'=>1,'updated_at'=>now()]);
        //PreferenciaPersona::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('preferenciapersona.index')->with('success','Registro eliminado satisfactoriamente');
    }

    // Permite buscar todas las preferencias
    public function buscar(Request $param){      
        $query = PreferenciaPersona::OrderBy('idPreferenciaPersona','ASC'); // Ordenamos las preferencias por este medio

            if (isset($param->idPreferenciaPersona)){
                $query->where("preferenciapersona.idPreferenciaPersona",$param->idPreferenciaPersona);
            }

            if (isset($param->idCategoriaTrabajo)){
                $query->where("preferenciapersona.idCategoriaTrabajo",$param->idCategoriaTrabajo);
            }

            if (isset($param->idPersona)){
                $query->where("preferenciapersona.idPersona",$param->idPersona);
            }

            if (isset($param->eliminado)){
                $query->where("preferenciapersona.eliminado",$param->eliminado);
            }

            $listaPreferenciaPersona=$query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaPreferenciaPersona);
    }
}
