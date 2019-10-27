<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Trabajoasignado;

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
        $trabajosAsignados=Trabajoasignado::orderBy('idTrabajoAsignado','DESC')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('trabajoasignado.index',compact('trabajosAsignados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('trabajoasignado.create'); //Vista para crear el elemento nuevo
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
        return redirect()->route('trabajoasignado.index')->with('success','Registro creado satisfactoriamente');
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
        $trabajoAsignado=Trabajoasignado::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('trabajoasignado.edit',compact('trabajoAsignado'));
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
        Trabajoasignado::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('trabajoasignado.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
