<?php

namespace App\Http\Controllers;

//Autenticacion
use Auth;
//Modelos
use App\CategoriaTrabajo;
use App\Trabajo;
use App\Persona;
use App\Trabajoaspirante;
use App\Trabajoasignado;
use App\Pagorecibido;
use App\Localidad;
use App\Provincia;
use App\Comentario;
use App\Estadotrabajo;
//Controladores
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PagorecibidoController;
use App\Http\Controllers\TrabajoaspiranteController;
use App\Http\Controllers\TrabajoasignadoController;
use App\Http\Controllers\MultaController;
//Vendor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;



class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Show the form for creating a new resource.
         */
        $arregloBuscarCategorias=['eliminado' => 0];
        $arregloBuscarProvincias=['eliminado' => 0];
        $categoriaTrabajoController = new CategoriaTrabajoController();
        $provinciaController = new ProvinciaController();
        $arregloBuscarCategorias = new Request($arregloBuscarCategorias);
        $arregloBuscarProvincias = new Request($arregloBuscarProvincias);
        $listaCategoriaTrabajo=$categoriaTrabajoController->buscar($arregloBuscarCategorias);
        $listaCategoriaTrabajo = json_decode($listaCategoriaTrabajo);
        $listaProvincias=$provinciaController->buscar($arregloBuscarProvincias);
        $listaProvincias = json_decode($listaProvincias);
        return view('anuncio.index',['provincias'=>$listaProvincias,'listaCategoriaTrabajo'=>$listaCategoriaTrabajo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $titulo=$request->titulo;
        $descripcion=$request->descripcion;
        $controller= new Controller;

        if (isset($request['idPersona'])){ // Significa que ya tenemos el idPersona (viene de flutter)
            $usandoFlutter = true;
        } else { // No tenemos idPersona. Esta en la pc
            $idUsuario = Auth::user()->idUsuario;
            $persona = Persona::where('idUsuario','=',$idUsuario)->get();
            $request['idPersona']=$persona[0]->idPersona;
            $usandoFlutter = false;
        }

        if(isset($request['imagenTrabajo']) && $request['imagenTrabajo']!=null){
            if ($usandoFlutter){ // Significa que el nombre de la img viene por parametro
                $nombreImagen = $request['nombreImagen'];
                $posicion = strrpos($nombreImagen,'.');
                $extension = substr($nombreImagen,$posicion);
                $imagen = base64_decode($request['imagenTrabajo']); // Decodificamos la img
                $request['imagenTrabajo'] = $request['idPersona'].'fotoTrabajo'.date("YmdHms").$extension; // Definimos el nombre
                //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                Storage::disk('trabajo')->put($request['imagenTrabajo'], $imagen);            
            } else { // Significa que esta en laravel, no tenemos el nombre de la img ni su formato
                $imagen=$request->file('imagenTrabajo'); // Obtenemos el obj de la img
                $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
                $nombreImagen = $request['idPersona'].'fotoTrabajo'.date("YmdHms").'.'. $extension;
                $request = $request->except('imagenTrabajo'); // Guardamos todo el obj sin la clave imagen trabajo
                $request['imagenTrabajo']=$nombreImagen; // Asignamos de nuevo a imagenTrabajo, su nombre
                $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                $imagen = File::get($imagen);
                Storage::disk('trabajo')->put($nombreImagen, $imagen);        
            }

            //llamamos a la funcion que valida la imagen
            $validoImagen = $controller->validarImagen($imagen,1);
            
        } else { // Si no carga ninguna imagen, seteamos por defecto el valor a true
            $validoImagen = true;
        }
        if($titulo != null){
            $validoTitulo=$controller->moderarTexto($titulo,1); // 1 Significa que evaluamos la variable terms
        }else{
            $validoTitulo = true;
        }
        sleep(3);
        if($descripcion != null){
            $validoDescripcion=$controller->moderarTexto($descripcion,1); // 1 Significa que evaluamos la variable terms
        }else{
            $validoDescripcion = true;
        }
        
            //$validoDescripcion=true;
        $errores="";
        if (!($validoTitulo)){
            $errores.="Titulo ";
        }

        if (!($validoDescripcion)){
            $errores.="Descripcion ";
        }

        if (!($validoImagen)){
            $errores.= "Imagen ";
        }

        if($usandoFlutter){
            if(isset($request['horaSeleccionada']) && isset($request['diaSeleccionado'])){ // Si estan seteados estos valores es porque esta en flutter. hay que editar la fecha
                $horaSinEditar = $request['horaSeleccionada']; // Obtenemos la hs sin editar
                $diaSinEditar = $request['diaSeleccionado']; // El dia que selecciono sin editar
                $diaEditado = substr($diaSinEditar,0,10);
                $horaEditada = substr($horaSinEditar,10,5); // Eliminamos los milisegundos que vienen del timepicker
                $request['tiempoExpiracion'] = $diaEditado.' '.$horaEditada; // concatenamos y seteamos
            }
        }


        if ($validoDescripcion && $validoTitulo && $validoImagen){
            $mensajesErrores =[             
                'titulo.required' => 'El titulo es obligatorio.',
                'titulo.max' => 'Maximo de letras sobrepasado.',
                'descripcion.required' => 'La descripcion es obligatoria.',
                'descripcion.max' => 'Maximo de letras sobrepasado.',
                'monto.required' => 'El monto es obligatorio.',
                'monto.numeric' => 'Solamente se puede ingresar numeros.',
                'tiempoExpiracion.required' => 'La fecha de expiracion es obligatorio'
            ] ;

            //Validaciones del trabajo
            $this->validate($request,[ 'titulo'=>'required|max:255', 'descripcion'=>'required|max:511', 'monto'=>'required|numeric','tiempoExpiracion'=>'required|date','imagenTrabajo' =>'nullable:true'],$mensajesErrores);
            $request['idEstado'] = 1;
            if (Trabajo::create($request->all())){
                if ($usandoFlutter){
                    $respuesta = ['success'=>true];
                } else { // Significa que esta en laravel y debe redireccionar a inicio
                    //Buscamos el trabajo creado para crear un dato en estadotrabajo
                    $paramBuscarTrabajoRecienCreado = $request;
                    $trabajoControl = new TrabajoController;
                    $trabajo = $trabajoControl->buscar($paramBuscarTrabajoRecienCreado);
                    $trabajo = json_decode($trabajo);
                    $trabajo = $trabajo[0];
                    $idTrabajo = $trabajo->idTrabajo;
                    //Creamos estadotrabajo con el estado en 1
                    $paramEstadotrabajo = ['idTrabajo'=>$idTrabajo,'idEstado'=>1];
                    $requesEstadoTrabajo = new Request($paramEstadotrabajo);
                    Estadotrabajo::create($requesEstadoTrabajo->all());

                    return response()->json([
                        'url' => route('historial'),
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
                if (!($validoTitulo)){
                    $errores["titulo"] = [0 => "Titulo con contenido indebido. Por favor cambielo."];
                }
        
                if (!($validoDescripcion)){
                    $errores["descripcion"] = [0=>"Descripcion con contenido indebido. Por favor cambielo."];
                }
        
                if (!($validoImagen)){
                    $errores["imagen"] = [0=>"Imagen con contenido indebido. Por favor cambielo."];
                }
                return response()->json([
                    'success'   => false,
                    'errors'   =>  $errores[0] 
                    ], 422);
            }
        }

        return response()->json($respuesta);

    }

    

    /*
    * Funcion que lista todos los trabajos y codifica en json para mostrarlo en la aplicacion mobile
    */
    public function buscarTrabajos(){
        $objTrabajo = new Trabajo();
        $listaTrabajos = $objTrabajo->get();
        foreach($listaTrabajos as $trabajo){
            if($trabajo->imagenTrabajo == null){
                $objCategoriaTrabajo = new CategoriaTrabajo;
                $categoriaTrabajo = $objCategoriaTrabajo->find($trabajo->idCategoriaTrabajo);
                $trabajo->imagenTrabajo=$categoriaTrabajo->imagenCategoriaTrabajo;
            }
        }
        return json_encode($listaTrabajos);
    }

    /*
    * Buscamos el anuncio segun el id y lo mostramos en ver el anuncio
    */
    public function veranuncio($idTrabajo){
        //Buscamos el trabajo por el id para mostrar
        $trabajo =  Trabajo::find($idTrabajo);
        // Obtenemos el id usuario para obtener el id persona
        $idUsuario = Auth::user()->idUsuario;
        //Obtenemos el objeto Persona
        $persona = Persona::where('idUsuario','=',$idUsuario)->where('eliminado',0)->get();
        //Obtenemos el id de la persona que esta logeada
        $idPersona=$persona[0]->idPersona; 

        


        //Control del boton para elegir un postulante

        //Fecha actual
        $fechaActual = date("Y-m-d H:i:00",time());
        //Fecha que se eligio para que se postulen
        $fechaExpiracion = $trabajo->tiempoExpiracion; 

        if($fechaActual > $fechaExpiracion){
            //Si se vencio la fecha de expiracion se puedo mostrar el boton de elegir postulantes
            $anuncioExpirado = true;
            //Ahora probamos si tiene un persona asignada
            $trabajoAsignadoControl = new TrabajoasignadoController;
            $paramTrabajoAsignado = ['idTrabajo'=>$idTrabajo,'eliminado'=>0];
            $paramTrabajoAsignado = new Request($paramTrabajoAsignado);
            $personaAsignada = $trabajoAsignadoControl->buscar($paramTrabajoAsignado);
            $personaAsignada = json_decode($personaAsignada);
            if(count($personaAsignada)){
                //Si tiene una persona asignada mostramos el boton para pagar 
                $asignarPersona = true;
            }else{
                //En caso contrario le mostramos el boton para asignar una persona
                $asignarPersona = false;
            }
        }else{
            //En caso contrario se oculta
            $anuncioExpirado = false;
            //Tambien se oculta el boton de asignar persona
            $asignarPersona = false;
        }
     
        // Control para mostrar el boton de postularse
        $controlTrabajoAspirante = new TrabajoaspiranteController;
        $paramTrabajoAspirante = new Request(['idPersona'=>$idPersona,'eliminado'=>0,'idTrabajo'=>$idTrabajo]);
        $miTrabajoAspirante = $controlTrabajoAspirante->buscar($paramTrabajoAspirante);
        $miTrabajoAspirante = json_decode($miTrabajoAspirante);
        if (count($miTrabajoAspirante)>0){
            //Si ya me postule no muestro el boton
            $mostrarBotonPostularse = false;
        } else { 
            //En caso contrario se lo mostramos
            $mostrarBotonPostularse = true;
        }

        //Control si es mi anuncio
        if($idPersona == $trabajo->idPersona){
            $esMiAnuncio = true;
        }else{
            $esMiAnuncio = false;
        }
        
        //Control pago
        $pagoRecibidoController = new PagorecibidoController();
        $arregloBuscarPago=['idTrabajo'=>$idTrabajo, 'eliminado'=>0];
        $arregloBuscarPago = new Request($arregloBuscarPago);
        $busquedaPago = $pagoRecibidoController->buscar($arregloBuscarPago);
        $busquedaPago = json_decode($busquedaPago);
        if (count($busquedaPago)>0){
            //Si esta pago el anuncio seteo pagado en true
            $pagado = true;
            $objPago = $busquedaPago[0];
        } else { 
            // En caso contrario en false
            $pagado = false;
        }

        //Control si es el anuncio que me postule y esta pagado
        //para mostrar el boton de terminar el trabajo o un mensaje que el anuncio ya está expirado
        //Control pago
        $personaAsignadaPagado = new Trabajoasignado;
        $laPersonaPagada = $personaAsignadaPagado::select('trabajoasignado.idPersona')
                                ->join('pagorecibido','pagorecibido.idTrabajo','=','trabajoasignado.idTrabajo')
                                ->where('trabajoasignado.idPersona','=',$idPersona)
                                ->where('trabajoasignado.eliminado','=',0)
                                ->where('pagorecibido.eliminado','=',0)
                                ->get();


        if(count($laPersonaPagada)>0){
            $soyElAsignadoPagado = true;
        }else{
            $soyElAsignadoPagado = false;
        };

        
        
        //Si tiene una persona asignada y todavia no pago preparamos el enlace para pagar
        // Tambien verificamos que no tenga ninguna multa si no se lo sumamos
        if(!$pagado & $asignarPersona){
            // Buscamos si tiene alguna multa
            $multaController = new MultaController();
            $idPersona = $trabajo['idPersona'];
            $arregloBuscarMulta = ['idPersona'=>$idPersona,'eliminado'=>0,'pagado'=>0];
            $requestBuscarMulta = new Request($arregloBuscarMulta);
            $listaMultas = $multaController->buscar($requestBuscarMulta);
            $listaMultas = json_decode($listaMultas);

            $tieneMulta = false; // inicializamos en false
            if (count($listaMultas)>0){
                $tieneMulta = true; // Seteamos en true
                $objMulta = $listaMultas[0];
                $valorMulta = $objMulta->valor;
                $motivoMulta = $objMulta->motivo;   
            }
            
            $monto = $trabajo['monto'];
            $titulo = $trabajo['titulo'];
            
            if ($tieneMulta){
                $monto = $monto + $valorMulta;
                $titulo = $titulo . " y multa por motivo: " . $motivoMulta; 
            }
            
            $idTrabajo = $trabajo['idTrabajo'];
            $arregloTrabajo = ['monto'=>$monto,'titulo'=>$titulo,'idTrabajo'=>$idTrabajo];
            $requestTrabajo = new Request($arregloTrabajo);
            $MPController = new MercadoPagoController();
            $link = $MPController->crearPago($requestTrabajo);
            $link = json_decode($link);
        }else{
            $link = '#';
        }
        $puedeCancelar = false;

        // Si pago y asigno una persona, tiene 1 hora para poder cancelarlo y que se le cobre una multa
        if ($pagado && $asignarPersona){
            $fechaActual = Carbon::now(); // obtenemos la fecha actual
            $fechaPagado = $objPago->created_at; // Obtenemos la fecha del pago
            $fechaPagado = Carbon::parse($fechaPagado); // Hacemos el parse de la fecha del pago
            $diferenciaHora = $fechaActual->diffInHours($fechaPagado); // Obtenemos la dif de horas
            if ($diferenciaHora<1){ // si es menor a 1, significa que puede cancelarlo
                $puedeCancelar = true;
            } 
        }

        //Si es estado 4 tiene que confirmar que se realizo el trabajo
        $valorarPersona = false;
        if($trabajo->idEstado == 4){
            $valorarPersona = true;
        }

        //Si es estado 5 el trabajo esta terminado
        $trabajoTerminado = false;
        if($trabajo->idEstado == 5){
            $trabajoTerminado = true;
        }

        //Buscamos las personas que se postularon
        $listaAspirantes = Trabajoaspirante::select('trabajoaspirante.idPersona')
                                                    ->join('trabajo','trabajo.idTrabajo','=','trabajoaspirante.idTrabajo')
                                                    ->where('trabajo.idTrabajo','=',$idTrabajo)
                                                    ->where('trabajo.eliminado','=',0)
                                                    ->where('trabajoaspirante.eliminado','=',0)
                                                    ->get();

        $valoracionController = new ValoracionController;
        foreach($listaAspirantes as $aspirante){
            $idPersona = $aspirante->idPersona;
            $listaValoracionRequest = new Request(['idPersona'=>$idPersona,'eliminado'=>0]);
            $listaValoracion = $valoracionController->buscar($listaValoracionRequest);
            $listaValoracion = json_decode($listaValoracion);
            $valorMaximo = 0;
            $cantValoraciones = count($listaValoracion);
            foreach($listaValoracion as $valoracion){
                $valorMaximo = $valorMaximo + $valoracion->valor;
            }
            if($cantValoraciones == 0){
                $aspirante['valoracion'] = 0;    
            }else{
                $aspirante['valoracion'] = round($valorMaximo/$cantValoraciones);
            }
        }


        //Listamos los trabajos para mostrar en un carousel
        $listaTrabajo = Trabajo::all();

        if(isset($trabajo)){
            $vista = view('anuncio.veranuncio',compact('trabajo'),['puedeCancelar'=>$puedeCancelar,'listaTrabajo'=>$listaTrabajo,'link'=>$link,'mostrarBotonPostularse'=>$mostrarBotonPostularse,'pagado'=>$pagado,'anuncioExpirado'=>$anuncioExpirado,'esMiAnuncio'=>$esMiAnuncio,'asignarPersona'=>$asignarPersona,'soyElAsignadoPagado'=>$soyElAsignadoPagado,'valorarPersona'=>$valorarPersona,'trabajoTerminado'=>$trabajoTerminado,'listaAspirantes'=>$listaAspirantes]);
        }else{
            $vista = abort(404);
        }
       
        return $vista;
    }


    public function postulantes($idTrabajo){
        $trabajo =  Trabajo::find($idTrabajo);
        $idUsuario = Auth::user()->idUsuario; // Obtenemos el id usuario para obtener el id persona
        $persona = Persona::where('idUsuario','=',$idUsuario)->get();
        $listaPostulantes = array();

        
        if($trabajo->idPersona == $persona[0]->idPersona){
            $listaPostulantes = Trabajoaspirante::where('idTrabajo','=',$idTrabajo)->where('eliminado','=',0)->get();
        }

        $valoracionController = new ValoracionController;
        foreach($listaPostulantes as $aspirante){
            $idPersona = $aspirante->idPersona;
            $listaValoracionRequest = new Request(['idPersona'=>$idPersona,'eliminado'=>0]);
            $listaValoracion = $valoracionController->buscar($listaValoracionRequest);
            $listaValoracion = json_decode($listaValoracion);
            $valorMaximo = 0;
            $cantValoraciones = count($listaValoracion);
            foreach($listaValoracion as $valoracion){
                $valorMaximo = $valorMaximo + $valoracion->valor;
            }
            if($cantValoraciones == 0){
                $aspirante['valoracion'] = 0;    
            }else{
                $aspirante['valoracion'] = round($valorMaximo/$cantValoraciones);
            }
        }

        return view('anuncio.postulantes',['trabajo'=>$trabajo,'listaPostulantes'=>$listaPostulantes]);

    }




    public function procesarPago(){
        return view('anuncio.procesarpago');
    }

    public function buscarTrabajoParam(Request $request){
        $trabajo= Trabajo::where('idTrabajo','=',$request->idTrabajo)->get();
        return json_encode($trabajo);
    }

    // Esta funcion busca los trabajos con parametros que le enviemos
    public function buscar(Request $param){     
        $query = Trabajo::OrderBy('idTrabajo','ASC'); // Ordenamos los trabajos por este medio

            //Funciones para filtrar

            if(isset($param->filtrar)){
                $query->where("trabajo.titulo", 'like', '%'.$param->filtrar.'%');
                $query->orwhere("trabajo.descripcion", 'like', '%'.$param->filtrar.'%');
            }

            if(isset($param->rangoMonto)){
                if($param->rangoMonto>0){
                    $query->where("trabajo.monto",'<=',$param->rangoMonto);
                }
            }

            if (isset($param->categoria)){
                $query->whereIn('idCategoriaTrabajo', $param->categoria);
            }
            

            // if (isset($param->provincia)){
            //     $query->select('.idTrabajo')->whereIn('idCategoriaTrabajo', $param->categoria);
            // }

            //Otras funciones

            if (isset($param->idTrabajo)){
                $query->where("trabajo.idTrabajo",$param->idTrabajo);
            }
            
            if (isset($param->idEstado)){
                $query->where("trabajo.idEstado",$param->idEstado);
            }

            if (isset($param->idCategoriaTrabajo)){
                $query->where("trabajo.idCategoriaTrabajo",$param->idCategoriaTrabajo);
            }

            if (isset($param->idPersona)){
                $query->where("trabajo.idPersona",$param->idPersona);
            }

            if (isset($param->idLocalidad)){
                $query->where("trabajo.idLocalidad",$param->idLocalidad);
            }

            if (isset($param->titulo)){
                $query->where("trabajo.titulo",$param->titulo);
            }

            if (isset($param->descripcion)){
                $query->where("trabajo.descripcion",$param->descripcion);
            }

            if (isset($param->monto)){
                $query->where("trabajo.monto",$param->monto);
            }

            if (isset($param->imagenTrabajo)){
                $query->where("trabajo.imagenTrabajo",$param->imagenTrabajo);
            }

            if (isset($param->tiempoExpiracion)){
                $query->where("trabajo.tiempoExpiracion",$param->tiempoExpiracion);
            }

            if (isset($param->eliminado)){
                $query->where("trabajo.eliminado",$param->eliminado);
            }

            if (isset($param->idPersonaDistinto)){
                $query->where("trabajo.idPersona",'<>',$param->idPersonaDistinto);

            }

            $listaTrabajos= $query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaTrabajos);
   
    }


    // Ordenamos los trabajos para mostrar en el inicio que muestre primero los preferencias que la persona eligio
    public function ordenarTrabajosInicio(request $request){
        $preferenciaPersonaController = new PreferenciaPersonaController();

        $arregloTrabajosPreferencia = array();
        
        $idPersona = $request->idPersonaDistinto; // Obtenemos el Id Persona para obtener sus preferencias
        $arregloBuscarPreferenciaPersona = ['idPersona'=>$idPersona];
        $arregloBuscarPreferenciaPersona = new Request($arregloBuscarPreferenciaPersona);
        $listaPreferenciaPersona = $preferenciaPersonaController->buscar($arregloBuscarPreferenciaPersona);
        $listaPreferenciaPersona = json_decode($listaPreferenciaPersona);

        // Buscamos la lista de todos los trabajos ordenados por su id, independientemente de la categoria
        $listaTrabajoDesordenada = $this->buscar($request);
        $listaTrabajoDesordenada = json_decode($listaTrabajoDesordenada);

        // Vamos a generar 2 arreglos, 1 con sus preferencias, y otro sin ellas
        foreach($listaTrabajoDesordenada as $clave => $trabajo){
            $i=0; // Inicializamos contador en 0
            $encontrado=false;
            while ($i<count($listaPreferenciaPersona) && $encontrado==false){ // contador menor a cantidad de prefencias de la persona y no haya encontrado esa categoria dentro de sus preferencias
                if ($trabajo->idCategoriaTrabajo == $listaPreferenciaPersona[$i]->idCategoriaTrabajo){
                    $encontrado=true;
                    array_push($arregloTrabajosPreferencia,$trabajo); // Seteamos este trabajo en el arreglo de trabajos que prefiere ver primero
                    unset($listaTrabajoDesordenada[$clave]); // Deseteamos el trabajo del arreglo general
                }
                $i++;
            }
        }

        if (count($arregloTrabajosPreferencia)>0){ // Si existen trabajos con sus preferencias
            shuffle($arregloTrabajosPreferencia); // Los mezclamos de forma aleatorio
        }
        $listaTrabajos = array_merge($arregloTrabajosPreferencia,$listaTrabajoDesordenada); // Unimos los 2 arreglos
        return json_encode($listaTrabajos);
    }

    public function show($id)
    {
        //
        $trabajo=Trabajo::find($id);
        return  view('trabajo.show',compact('trabajo'));
    }


    public function historial(){
        $controlPersona = new PersonaController;
        $idUsuario = Auth::user()->idUsuario;
        $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
        $param = new Request($param);
        $persona = $controlPersona->buscar($param);
        $persona = json_decode($persona);
        $idPersona = $persona[0]->idPersona;

        //Buscamos todos los trabajos que anuncio la persona que estan esperando postulaciones
        $paramTrabajos = new Request(['idPersona'=>$idPersona,'eliminado'=>0,'idEstado'=>1]);
        $listaTrabajos = $this->buscar($paramTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);

        //Buscamos todos los trabajos que anuncio la persona que ya se puede evaluar las postulaciones
        $paramTrabajosEvaluar = new Request(['idPersona'=>$idPersona,'eliminado'=>0,'idEstado'=>2]);
        $listaTrabajosEvaluar = $this->buscar($paramTrabajosEvaluar);
        $listaTrabajosEvaluar = json_decode($listaTrabajosEvaluar);

        //Buscamos todos los trabajos que anuncio la persona que estan esperando la confirmacion
        $paramTrabajosTerminados = new Request(['idPersona'=>$idPersona,'eliminado'=>0,'idEstado'=>4]);
        $listaTrabajosTerminados = $this->buscar($paramTrabajosTerminados);
        $listaTrabajosTerminados = json_decode($listaTrabajosTerminados);

        //Buscamos todos los trabajos que anuncio la persona que estan cerradas
        $paramTrabajosCerradas = new Request(['idPersona'=>$idPersona,'eliminado'=>0,'idEstado'=>5]);
        $listaTrabajosCerradas = $this->buscar($paramTrabajosCerradas);
        $listaTrabajosCerradas = json_decode($listaTrabajosCerradas);

        $paramTrabajosEsperar = new Request(['eliminado='=>0,'idEstado'=>3]);
        $listaTrabajosEsperar = $this->buscar($paramTrabajosEsperar);
        $listaTrabajosEsperar = json_decode($listaTrabajosEsperar);

        $categoriaTrabajo = new CategoriaTrabajo;

        return view('anuncio.historial',['listaTrabajos'=>$listaTrabajos,'listaTrabajosEsperar'=>$listaTrabajosEsperar,'listaTrabajosTerminados'=>$listaTrabajosTerminados,'listaTrabajosEvaluar'=>$listaTrabajosEvaluar,'listaTrabajosCerradas'=>$listaTrabajosCerradas,'categoriaTrabajo'=>$categoriaTrabajo]);

    }


    public function mispostulaciones(){
        //Creamos el objeto control persona para poder buscar a la persona que esta logeada
        $controlPersona = new PersonaController;
        //Para ello primero vemos quien esta logeado y tomamos su idUsuario
        $idUsuario = Auth::user()->idUsuario;
        $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
        $param = new Request($param);
        $persona = $controlPersona->buscar($param);
        $persona = json_decode($persona);
        $idPersona = $persona[0]->idPersona;

        //Con el idPersona buscamos los trabajos terminados por el
        $listaTrabajosCerrados = Trabajoasignado::select('trabajoasignado.idTrabajo')
                                                    ->join('trabajo','trabajo.idTrabajo','=','trabajoasignado.idTrabajo')
                                                    ->join('pagorecibido','trabajo.idTrabajo','=','pagorecibido.idTrabajo')
                                                    ->where('trabajoasignado.idPersona','=',$idPersona)
                                                    ->where('trabajoasignado.eliminado','=',0)
                                                    ->where('trabajo.eliminado','=',0)
                                                    ->where('pagorecibido.eliminado','=',0)
                                                    ->where('trabajo.idEstado','=',5)
                                                    ->get();

        //Con el idPersona buscamos los trabajos terminados por el
        $listaTrabajosTerminados = Trabajoasignado::select('trabajoasignado.idTrabajo')
                                                    ->join('trabajo','trabajo.idTrabajo','=','trabajoasignado.idTrabajo')
                                                    ->join('pagorecibido','trabajo.idTrabajo','=','pagorecibido.idTrabajo')
                                                    ->where('trabajoasignado.idPersona','=',$idPersona)
                                                    ->where('trabajoasignado.eliminado','=',0)
                                                    ->where('trabajo.eliminado','=',0)
                                                    ->where('pagorecibido.eliminado','=',0)
                                                    ->where('trabajo.idEstado','=',4)
                                                    ->get();

        //Con el idPersona buscamos los trabajos asignados
        $listaTrabajosAsignados = Trabajoasignado::select('trabajoasignado.idTrabajo')
                                                    ->join('trabajo','trabajo.idTrabajo','=','trabajoasignado.idTrabajo')
                                                    ->join('pagorecibido','trabajo.idTrabajo','=','pagorecibido.idTrabajo')
                                                    ->where('trabajoasignado.idPersona','=',$idPersona)
                                                    ->where('trabajoasignado.eliminado','=',0)
                                                    ->where('trabajo.eliminado','=',0)
                                                    ->where('pagorecibido.eliminado','=',0)
                                                    ->where('trabajo.idEstado','=',3)
                                                    ->get();

        //Con el idPersona buscamos los trabajos que se postulo
        $listaTrabajosAspirante = Trabajoaspirante::select('trabajo.idTrabajo')
                                                    ->join('trabajo','trabajo.idTrabajo','=','trabajoaspirante.idTrabajo')
                                                    ->where('trabajoaspirante.idPersona','=',$idPersona)
                                                    ->where('trabajoaspirante.eliminado','=',0)
                                                    ->where('trabajo.eliminado','=',0)
                                                    ->where('trabajo.idEstado','!=',3)
                                                    ->where('trabajo.idEstado','!=',4)
                                                    ->where('trabajo.idEstado','!=',5)
                                                    ->get();
           
        $categoriaTrabajo = new CategoriaTrabajo;                                           
        return view('anuncio.mispostulaciones',['listaTrabajosAsignados'=>$listaTrabajosAsignados,'listaTrabajosAspirante'=>$listaTrabajosAspirante,'listaTrabajosTerminados'=>$listaTrabajosTerminados,'listaTrabajosCerrados'=>$listaTrabajosCerrados,'categoriaTrabajo'=>$categoriaTrabajo]);

    }

    public function misTrabajosFinalizados(Request $request){
        $idPersona=$request->idPersona;
        //Con el idPersona buscamos los trabajos asignados
        $listaTrabajosTerminados = Trabajoasignado::select('trabajoasignado.idTrabajo')
                                                    ->join('trabajo','trabajo.idTrabajo','=','trabajoasignado.idTrabajo')
                                                    ->join('pagorecibido','trabajo.idTrabajo','=','pagorecibido.idTrabajo')
                                                    ->where('trabajoasignado.idPersona','=',$idPersona)
                                                    ->where('trabajoasignado.eliminado','=',0)
                                                    ->where('trabajo.idEstado','=',5)
                                                    ->get();
                                                    $lista=array();
                                                    foreach($listaTrabajosTerminados as $trabajo){
                                                        $idTrabajo=$trabajo->idTrabajo;
                                                        $param=['idTrabajo'=>$idTrabajo];
                                                        $param=new Request($param);
                                                        $objTrabajo=$this->buscar($param);
                                                        $objTrabajo=\json_decode($objTrabajo);
                                                        array_push($lista,$objTrabajo);
                                                    }
                                                    return \json_encode($lista);
    } 

    public function trabajorealizado($idTrabajo){
        return view('anuncio.trabajorealizado',['idTrabajo'=>$idTrabajo]);
    }

    public function terminado(Request $request){
        $idTrabajo = $request->idTrabajo;
        //Actualizamos el estado del trabajo
        $trabajo = new Trabajo;
        $trabajo->where('idTrabajo','=', $idTrabajo)->update(['idEstado'=>4]);
        //Y la tabla estadotrabajo tambien actualizamos
        $paramEstadotrabajo = ['idTrabajo'=>$idTrabajo,'idEstado'=>4];
        $requesEstadoTrabajo = new Request($paramEstadotrabajo);
        Estadotrabajo::create($requesEstadoTrabajo->all());

        
        return redirect()->route('inicio')->with('success','Gracias por el trabajo realizado');

    }
    public function buscarPersonaTrabajo(Request $request){
        $trabajoController= new TrabajoController;
        $trabajo= $trabajoController->buscar($request);
        $objTrabajo= json_decode($trabajo);
        $idPersonaTrabajo= $objTrabajo[0]->idPersona;
        return \json_encode($idPersonaTrabajo);
    }

    public function  valor($idTrabajo){
        //buscamos el trabajo que la persona lo termino y espera que lo valoren
        $trabajo=Trabajo::where('idTrabajo','=', $idTrabajo)->where(['idEstado'=>4])->where(['eliminado'=>0])->get()[0];
        //Buscamos la persona asignada que termino el trabajo
        $controlTrabajoAsignado = new TrabajoasignadoController;
        //Creamos el arreglo $param que lo utilizaremos para crear el Request y buscar el trabajo asignado
        $paramTrabajoAsignado = new Request(['idTrabajo'=>$idTrabajo,'eliminado'=>0]);
        $trabajoAsignado = $controlTrabajoAsignado->buscar($paramTrabajoAsignado);
        $trabajoAsignado = json_decode($trabajoAsignado);
        //Ahora obtenemos el idPersona
        $idPersona = $trabajoAsignado[0]->idPersona;
        //Y buscamos la persona
        $controlPersona = new PersonaController;
        $paramControlPersona = new Request(['idPersona'=>$idPersona, 'eliminado'=>0]);
        $persona = $controlPersona->buscar($paramControlPersona);
        $persona = json_decode($persona);
        $persona = $persona[0];
        //Enviamos los datos a la vista para mostrar la informacion
        return view('anuncio.valoracion',['trabajo'=>$trabajo,'persona'=>$persona]);
    }

    public function cancelartrabajo($idTrabajo){
        $trabajo=Trabajo::where('idTrabajo','=', $idTrabajo)->get()[0];
        return  view('anuncio.cancelar',compact('trabajo'));
        //return view('anuncio.index',['provincias'=>$listaProvincias,'listaCategoriaTrabajo'=>$listaCategoriaTrabajo]);

    }

    public function update(Request $request)
    {
        $idTrabajo = $request->idTrabajo;
        if (Trabajo::find($idTrabajo)->update($request->all())){ // Si actualiza su perfil , obtenemos su id para llenar el resto de las tablas
            return response()->json([
                'url' => route('inicio'),
                'success'   => true,
                'message'   => 'Los datos se han guardado correctamente.'
                ], 200);        
        } else {
            return response()->json([
                'success'   => false,
                'errors'   =>  'Ocurrio un error'
                ], 422);
        }
    }

    // Funciones para mostrar la vista del panel de administrador de trabajo

    public function destroy($id)
    {
        // Actualizamos eliminado a 1 (Borrado lógico)
        Trabajo::where('idTrabajo',$id)->update(['eliminado'=>1]);
        //Trabajo::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('trabajo.indexpanel')->with('success','Registro eliminado satisfactoriamente');
    }

    public function indexpanel()
    {
        //
        $trabajos=Trabajo::orderBy('idTrabajo','DESC')->where('eliminado','0')->paginate(15);
        return view('trabajo.indexpanel',compact('trabajos'));
    }

    public function createpanel(){
        $categoriaTrabajoController = new CategoriaTrabajoController();
        $provinciaController = new ProvinciaController();
        $personaController = new PersonaController();
        $estadoController = new EstadoController();

        $arregloBuscarCategorias=['eliminado' => 0];
        $arregloBuscarCategorias = new Request($arregloBuscarCategorias);
        $listaCategoriaTrabajo=$categoriaTrabajoController->buscar($arregloBuscarCategorias);
        $listaCategoriaTrabajo = json_decode($listaCategoriaTrabajo);

        $arregloBuscarProvincias=['eliminado' => 0];
        $arregloBuscarProvincias = new Request($arregloBuscarProvincias);
        $listaProvincias=$provinciaController->buscar($arregloBuscarProvincias);
        $listaProvincias = json_decode($listaProvincias);

        $arregloBuscarPersonas = ['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);

        $arregloBuscarEstados = ['eliminado'=>0];
        $arregloBuscarEstados = new Request($arregloBuscarEstados);
        $listaEstados=$estadoController->buscar($arregloBuscarEstados);
        $listaEstados = json_decode($listaEstados);

        return view('trabajo.createpanel',['listaPersonas'=>$listaPersonas,'listaEstados'=>$listaEstados,'provincias'=>$listaProvincias,'listaCategoriaTrabajo'=>$listaCategoriaTrabajo]);
    }

    public function editpanel($id)
    {   
        $categoriaTrabajoController = new CategoriaTrabajoController();
        $provinciaController = new ProvinciaController();
        $personaController = new PersonaController();
        $estadoController = new EstadoController();
        $trabajoController = new TrabajoController();

        $arregloBuscarCategorias=['eliminado' => 0];
        $arregloBuscarCategorias = new Request($arregloBuscarCategorias);
        $listaCategorias=$categoriaTrabajoController->buscar($arregloBuscarCategorias);
        $listaCategorias = json_decode($listaCategorias);

        $arregloBuscarProvincias=['eliminado' => 0];
        $arregloBuscarProvincias = new Request($arregloBuscarProvincias);
        $listaProvincias=$provinciaController->buscar($arregloBuscarProvincias);
        $listaProvincias = json_decode($listaProvincias);

        $arregloBuscarPersonas = ['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);

        $arregloBuscarEstados = ['eliminado'=>0];
        $arregloBuscarEstados = new Request($arregloBuscarEstados);
        $listaEstados=$estadoController->buscar($arregloBuscarEstados);
        $listaEstados = json_decode($listaEstados);

      //  $arregloBuscarTrabajo = ['idTrabajo'=>$id];
      //  $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
      //   $listaTrabajos = $trabajoController->buscar($arregloBuscarTrabajo);
      //    $listaTrabajos = json_decode($listaTrabajos);
      //     $trabajo = $listaTrabajos[0];
        $trabajo=Trabajo::where('idTrabajo',$id)->get();
        $trabajo=$trabajo[0];
        return view('trabajo.editpanel',compact('trabajo'),['listaPersonas'=>$listaPersonas,'listaEstados'=>$listaEstados,'listaProvincias'=>$listaProvincias,'listaCategorias'=>$listaCategorias]);
    }

    public function storepanel(Request $request)
    {    

        if (!(isset($request->idEstado))){ // Es decir viene el trabajo normal, no desde el panel de adm
            $request['idEstado'] = 1;
        }

        $mensajesErrores =[             
            'titulo.required' => 'El titulo es obligatorio.',
            'titulo.max' => 'Maximo de letras sobrepasado.',
            'descripcion.required' => 'La descripcion es obligatoria.',
            'descripcion.max' => 'Maximo de letras sobrepasado.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'Solamente se puede ingresar numeros.',
            'tiempoExpiracion.required' => 'Debe ingresar hasta cu&aacute;ndo va a esperar postulaciones.',
            'idCategoriaTrabajo.required'=> 'La categoria es obligatoria',
            'idEstado.required'=> 'El estado es obligatorio',
            'idPersona.required'=> 'La persona es obligatoria',
            
        ] ;

        //Validaciones del trabajo
        $this->validate($request,['idCategoriaTrabajo'=>'required','idEstado'=>'required','idPersona'=>'required','titulo'=>'required|max:255', 'descripcion'=>'required|max:511', 'monto'=>'required|numeric','tiempoExpiracion'=>'required|date','imagenTrabajo' =>'nullable:true'],$mensajesErrores);
      
        
        //Seteamo como 'esperando postulaciones'       

        if(isset($request['imagenTrabajo']) && $request['imagenTrabajo']!=null){
                $imagen=$request->file('imagenTrabajo'); // Obtenemos el obj de la img
                $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
                $nombreImagen = $request['idPersona'].'fotoTrabajo'.date("YmdHms").'.'. $extension;
                $request = $request->except('imagenTrabajo'); // Guardamos todo el obj sin la clave imagen trabajo
                $request['imagenTrabajo']=$nombreImagen; // Asignamos de nuevo a imagenTrabajo, su nombre
                $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                $imagen = File::get($imagen);
                Storage::disk('trabajo')->put($nombreImagen, $imagen);        
            }

            if (Trabajo::create($request->all())){
                return response()->json([
                    'url' => route('inicio'),
                    'success'   => true,
                    'message'   => 'Los datos se han guardado correctamente.' 
                    ], 200);
            } else {
                return response()->json([
                    'success'   => false,
                    'errors'   =>  'Ocurrio un error'
                    ], 422);
            }
        
    }

    public function updatepanel(Request $request)
    {
        $mensajesErrores =[             
            'titulo.required' => 'El titulo es obligatorio.',
            'titulo.max' => 'Maximo de letras sobrepasado.',
            'descripcion.required' => 'La descripcion es obligatoria.',
            'descripcion.max' => 'Maximo de letras sobrepasado.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'Solamente se puede ingresar numeros.',
            'tiempoExpiracion.required' => 'La fecha de expiracion es obligatorio',
            'idCategoriaTrabajo.required'=> 'La categoria es obligatoria',
            'idEstado.required'=> 'El estado es obligatorio',
            'idPersona.required'=> 'La persona es obligatoria',
            
        ] ;

        //Validaciones del trabajo
        $this->validate($request,['idCategoriaTrabajo'=>'required','idEstado'=>'required','idPersona'=>'required','titulo'=>'required|max:255', 'descripcion'=>'required|max:511', 'monto'=>'required|numeric','tiempoExpiracion'=>'required|date','imagenTrabajo' =>'nullable:true'],$mensajesErrores);
      
        $idTrabajo=$request->idTrabajo;

        if (Trabajo::find($idTrabajo)->update($request->all())){ // Si actualiza su perfil , obtenemos su id para llenar el resto de las tablas
            return response()->json([
                'url' => route('trabajo.index'),
                'success'   => true,
                'message'   => 'Los datos se han guardado correctamente.'
                ], 200);        
        } else {
            return response()->json([
                'success'   => false,
                'errors'   =>  'Ocurrio un error'
                ], 422);
        }
    }
    
    // Recibimos por parametro el id trabajo. Enviamos a la funcion del email controller el obj trabajo, obj persona creador de este, objpersona y objusuario del asignado 
    public function enviarMailConfirmacionAsignado(request $request){

        // Hacemos la creacion de los objs controladores
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $usuarioController = new UserController();
        
        $idTrabajo = $request->idTrabajo; // Obtenemos el id del trabajo para buscar el trabajo 

        // Obtenemos el trabajo que se asigno
        $arregloBuscarTrabajo = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
        $listaTrabajo = $trabajoController->buscar($arregloBuscarTrabajo);
        $listaTrabajo = json_decode($listaTrabajo);
        $objTrabajo = $listaTrabajo[0];

        // Obtenemos el idPersona del creador del trabajo

        $idPersonaCreador = $objTrabajo->idPersona;
        $arregloBuscarPersonaCreador = ['idPersona'=>$idPersonaCreador];
        $arregloBuscarPersonaCreador = new Request($arregloBuscarPersonaCreador);
        $listaPersonaCreador = $personaController->buscar($arregloBuscarPersonaCreador);
        $listaPersonaCreador = json_decode($listaPersonaCreador);
        $objPersonaCreador = $listaPersonaCreador[0];

        // Buscamos el trabajo asignado
        $arregloBuscarTrabajoAsignado = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajoAsignado = new Request($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = $this->buscar($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = json_decode($listaTrabajoAsignado);
        $objTrabajoAsignado = $listaTrabajoAsignado[0]; // Obtenemos el trabajo asignado

        // Obtenemos el idPersona de la persona asignada del trabajo

        $idPersonaAsignado = $objTrabajoAsignado->idPersona;
        $arregloBuscarPersonaAsignada = ['idPersona'=>$idPersonaAsignado];
        $arregloBuscarPersonaAsignada = new Request($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = $personaController->buscar($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = json_decode($listaPersonaAsignada);
        $objPersonaAsignado = $listaPersonaAsignada[0];

        // Obtenemos el usuario de la persona asignada del trabajo (en ella esta su mail)
       
        $idUsuarioAsignado = $objPersonaAsignado->idUsuario;
        $arregloBuscarUsuarioAsignado = ['idUsuario'=>$idUsuarioAsignado];
        $arregloBuscarUsuarioAsignado = new Request($arregloBuscarUsuarioAsignado);
        $listaUsuarioAsignado = $usuarioController->buscar($arregloBuscarUsuarioAsignado);
        $listaUsuarioAsignado = json_decode($listaUsuarioAsignado);
        $objUsuarioAsignado = $listaUsuarioAsignado[0];
        
        $mail = new EmailController;
        if ($mail->enviarMailConfirmacionAsignado($objUsuarioAsignado,$objPersonaAsignado,$objTrabajo,$objPersonaCreador)){
            $respuesta = true;
        } else {
            $respuesta = false;
        }
        return $respuesta;
    }

    // Recibimos por parametro el id trabajo. Enviamos a la funcion del email controller el obj trabajo, obj persona creador de este, objpersona y objusuario del asignado 
    // Aca llama a la funcion que va a enviar el mail para que confirme si el trabajo se hizo bien
    public function enviarMailConfirmarTrabajo (request $request){
        // Hacemos la creacion de los objs controladores
        $trabajoAsignadoController = new TrabajoasignadoController;
        $personaController = new PersonaController;
        $usuarioController = new UserController;
        
        $idTrabajo = $request->idTrabajo; // Obtenemos el id del trabajo para buscar el trabajo 

        // Obtenemos el trabajo que se asigno
        $arregloBuscarTrabajo = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
        $listaTrabajo = $this->buscar($arregloBuscarTrabajo);
        $listaTrabajo = json_decode($listaTrabajo);
        $objTrabajo = $listaTrabajo[0];

        // Obtenemos el idPersona del creador del trabajo

        $idPersonaCreador = $objTrabajo->idPersona;
        $arregloBuscarPersonaCreador = ['idPersona'=>$idPersonaCreador];
        $arregloBuscarPersonaCreador = new Request($arregloBuscarPersonaCreador);
        $listaPersonaCreador = $personaController->buscar($arregloBuscarPersonaCreador);
        $listaPersonaCreador = json_decode($listaPersonaCreador);
        $objPersonaCreador = $listaPersonaCreador[0];

        // Buscamos el trabajo asignado
        $arregloBuscarTrabajoAsignado = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajoAsignado = new Request($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = $trabajoAsignadoController->buscar($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = json_decode($listaTrabajoAsignado);
        $objTrabajoAsignado = $listaTrabajoAsignado[0]; // Obtenemos el trabajo asignado
        
        // Obtenemos el idPersona de la persona asignada del trabajo

        $idPersonaAsignado = $objTrabajoAsignado->idPersona;
        $arregloBuscarPersonaAsignada = ['idPersona'=>$idPersonaAsignado];
        $arregloBuscarPersonaAsignada = new Request($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = $personaController->buscar($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = json_decode($listaPersonaAsignada);
        $objPersonaAsignado = $listaPersonaAsignada[0];

        // Obtenemos el usuario de la persona asignada del trabajo (en ella esta su mail)
    
        $idUsuarioCreador = $objPersonaCreador->idUsuario;
        $arregloBuscarUsuarioCreador = ['idUsuario'=>$idUsuarioCreador];
        $arregloBuscarUsuarioCreador = new Request($arregloBuscarUsuarioCreador);
        $listaUsuarioCreador = $usuarioController->buscar($arregloBuscarUsuarioCreador);
        $listaUsuarioCreador = json_decode($listaUsuarioCreador);
        $objUsuarioCreador = $listaUsuarioCreador[0];

        $mail = new EmailController;
        if ($mail->enviarMailConfirmarTrabajo($objUsuarioCreador,$objPersonaAsignado,$objTrabajo,$objPersonaCreador)){
            $respuesta = true;
        } else {
            $respuesta = false;
        }
        return $respuesta;
    }
    
    public function filtrar(Request $request){
        $param=['idEstado'=>'1','eliminado'=>0,'filtrar'=>$request->filtrar,'categoria'=>$request->categoria,'rangoMonto'=>$request->rangoMonto, 'provincia'=>$request->provincia];
        $trabajoController = new TrabajoController();
        $param = new Request($param);
        $listaTrabajos =$trabajoController->buscar($param);
        $listaTrabajos = json_decode($listaTrabajos);
        $categoriaTrabajo = new CategoriaTrabajo;
        $listaCategoria = CategoriaTrabajo::all();
        $provincias = Provincia::all();
        $busqueda = true;
        return view('layouts/mainlayout',['listaTrabajos'=>$listaTrabajos,'categoriaTrabajo'=>$categoriaTrabajo,'listaCategoria'=>$listaCategoria, 'busqueda'=>$busqueda, 'provincias'=>$provincias]);
    }

}

