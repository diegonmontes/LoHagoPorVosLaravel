<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Multa;


class MultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexpanel()
    {
        $multas=Multa::orderBy('idMulta','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('multa.indexpanel',compact('multas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createpanel()
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        return view('multa.createpanel',['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function storepanel(Request $request)
    {
        $mensajesErrores =[             
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.max' => 'Maximo de letras sobrepasado.',
            'valor.required' => 'El valor es obligatorio.',
            'valor.numeric' => 'Solamente se puede ingresar numeros.',
            'idPersona.required'=> 'La persona es obligatoria',
            'idTrabajo.required'=> 'El trabajo es obligatorio',
            
        ] ;

        $this->validate($request,['idPersona'=>'required','motivo'=>'required|max:255','valor'=>'required|numeric','idTrabajo'=>'required'],$mensajesErrores);
            
        if (Multa::create($request->all())){
            return redirect()->route('multa.indexpanel')->with('success','Registro creado satisfactoriamente');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $multas=Multa::find($id); //Buscamos el elemento para mostrarlo
        return  view('multa.show',compact('multas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        $multa=Multa::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('multa.edit',compact('multa'),['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]);
    
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
        $mensajesErrores =[             
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.max' => 'Maximo de letras sobrepasado.',
            'valor.required' => 'El valor es obligatorio.',
            'valor.numeric' => 'Solamente se puede ingresar numeros.',
            'idPersona.required'=> 'La persona es obligatoria',
            'idTrabajo.required'=> 'El trabajo es obligatorio',
            
        ] ;
        $this->validate($request,['idPersona'=>'required','motivo'=>'required|max:255','valor'=>'required|numeric','idTrabajo'=>'required'],$mensajesErrores);
        

        Multa::find($id)->update($request->all()); // Si actualiza la multa , obtenemos su id para llenar el resto de las tablas
        return redirect()->route('multa.indexpanel')->with('success','Registro actualizado satisfactoriamente');
        
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
        Multa::where('idMulta',$id)->update(['eliminado'=>1]);
        //Multa::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('multa.indexpanel')->with('success','Registro eliminado satisfactoriamente');
    }
}
