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
        $listaTrabajos=Trabajo::all();
        $listaPersonas=Persona::all();
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
        $listaTrabajos=Trabajo::all();
        $listaPersonas=Persona::all();
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
}
