<?php

namespace App\Http\Controllers;

use App\CategoriaTrabajo;
use Illuminate\Http\Request;

class CategoriaTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categoriasTrabajo=CategoriaTrabajo::orderBy('idLocalidad','DESC')->paginate(15);
        return view('CategoriaTrabajo.index',compact('categoriasTrabajo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categoriasTrabajo=CategoriaTrabajo::all();
        return view('CategoriaTrabajo.create',['categoriasTrabajo'=>$categoriasTrabajo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[ 'nombreCategoriaTrabajo'=>'required']);
        CategoriaTrabajo::create($request->all());
        return redirect()->route('categoriaTrabajo.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $categoriasTrabajo=CategoriaTrabajo::find($id);
        return  view('CategoriaTrabajo.show',compact('categoriasTrabajo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categoriasTrabajo=CategoriaTrabajo::find();
        return view('CategoriaTrabajo.edit',compact('categoriasTrabajo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[ 'nombreCategoriaTrabajo'=>'required']);
        CategoriaTrabajo::find($id)->update($request->all());
        return redirect()->route('categoriaTrabajo.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        CategoriaTrabajo::find($id)->delete();
        return redirect()->route('categoriaTrabajo.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
