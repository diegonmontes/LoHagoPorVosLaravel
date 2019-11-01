<?php
namespace App\Http\Controllers;


use Faker\Provider\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            'dniPersona.min' => 'Ingrese un DNI valido.',
            'nombrePersona.alpha' => 'Solo esta permitido el ingreso de letras.',
            'apellidoPersona.alpha' => 'Solo esta permitido el ingreso de letras.',
        ] ;

        $this->validate($request,["habilidades"=> "required|array|min:3","preferenciaPersona"=> "required|array|min:3",'nombrePersona'=>'required|max:80|alpha','apellidoPersona'=>'required|max:80|alpha','dniPersona'=>'required|numeric|min:8','telefonoPersona'=>'required|max:32','idLocalidad'=>'required'],$mensajesErrores);

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

                $errores = array();
                if (!($validoNombre)){
                    $errores["nombrePersona"] = [0 => "Nombre con contenido indebido. Por favor cambielo."];
                }
        
                if (!($validoApellido)){
                    $errores["apellidoPersona"] = [0 => "Apellido con contenido indebido. Por favor cambielo."];
                }
        
                if (!($validoImagen)){
                    $errores["imagenPersona"] = [0 => "Imagen con contenido indebido. Por favor cambielo."];
                }
                return response()->json([
                    'success'   => false,
                    'errors'   => $errores[0] 
                    ], 422);
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
        $persona=Persona::find($id);
        return  view('persona.show',compact('persona'));
    }

    /**
     * Busca una persona por su id Usuario
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function buscar($idUsuario)
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
*/
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
            'preferenciaPersona.required' => 'Debe seleccionar minimo tres habilidades que desea ver primero.',
            'nombrePersona.required' => 'El nombre es obligatorio.',
            'apellidoPersona.required' => 'El apellido es obligatorio.',
            'nombrePersona.max' => 'Sobrepasado el limite maximo de letas.',
            'apellidoPersona.max' => 'Sobrepasado el limite maximo de letras.',
            'dniPersona.required' => 'El dni es obligatorio.',
            'telefonoPersona.required' => 'El telefono es obligatorio.',
            'idLocalidad.required' => 'La localidad es obligatoria.',
            'idProvincia.required' => 'La provincia es obligatoria.',
            'dniPersona.numeric' => 'Solo se puede ingresar numeros.',
            'dniPersona.min' => 'Ingrese un DNI valido.',
            'nombrePersona.alpha' => 'Solo esta permitido el ingreso de letras.',
            'apellidoPersona.alpha' => 'Solo esta permitido el ingreso de letras.',
        ] ;

        $this->validate($request,["habilidades"=> "required|array|min:3","preferenciaPersona"=> "required|array|min:3",'nombrePersona'=>'required|max:80|alpha','apellidoPersona'=>'required|max:80|alpha','dniPersona'=>'required|numeric|min:8','telefonoPersona'=>'required|max:32','idLocalidad'=>'required'],$mensajesErrores);
        
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
                $usuario = Persona::find($request->idPersona);
                $idUsuario = $usuario->idUsuario;
                $nombreImagen = $idUsuario.'fotoPerfil'.date("YmdHms").'.'. $extension;
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


                if ($usandoFlutter){
                    $respuesta = ['success'=>true,'idPersona'=>$idPersona];
                    return response()->json($respuesta);
                } else { // Significa que esta en laravel y debe redireccionar a inicio
                    return response()->json([
                        'url' => route('inicio'),
                        'success'   => true,
                        'message'   => 'Los datos se han guardado correctamente.'
                        ], 200);
                }
            } else {
                $respuesta = ['success'=>false];
            }
        }else{
            $errores.='con contenido indebido. Por favor cambielo.';
            if ($usandoFlutter){
                $respuesta = ['success'=>false, 'error'=>$errores];
            } else {
                $errores = array();
                if (!($validoNombre)){
                    $errores["nombrePersona"] = [0 => "Nombre con contenido indebido. Por favor cambielo."];
                }
        
                if (!($validoApellido)){
                    $errores["apellidoPersona"] = [0 => "Apellido con contenido indebido. Por favor cambielo."];
                }
        
                if (!($validoImagen)){
                    $errores["imagenPersona"] = [0 => "Imagen con contenido indebido. Por favor cambielo."];
                }

                return response()->json([
                    'success'   => false,
                    'errors'   =>  $errores
                    ], 422);
            }
        }
     
        $idPersona = $request['idPersona'];
        Persona::find($idPersona)->update($request->all());
        $file = $request['archivo'];
        if(isset($file)){
            //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            Storage::disk('local')->put('fotoperfil'.$idPersona, $file);
        }
        return response()->json([
                        'url' => route('inicio'),
                        'success'   => true,
                        'message'   => 'Los datos se han guardado correctamente.'
                        ], 200);

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

    // Esta funcion busca todas las personas con parametros que le enviemos
    public function buscar(Request $param){      
        $query = Persona::OrderBy('idPersona','ASC'); // Ordenamos las personas por este medio

            if (isset($param->idPersona)){
                $query->where("persona.idPersona",$param->idPersona);
            }

            if (isset($param->nombrePersona)){
                $query->where("persona.nombrePersona",$param->nombrePersona);
            }

            if (isset($param->apellidoPersona)){
                $query->where("persona.apellidoPersona",$param->apellidoPersona);
            }

            if (isset($param->dniPersona)){
                $query->where("persona.dniPersona",$param->dniPersona);
            }

            if (isset($param->telefonoPersona)){
                $query->where("persona.telefonoPersona",$param->telefonoPersona);
            }

            if (isset($param->imagenPersona)){
                $query->where("persona.imagenPersona",$param->imagenPersona);
            }

            if (isset($param->idUsuario)){
                $query->where("persona.idUsuario",$param->idUsuario);
            }

            if (isset($param->idLocalidad)){
                $query->where("persona.idLocalidad",$param->idLocalidad);
            }

            if (isset($param->eliminado)){
                $query->where("persona.eliminado",$param->eliminado);
            }

            $listaPersonas= $query->get();   // Hacemos el get y seteamos en lista
            
            return json_encode($listaPersonas);
    }

    // Funciones para mostrar la vista del panel de administrador de persona

    public function createpanel(){

      
        $provinciaController = new ProvinciaController();
        $localidadController = new LocalidadController();
        $habilidadController = new HabilidadController();
        $categoriaTrabajoController = new CategoriaTrabajoController();
        $usuarioController = new UserController();

        $arregloBuscarProvincia = ['null'=>null];
        $arregloBuscarProvincia = new Request($arregloBuscarProvincia);
        $listaProvincias = $provinciaController->buscar($arregloBuscarProvincia);
        $provincias = json_decode($listaProvincias);

        $arregloBuscarLocalidad = [null];
        $arregloBuscarLocalidad = new Request($arregloBuscarLocalidad);
        $listaLocalidades = $localidadController->buscar($arregloBuscarLocalidad);
        $localidades = json_decode($listaLocalidades);

        $arregloBuscarHabilidades = [null];
        $arregloBuscarHabilidades = new Request($arregloBuscarHabilidades);
        $listaHabilidades = $habilidadController->buscar($arregloBuscarHabilidades);
        $habilidades = json_decode($listaHabilidades);

        $arregloBuscarCategorias = [null];
        $arregloBuscarCategorias = new Request($arregloBuscarCategorias);
        $listaCategorias = $categoriaTrabajoController->buscar($arregloBuscarHabilidades);
        $categoriasTrabajo = json_decode($listaCategorias);

        $arregloBuscarUsuarios = ['usuarioSinPersona'=>true];
        $arregloBuscarUsuarios = new Request($arregloBuscarUsuarios);
        $listaUsuarios = $usuarioController->buscar($arregloBuscarUsuarios);
        $usuarios = json_decode($listaUsuarios);
        
        return view('persona.createpanel',compact('persona'),['usuarios'=>$usuarios,'localidad'=>$localidades,'provincias'=>$provincias,'categoriasTrabajo'=>$categoriasTrabajo,'habilidades'=>$habilidades]);
 
    }

    public function editpanel($id)
    {
        $idPersona=$id;
        $provinciaController = new ProvinciaController();
        $localidadController = new LocalidadController();
        $habilidadController = new HabilidadController();
        $categoriaTrabajoController = new CategoriaTrabajoController();
        $habilidadPersonaController = new HabilidadPersonaController();
        $preferenciaPersonaController = new PreferenciaPersonaController();


        $arregloBuscarProvincia = ['null'=>null];
        $arregloBuscarProvincia = new Request($arregloBuscarProvincia);
        $listaProvincias = $provinciaController->buscar($arregloBuscarProvincia);
        $provincias = json_decode($listaProvincias);

        $arregloBuscarLocalidad = [null];
        $arregloBuscarLocalidad = new Request($arregloBuscarLocalidad);
        $listaLocalidades = $localidadController->buscar($arregloBuscarLocalidad);
        $localidades = json_decode($listaLocalidades);

        $arregloBuscarHabilidades = [null];
        $arregloBuscarHabilidades = new Request($arregloBuscarHabilidades);
        $listaHabilidades = $habilidadController->buscar($arregloBuscarHabilidades);
        $listaHabilidades = json_decode($listaHabilidades);

        $arregloBuscarCategorias = [null];
        $arregloBuscarCategorias = new Request($arregloBuscarCategorias);
        $categoriasTrabajo = $categoriaTrabajoController->buscar($arregloBuscarHabilidades);
        $categoriasTrabajo = json_decode($categoriasTrabajo);

        $arregloBuscarHabilidadPersona = ['idPersona'=>$idPersona];
        $arregloBuscarHabilidadPersona = new Request($arregloBuscarHabilidadPersona);
        $listaHabilidadesSeleccionadas = $habilidadPersonaController->buscar($arregloBuscarHabilidadPersona);
        $listaHabilidadesSeleccionadas = json_decode($listaHabilidadesSeleccionadas);
    
        $arregloBuscarPreferencias = ['idPersona'=>$idPersona];
        $arregloBuscarPreferencias = new Request($arregloBuscarPreferencias);
        $listaPreferenciasSeleccionadas = $preferenciaPersonaController->buscar($arregloBuscarPreferencias);
        $listaPreferenciasSeleccionadas = json_decode($listaPreferenciasSeleccionadas);


        $listaHabilidadesSeleccionadas=HabilidadPersona::where('idPersona','=',$idPersona)->get();
        $listaPreferenciasSeleccionadas=PreferenciaPersona::where('idPersona','=',$idPersona)->get();
        $arregloBuscarPersona = ['idPersona'=>$idPersona];
        $arregloBuscarPersona = new Request($arregloBuscarPersona);
        $listaPersonas=$this->buscar($arregloBuscarPersona);
        $listaPersonas=json_decode($listaPersonas);
        $persona = $listaPersonas[0];

        return view('persona.editpanel',compact('persona'),['persona'=>$persona,'localidad'=>$localidades,'provincias'=>$provincias,'categoriasTrabajo'=>$categoriasTrabajo,'habilidades'=>$listaHabilidades,'listaHabilidadesSeleccionadas'=>$listaHabilidadesSeleccionadas,'listaPreferenciasSeleccionadas'=>$listaPreferenciasSeleccionadas]);
    }

    public function storepanel(Request $request)
    {    
        if(isset($request['imagenPersona']) && $request['imagenPersona']!=null){
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
                };

        };
                
    return response()->json([
        'url' => route('persona.index'),
        'success'   => true,
        'message'   => 'Los datos se han guardado correctamente.' //Se recibe en la seccion "success", data.message
        ], 200);
   
    ;}

    public function updatepanel(Request $request)
    {   
        $habilidadPersonaController = new HabilidadPersonaController();
        $preferenciaPersonaController = new PreferenciaPersonaController();
        $mensajesErrores =[
            'habilidades.min' => 'Debe seleccionar minimo tres habilidades que posea.',
            'habilidades.required' => 'Debe seleccionar minimo tres habilidades que posea.',
            'preferenciaPersona.min' => 'Debe seleccionar minimo tres categorias que desea ver primero.',
            'preferenciaPersona.required' => 'Debe seleccionar minimo tres habilidades que desea ver primero.',
            'nombrePersona.required' => 'El nombre es obligatorio.',
            'apellidoPersona.required' => 'El apellido es obligatorio.',
            'nombrePersona.max' => 'Sobrepasado el limite maximo de letas.',
            'apellidoPersona.max' => 'Sobrepasado el limite maximo de letras.',
            'dniPersona.required' => 'El dni es obligatorio.',
            'telefonoPersona.required' => 'El telefono es obligatorio.',
            'idLocalidad.required' => 'La localidad es obligatoria.',
            'idProvincia.required' => 'La provincia es obligatoria.',
            'dniPersona.numeric' => 'Solo se puede ingresar numeros.',
            'dniPersona.min' => 'Ingrese un DNI valido.',
            'nombrePersona.alpha' => 'Solo esta permitido el ingreso de letras.',
            'apellidoPersona.alpha' => 'Solo esta permitido el ingreso de letras.',
        ] ;

        $this->validate($request,["habilidades"=> "required|array|min:3","preferenciaPersona"=> "required|array|min:3",'nombrePersona'=>'required|max:80|alpha','apellidoPersona'=>'required|max:80|alpha','dniPersona'=>'required|numeric|min:8','telefonoPersona'=>'required|max:32','idLocalidad'=>'required'],$mensajesErrores);
        
        
        if(isset($request['imagenPersona']) && $request['imagenPersona']!=null){
                $imagen=$request->file('imagenPersona'); // Obtenemos el obj de la img
                $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
                $usuario = Persona::find($request->idPersona);
                $idUsuario = $usuario->idUsuario;
                $nombreImagen = $idUsuario.'fotoPerfil'.date("YmdHms").'.'. $extension;
                $request = $request->except('imagenPersona'); // Guardamos todo el obj sin la clave imagen persona
                $request['imagenPersona']=$nombreImagen; // Asignamos de nuevo a imagenPersona, su nombre
                $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                 $imagen = File::get($imagen);
                 Storage::disk('perfil')->put($nombreImagen, $imagen);       
        } 
            $idPersona=$request->idPersona;
            
            if (Persona::find($idPersona)->update($request->all())){ // Si actualiza su perfil , obtenemos su id para llenar el resto de las tablas
                $arregloBuscarHabilidadPersona = ['idPersona'=>$idPersona];
                $arregloBuscarHabilidadPersona = new Request($arregloBuscarHabilidadPersona);
                // Creamos el arreglo para que busque todas las habilidades que ya posea este usuario
                $listaHabilidadesPersona = $habilidadPersonaController->buscar($arregloBuscarHabilidadPersona);
                $listaHabilidadesPersona = json_decode($listaHabilidadesPersona);
                // Hacemos la busqueda y obtenemos la inda
                foreach ($listaHabilidadesPersona as $objHabilidadPersona){ // obtenemos cada uno de los id y lo eliminamos
                    $idHabilidadPersona = $objHabilidadPersona->idHabilidadPersona;
                    HabilidadPersona::destroy($idHabilidadPersona);
                };
                $listaHabilidades = $request->habilidades; // Obtenemos la lista de habilidades
                
                foreach ($listaHabilidades as $key => $valor){
                    $arregloHabilidadPersona = ['idPersona'=>$idPersona,'idHabilidad'=>$valor];
                    $requestHabilidadPersona = new Request($arregloHabilidadPersona);
                    $habilidadPersonaController = new HabilidadPersonaController();
                    $habilidadPersonaController->store($requestHabilidadPersona);
                }

                $arregloBuscarPreferenciaPersona = ['idPersona'=>$idPersona];
                $arregloBuscarPreferenciaPersona = new Request($arregloBuscarPreferenciaPersona);
                // Creamos el arreglo para que busque todas las habilidades que ya posea este usuario
                $listaPreferenciasPersona = $preferenciaPersonaController->buscar($arregloBuscarPreferenciaPersona);
                $listaPreferenciasPersona = json_decode($listaPreferenciasPersona);
                foreach ($listaPreferenciasPersona as $objPreferenciadPersona){ // obtenemos cada uno de los id y lo eliminamos
                    $idPreferenciaPersona = $objPreferenciadPersona->idPreferenciaPersona;
                    PreferenciaPersona::destroy($idPreferenciaPersona);
                };

                // Cargamos las preferencias 
                $listaPreferencias = $request->preferenciaPersona; // Obtenemos la lista de habilidades

                foreach ($listaPreferencias as $key => $valor){
                    $arregloPreferenciaPersona = ['idPersona'=>$idPersona,'idCategoriaTrabajo'=>$valor];
                    $requestHabilidadPersona = new Request($arregloPreferenciaPersona);
                    $PreferenciaPersonaController = new PreferenciaPersonaController();
                    $PreferenciaPersonaController->store($requestHabilidadPersona);
                }
            }

                    return response()->json([
                        'url' => route('persona.index'),
                        'success'   => true,
                        'message'   => 'Los datos se han guardado correctamente.'
                        ], 200);
                }
            }