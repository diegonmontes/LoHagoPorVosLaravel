<?php
namespace App\Http\Controllers;


use Faker\Provider\Person;
use Illuminate\Http\Request;
use Auth;
use App\Persona;
use App\Localidad;
use App\Provincia;
use App\Habilidad;
use App\HabilidadPersona;
use App\CategoriaTrabajo;
use App\PreferenciaPersona;
use App\Http\Controllers\HabilidadPersonaController;
use App\Http\Controllers\PreferenciaPersonaController;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $personas=Persona::orderBy('idPersona','DESC')->paginate(15);
        return view('persona.index',compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idUsuario = Auth::user()->idUsuario;
        $laPersona = Persona::where('idUsuario','=',$idUsuario)->get();
        $listaHabilidadesSeleccionadas = null;
        $listaPreferenciasSeleccionadas = null;
        if(count($laPersona)){
            $persona = $laPersona[0];
            $existePersona = true;
            $idPersona=$persona->idPersona;
            $listaHabilidadesSeleccionadas=HabilidadPersona::where('idPersona','=',$idPersona)->get();
            $listaPreferenciasSeleccionadas=PreferenciaPersona::where('idPersona','=',$idPersona)->get();
        }else{
            $persona = new Persona;
            $existePersona = false;
        }
        $provincias=Provincia::all();
        $habilidades=Habilidad::all();
        $categoriasTrabajo=CategoriaTrabajo::all();
        return view('persona.create',compact('persona'),['provincias'=>$provincias,'categoriasTrabajo'=>$categoriasTrabajo,'habilidades'=>$habilidades, 'existePersona'=>$existePersona,'listaHabilidadesSeleccionadas'=>$listaHabilidadesSeleccionadas,'listaPreferenciasSeleccionadas'=>$listaPreferenciasSeleccionadas]);
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

        $mensajesErrores =[
            'habilidades.min' => 'Debe seleccionar minimo tres habilidades que posea.',
            'habilidades.required' => 'Debe seleccionar minimo tres habilidades que posea.',
            'preferenciaPersona.min' => 'Debe seleccionar minimo tres categorias que desea ver primero.',
            'preferenciaPersona.required' => 'Debe seleccionar minimo tres categorias que desea ver primero.',
            'nombrePersona.required' => 'El nombre es obligatorio.',
            'apellidoPersona.required' => 'El apellido es obligatorio.',
            'nombrePersona.max' => 'Sobrepasado el limite maximo de palabras.',
            'apellidoPersona.max' => 'Sobrepasado el limite maximo de palabras.',
            'dniPersona.required' => 'El dni es obligatorio.',
            'telefonoPersona.required' => 'El telefono es obligatorio.',
            'idLocalidad.required' => 'La localidad es obligatoria.',
            'idProvincia.required' => 'La provincia es obligatoria.',
            'dniPersona.numeric' => 'Solo se puede ingresar numeros.',

        ] ;

        $this->validate($request,["habilidades"=> "required|array|min:3","preferenciaPersona"=> "required|array|min:3",'nombrePersona'=>'required|max:80','apellidoPersona'=>'required|max:80','dniPersona'=>'required|numeric','telefonoPersona'=>'required|max:32','idLocalidad'=>'required'],$mensajesErrores);

        $controller= new Controller;
        $nombre=$request->nombrePersona;
        $apellido=$request->apellidoPersona;
        if (isset($request['idUsuario'])){ // Significa que ya tenemos el idUsuario (viene de flutter)
            $usandoFlutter = true;
        } else { // No tenemos idUsuario. Esta en la pc
            $idUsuario = Auth::user()->idUsuario;
            $request['idUsuario'] = $idUsuario;
            $usandoFlutter = false;
        }
       
        if(isset($request['imagenPersona']) && $request['imagenPersona']!=null){
            if ($usandoFlutter){ // Significa que el nombre de la img viene por parametro
                $nombreImagen = $request['nombreImagen'];
                $posicion = strrpos($nombreImagen,'.');
                $extension = substr($nombreImagen,$posicion);
                $imagen = base64_decode($request['imagenPersona']); // Decodificamos la img
                $request['imagenPersona'] = $request['idUsuario'].'fotoPerfil'.date("YmdHms").$extension; // Definimos el nombre
                //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                Storage::disk('perfil')->put($request['imagenPersona'], $imagen);            
            } else { // Significa que esta en laravel, no tenemos el nombre de la img ni su formato
                $imagen=$request->file('imagenPersona'); // Obtenemos el obj de la img
                $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
                $nombreImagen = $request['idUsuario'].'fotoPerfil'.date("YmdHms").'.'. $extension;
                $request = $request->except('imagenPersona'); // Guardamos todo el obj sin la clave imagen persona
                $request['imagenPersona']=$nombreImagen; // Asignamos de nuevo a imagenPersona, su nombre
                $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                 $imagen = File::get($imagen);
                 Storage::disk('perfil')->put($nombreImagen, $imagen);       
            }

             // llamamos a la funcion
             $validoImagen = $controller->validarImagen($imagen,1);
        } else { // No carga ninguna imagen
            $validoImagen = true;
        }
        $validoNombre=$controller->moderarTexto($nombre,1); // 1 Significa que evaluamos la variable terms
        sleep(3);
        $validoApellido=$controller->moderarTexto($apellido,1); // 1 Significa que evaluamos la variable terms
        //$validoDescripcion=true;
        $errores="";
        if (!($validoNombre)){
            $errores.="Nombre ";
        }

        if (!($validoApellido)){
            $errores.="Apellido ";
        }

        if (!($validoImagen)){
            $errores.= "Imagen ";
        }


        $this->validate($request,[ 'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required','idUsuario'=>'required']);
        if ($validoImagen && $validoApellido && $validoNombre){
            if (Persona::create($request->all())){ // Si crea una persona, obtenemos su id para llenar el resto de las tablas
                $objPersona = new Persona(); // Creamos el obj persona
                $persona = $objPersona->where('idUsuario','=',$request['idUsuario'])->get(); //Buscamos el obj persona que tenga ese idusuario
                $persona = $persona[0]; // Obtenemos obj persona creado recientemente
                $idPersona = $persona['idPersona']; // Obtenemos id persona

                $listaHabilidades = $request->habilidades;
                $listaPreferencias = $request->preferenciaPersona;

                // Cargamos las habilidades que tenga

                foreach ($listaHabilidades as $key => $valor){
                    $arregloHabilidadPersona = ['idPersona'=>$idPersona,'idHabilidad'=>$valor];
                    $requestHabilidadPersona = new Request($arregloHabilidadPersona);
                    $habilidadPersonaController = new HabilidadPersonaController();
                    $habilidadPersonaController->store($requestHabilidadPersona);
                }

                // Cargamos las preferencias 

                foreach ($listaPreferencias as $key => $valor){
                    $arregloPreferenciaPersona = ['idPersona'=>$idPersona,'idCategoriaTrabajo'=>$valor];
                    $requestHabilidadPersona = new Request($arregloPreferenciaPersona);
                    $PreferenciaPersonaController = new PreferenciaPersonaController();
                    $PreferenciaPersonaController->store($requestHabilidadPersona);
                }

                if ($usandoFlutter){
                    $respuesta = ['success'=>true,'idPersona'=>$idPersona];
                    return response()->json($respuesta);
                } else { // Significa que esta en laravel y debe redireccionar a inicio
                    return response()->json([
                        'url' => route('inicio'),
                        'success'   => true,
                        'message'   => 'Los datos se han guardado correctamente.' //Se recibe en la seccion "success", data.message
                        ], 200);
                    //return redirect()->route('inicio')->with('success','Registro creado satisfactoriamente');
                }
            } else {
                $respuesta = ['success'=>false];
            }
        }else{
            $errores.='con contenido indebido. Por favor cambielo.';
            if ($usandoFlutter){
                $respuesta = ['success'=>false, 'error'=>$errores];
            } else {
                return response()->json([
                    'success'   => false,
                    'errors'   => ['valido' => [0 => $errores ]] 
                    ], 422);
                //return redirect()->route('persona.create')->with('success',$errores);
            }
        }
        return response()->json($respuesta);
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
        $personas=Persona::find($id);
        return  view('persona.show',compact('personas'));
    }

    /**
     * Busca una persona por su id Usuario
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscar($idUsuario)
    {
        $existe=false;
        $objPersona = null;
        $listaPersonas = Persona::where('idUsuario','=',$idUsuario)->get();
        if (count($listaPersonas)>0){
            $objPersona = $listaPersonas[0];
        } else {
            $objPersona=null;
        }
        return $objPersona;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        $idUsuario = Auth::user()->idUsuario;
        $laPersona = Persona::where('idUsuario','=',$idUsuario)->get();
        $persona = $laPersona[0];
        $provincias=Provincia::all();
        $localidades=Localidad::all();
        return view('persona.edit',compact('persona'),['provincias'=>$provincias, 'localidades'=>$localidades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {   
        $mensajesErrores =[
            'habilidades.min' => 'Debe seleccionar minimo tres habilidades que posea.',
            'habilidades.required' => 'Debe seleccionar minimo tres habilidades que posea.',
            'preferenciaPersona.min' => 'Debe seleccionar minimo tres categorias que desea ver primero.',
            'preferenciaPersona.required' => 'Debe seleccionar minimo tres habilidades que desea ver primero.'
        ] ;

        $this->validate($request,["habilidades"=> "required|array|min:3","preferenciaPersona"=> "required|array|min:3",'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required'],$mensajesErrores);
        $controller= new Controller;
        $nombre=$request->nombrePersona;
        $apellido=$request->apellidoPersona;
        if (isset($request['nombreImagen'])&& $request['nombreImagen']!=null){ // Significa que ya tenemos el nombre de la img (viene de flutter)
            $usandoFlutter = true;
        } else { // No tenemos el nombre de la imagen. Esta en la pc
            $usandoFlutter = false;
        }
       
        if(isset($request['imagenPersona']) && $request['imagenPersona']!=null){
            if ($usandoFlutter){ // Significa que el nombre de la img viene por parametro
                $nombreImagen = $request['nombreImagen'];
                $posicion = strrpos($nombreImagen,'.');
                $extension = substr($nombreImagen,$posicion);
                $imagen = base64_decode($request['imagenPersona']); // Decodificamos la img
                $request['imagenPersona'] = $request['idUsuario'].'fotoPerfil'.date("YmdHms").$extension; // Definimos el nombre
                //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                Storage::disk('perfil')->put($request['imagenPersona'], $imagen);            
            } else { // Significa que esta en laravel, no tenemos el nombre de la img ni su formato
                $imagen=$request->file('imagenPersona'); // Obtenemos el obj de la img
                $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
                $nombreImagen = $request['idUsuario'].'fotoPerfil'.date("YmdHms").'.'. $extension;
                $request = $request->except('imagenPersona'); // Guardamos todo el obj sin la clave imagen persona
                $request['imagenPersona']=$nombreImagen; // Asignamos de nuevo a imagenPersona, su nombre
                $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                 $imagen = File::get($imagen);
                 Storage::disk('perfil')->put($nombreImagen, $imagen);       
            };
             // llamamos a la funcion
             $validoImagen = $controller->validarImagen($imagen,1);
        } else { // No carga ninguna imagen
            $validoImagen = true;
        }
        $validoNombre=$controller->moderarTexto($nombre,1); // 1 Significa que evaluamos la variable terms
        sleep(3);
        $validoApellido=$controller->moderarTexto($apellido,1); // 1 Significa que evaluamos la variable terms
        //$validoDescripcion=true;
        $errores="";
        if (!($validoNombre)){
            $errores.="Nombre ";
        }

        if (!($validoApellido)){
            $errores.="Apellido ";
        }

        if (!($validoImagen)){
            $errores.= "Imagen ";
        }
        if ($validoImagen && $validoApellido && $validoNombre){
            $idPersona=$request->idPersona;
            if (Persona::find($idPersona)->update($request->all())){ // Si actualiza su perfil , obtenemos su id para llenar el resto de las tablas
                    
                $listaHabilidades = $request->habilidades; // Obtenemos la lista de habilidades
                foreach ($listaHabilidades as $idHabilidad){ // obtenemos cada uno de los id y lo eliminamos
                    HabilidadPersona::destroy($idHabilidad);
                };
                foreach ($listaHabilidades as $key => $valor){
                    $arregloHabilidadPersona = ['idPersona'=>$idPersona,'idHabilidad'=>$valor];
                    $requestHabilidadPersona = new Request($arregloHabilidadPersona);
                    $habilidadPersonaController = new HabilidadPersonaController();
                    $habilidadPersonaController->store($requestHabilidadPersona);
                }

                $listaPreferencias = $request->preferenciaPersona; // Obtenemos la lista de habilidades
                foreach ($listaPreferencias as $idPreferenciaPersona){ // obtenemos cada uno de los id y lo eliminamos
                    PreferenciaPersona::destroy($idPreferenciaPersona);
                };

                // Cargamos las preferencias 

                foreach ($listaPreferencias as $key => $valor){
                    $arregloPreferenciaPersona = ['idPersona'=>$idPersona,'idCategoriaTrabajo'=>$valor];
                    $requestHabilidadPersona = new Request($arregloPreferenciaPersona);
                    $PreferenciaPersonaController = new PreferenciaPersonaController();
                    $PreferenciaPersonaController->store($requestHabilidadPersona);
                }

                die();

                if ($usandoFlutter){
                    $respuesta = ['success'=>true,'idPersona'=>$idPersona];
                    return response()->json($respuesta);
                } else { // Significa que esta en laravel y debe redireccionar a inicio
                    return redirect()->route('inicio')->with('success','Registro creado satisfactoriamente');
                }
            } else {
                $respuesta = ['success'=>false];
            }
        }else{
            $errores.='con contenido indebido. Por favor cambielo.';
            if ($usandoFlutter){
                $respuesta = ['success'=>false, 'error'=>$errores];
            } else {
                return redirect()->route('inicioasdasd  ')->with('error','Error');
            }
        }
     
















        $idPersona = $request['idPersona'];
        Persona::find($idPersona)->update($request->all());
        $file = $request['archivo'];
        if(isset($file)){
            //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            Storage::disk('local')->put('fotoperfil'.$idPersona, $file);
        }
        return redirect()->route('inicio')->with('success','Registro actualizado satisfactoriamente');

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
        Persona::find($id)->delete();
        return redirect()->route('persona.index')->with('success','Registro eliminado satisfactoriamente');

    }

    public function getCurrentPerfil(Request $request){
        $idPersona = $request->idPersona;
        $persona = Persona::where('idPersona','=',$idPersona)->get()[0];
        return response()->json([
            'success' => true,
            'persona' => $persona
        ]);
    }

    public function actualizarPerfil(Request $request){
        $idPersona = $request->idPersona;
        $control = new Controller;

        if(isset($request['nombrePersona'])){
            $texto = $request->nombrePersona;
            $respuestaError = 'Nombre indebido. Por favor ingrese otro.';
        }

        if(isset($request['apellidoPersona'])){
            $texto = $request->apellidoPersona;
            $respuestaError = 'Apellido indebido. Por favor ingrese otro.';

        }

        if(!isset($request['telefonoPersona'])){
            $esValido = $control->moderarTexto($texto,1);
        }else{
            $esValido = true;
        }
        if($esValido){
            Persona::find($idPersona)->update($request->all());

            return response()->json([
                'success' => true,
                'mensaje' => 'Cambio actualizado'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'mensaje' => $respuestaError
            ]);
        }
    }

    
}
