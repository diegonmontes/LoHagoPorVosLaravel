<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Persona;
Use App\ConversacionChat;
Use App\MensajeChat;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class MensajeChatController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $mensajeschats=MensajeChat::orderBy('idMensajeChat','ASC')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('mensajechat.index',compact('mensajeschats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('mensajechat.create'); //Vista para crear el elemento nuevo
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
        $this->validate($request,['idConversacionChat'=>'required','mensaje'=>'required','idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        MensajeChat::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('mensajechat.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $mensajes=MensajeChat::find($id); //Buscamos el elemento para mostrarlo
        return  view('mensajechat.show',compact('mensajes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $mensaje=MensajeChat::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('mensajechat.edit',compact('mensaje'));
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
        $this->validate($request,['idConversacionChat'=>'required','mensaje'=>'required','idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        MensajeChat::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('mensajechat.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        MensajeChat::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('mensajechat.index')->with('success','Registro eliminado satisfactoriamente');
    }

}
