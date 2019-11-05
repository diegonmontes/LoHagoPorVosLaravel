<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Habilidad;
use App\HabilidadPersona;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HabilidadPersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
    $habilidadesPersona=HabilidadPersona::orderBy('idHabilidadPersona','DESC')->where('eliminado','0')->paginate(15);
    return view('habilidadpersona.index',compact('habilidadesPersona'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arregloBuscarHabilidades=['eliminado'=>0];
        $arregloBuscarHabilidades = new Request($arregloBuscarHabilidades);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas= new Request($arregloBuscarPersonas);
        $habilidadController = new HabilidadController();
        $personaController = new PersonaController();
        $listaHabilidades=$habilidadController->buscar($arregloBuscarHabilidades);
        $listaHabilidades = json_decode($listaHabilidades);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        return view('habilidadpersona.create',['listaPersonas'=>$listaPersonas,'listaHabilidades'=>$listaHabilidades]); //Vista para crear el elemento nuevo

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 'idHabilidad'=>'required', 'idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        HabilidadPersona::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('habilidadpersona.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $habilidadPersona=HabilidadPersona::find($id); //Buscamos el elemento para mostrarlo
        return  view('habilidadpersona.show',compact('habilidadPersona'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arregloBuscarHabilidades=['eliminado'=>0];
        $arregloBuscarHabilidades = new Request($arregloBuscarHabilidades);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas= new Request($arregloBuscarPersonas);
        $habilidadController = new HabilidadController();
        $personaController = new PersonaController();
        $listaHabilidades=$habilidadController->buscar($arregloBuscarHabilidades);
        $listaHabilidades = json_decode($listaHabilidades);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        $habilidadPersona=HabilidadPersona::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('habilidadpersona.edit',compact('habilidadPersona'),['listaPersonas'=>$listaPersonas,'listaHabilidades'=>$listaHabilidades]);
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
        $this->validate($request,[ 'idHabilidad'=>'required' ,'idPersona'=>'required']); //Validamos los datos antes de actualizar
        HabilidadPersona::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('habilidadpersona.index')->with('success','Registro actualizado satisfactoriamente');
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
        HabilidadPersona::where('idHabilidadPersona',$id)->update(['eliminado'=>1]);
        //HabilidadPersona::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('habilidadpersona.index')->with('success','Registro eliminado satisfactoriamente');
    }

    // Permite buscar todas las habilidades de las personas
    public function buscar(Request $param){      
        $query = HabilidadPersona::OrderBy('idHabilidadPersona','ASC'); // Ordenamos las habilidades de las personas por este medio

            if (isset($param->idHabilidadPersona)){
                $query->where("habilidadpersona.idHabilidadPersona",$param->idHabilidadPersona);
            }

            if (isset($param->idHabilidad)){
                $query->where("habilidadpersona.idHabilidad",$param->idHabilidad);
            }

            if (isset($param->idPersona)){
                $query->where("habilidadpersona.idPersona",$param->idPersona);
            }

            if (isset($param->eliminado)){
                $query->where("habilidadpersona.eliminado",$param->eliminado);
            }
            $listaHabilidadPersona=$query->get();   // Hacemos el get y seteamos en lista
            
            return json_encode($listaHabilidadPersona);
    }


}
