<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Estadotrabajo;


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
        $Estadotrabajos=Estadotrabajo::orderBy('idEstadoTrabajo','DESC')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('estadotrabajo.index',compact('Estadotrabajos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('estadotrabajo.create'); //Vista para crear el elemento nuevo
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
        
        $estadoTrabajo=Estadotrabajo::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('estadotrabajo.edit',compact('estadoTrabajo'));
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
        Estadotrabajo::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('estadotrabajo.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
