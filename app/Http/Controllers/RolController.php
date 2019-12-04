<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles=Rol::orderBy('idRol','ASC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('rol.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('rol.create'); //Vista para crear el elemento nuevo
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
        $this->validate($request,[ 'nombreRol'=>'required', 'descripcionRol'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        Rol::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('rol.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $roles=Rol::find($id); //Buscamos el elemento para mostrarlo
        return  view('rol.show',compact('roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $rol=Rol::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('rol.edit',compact('rol'));
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
        $this->validate($request,[ 'nombreRol'=>'required' ,'descripcionRol'=>'required']); //Validamos los datos antes de actualizar
        Rol::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('rol.index')->with('success','Registro actualizado satisfactoriamente');
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
        Rol::where('idRol',$id)->update(['eliminado'=>1,'updated_at'=>now()]);
        //Rol::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('rol.index')->with('success','Registro eliminado satisfactoriamente');
    }

    // Esta funcion busca todos los roles con parametros que le enviemos
   public function buscar(Request $param){      
        $query = Rol::OrderBy('idRol','ASC'); // Ordenamos los roles por este medio

        if (isset($param->idRol)){
            $query->where("rol.idRol",$param->idRol);
        }

        if (isset($param->nombreRol)){
            $query->where("rol.nombreRol",$param->nombreRol);
        }

        if (isset($param->descripcionRol)){
            $query->where("rol.descripcionRol",$param->descripcionRol);
        }

        if (isset($param->eliminado)){
            $query->where("rol.eliminado",$param->eliminado);
        }

        $listaRoles= $query->get();   // Hacemos el get y seteamos en lista
        return json_encode($listaRoles);
}
}
