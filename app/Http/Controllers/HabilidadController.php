<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Habilidad;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class HabilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $habilidades=Habilidad::orderBy('idHabilidad','ASC')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('habilidad.index',compact('habilidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('habilidad.create'); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 'nombreHabilidad'=>'required', 'descripcionHabilidad'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        Habilidad::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('habilidad.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $habilidades=Habilidad::find($id); //Buscamos el elemento para mostrarlo
        return  view('habilidad.show',compact('habilidades'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $habilidad=Habilidad::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('habilidad.edit',compact('habilidad'));
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
        $this->validate($request,[ 'nombreHabilidad'=>'required' ,'descripcionHabilidad'=>'required']); //Validamos los datos antes de actualizar
        Habilidad::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('habilidad.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Habilidad::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('habilidad.index')->with('success','Registro eliminado satisfactoriamente');
    }

    public function buscarHabilidades(){
        $objHabilidad = new Habilidad();
        $listaHabilidades = $objHabilidad->get();
        return json_encode($listaHabilidades);
    }

    // Esta funcion busca todas las habilidades con parametros que le enviemos
    public function buscar(Request $param){      
        $query = Habilidad::OrderBy('idHabilidad','ASC'); // Ordenamos las habilidades por este medio

            if (isset($param->nombreHabilidad)){
                $query->where("habilidad.nombreHabilidad",$param->nombreHabilidad);
            }

            if (isset($param->descripcionHabilidad)){
                $query->where("habilidad.descripcionHabilidad",$param->descripcionHabilidad);
            }

            if (isset($param->imagenHabilidad)){
                $query->where("habilidad.imagenHabilidad",$param->imagenHabilidad);
            }

            if (isset($param->idHabilidad)){
                    $query->where("habilidad.idHabilidad",$param->idHabilidad);
            }

            if (isset($param->eliminado)){
                $query->where("habilidad.eliminado",$param->eliminado);
            }

         
            $listaHabilidades= $query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaHabilidades);
    }

}
