<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Persona;
use App\Trabajo;
Use App\ConversacionChat;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class ConversacionChatController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $conversaciones=ConversacionChat::orderBy('idConversacionChat','ASC')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('conversacionchat.index',compact('conversaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $listaTrabajos = Trabajo::all();
        $listaPersonas = Persona::all();
        return view('conversacionchat.create',['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]); //Vista para crear el elemento nuevo
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
        $this->validate($request,[ 'idTrabajo'=>'required','idPersona1'=>'required','idPersona2'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        ConversacionChat::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('conversacionchat.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $conversaciones=ConversacionChat::find($id); //Buscamos el elemento para mostrarlo
        return  view('conversacionchat.show',compact('conversaciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $conversacion=ConversacionChat::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        $listaPersonas = Persona::all();
        $listaTrabajos = Trabajo::all();
        return view('conversacionchat.edit',compact('conversacion'),['listaPersonas'=>$listaPersonas,'listaTrabajos'=>$listaTrabajos]);
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
        $this->validate($request,[ 'idTrabajo'=>'required','idPersona1'=>'required','idPersona2'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        ConversacionChat::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('conversacionchat.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        ConversacionChat::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('conversacionchat.index')->with('success','Registro eliminado satisfactoriamente');
    }

}
