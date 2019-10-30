<?php

namespace App\Http\Controllers;

use App\CategoriaTrabajo;
use App\Trabajo;
use Illuminate\Http\Request;
use Auth;
use App\Persona;
use App\Trabajoaspirante;
use App\Pagorecibido;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PagorecibidoController;
use App\Http\Controllers\TrabajoaspiranteController;

use App\Localidad;
use App\Provincia;
use App\Comentario;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


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
        $arregloBuscarCategorias=['eliminado'=>0];
        $arregloBuscarProvincias=['eliminado'=>0];
        $categoriaTrabajoController = new CategoriaTrabajoController();
        $provinciaController = new ProvinciaController();
        $arregloBuscarCategorias = new Request($arregloBuscarCategorias);
        $arregloBuscarProvincias = new Request($arregloBuscarProvincias);
        $listaCategoriaTrabajo=$categoriaTrabajoController->buscar($arregloBuscarCategorias);
        $listaProvincias=$provinciaController->buscar($arregloBuscarProvincias);
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
        //Seteamo como 'esperando postulaciones'
        $request['idTipoTrabajo'] = 1;
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
        $idUsuario = Auth::user()->idUsuario; // Obtenemos el id usuario para obtener el id persona
        $persona = Persona::where('idUsuario','=',$idUsuario)->get();
        $idPersona=$persona[0]->idPersona;
        // Verificamos si ya se postulo a este trabajo. Si se postulo,no mostramos el mensaje de postularse nuevamente
        $busquedaPostulacion = Trabajoaspirante::where('idPersona','=',$idPersona)->where('idTrabajo','=',$idTrabajo)->get();
        
        $listaPostulantes = array();
        if($trabajo->idPersona == $persona[0]->idPersona){
            $listaPostulantes = Trabajoaspirante::where('idTrabajo','=',$idTrabajo)->where('eliminado','=',0)->get();
        }


        $pagoRecibidoController = new PagorecibidoController();
        $arregloBuscarPago=['idTrabajo'=>$idTrabajo];
        $arregloBuscarPago = new Request($arregloBuscarPago);
        $busquedaPago = $pagoRecibidoController->buscar($arregloBuscarPago);
        
        if (count($busquedaPostulacion)>0 || $idPersona==$trabajo->persona->idPersona){ // Significa que ya se postulo anteriormente o es su propio anuncio
            $tienePostulacion = true;
        } else { // No se postulo
            $tienePostulacion = false;
        }
        

        if (count($busquedaPago)>0){ // Significa que ya se pago este trabajo
            $pagado = true;
        } else { // Todavia no se paga
            $pagado = false;
        }

        if($trabajo->imagenTrabajo == null){
            $objetoCategoriaTrabajo = new CategoriaTrabajo;
            //Buscamos el objeto de categoria trabajo
            $categoriaTrabajo = $objetoCategoriaTrabajo->find($trabajo->idCategoriaTrabajo);
            $trabajo['imagenCategoria'] = $categoriaTrabajo->imagenCategoriaTrabajo;
        }

        $monto = $trabajo['monto'];
        $titulo = $trabajo['titulo'];
        $idTrabajo = $trabajo['idTrabajo'];
        $arregloTrabajo = ['monto'=>$monto,'titulo'=>$titulo,'idTrabajo'=>$idTrabajo];
        $requestTrabajo = new Request($arregloTrabajo);
        $MPController = new MercadoPagoController();
        $link = $MPController->crearPago($requestTrabajo);

        //Listamos los trabajos para mostrar en un carousel
        $listaTrabajo = Trabajo::all();

        if(isset($trabajo)){
            return view('anuncio.veranuncio',compact('trabajo'),['listaTrabajo'=>$listaTrabajo,'link'=>$link,'tienePostulacion'=>$tienePostulacion,'pagado'=>$pagado,'listaPostulantes'=>$listaPostulantes]);
        }else{
            return abort(404);
        }
       
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

            $listaTrabajos= $query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaTrabajos);
   
    }


    public function historial(){
        $controlPersona = new PersonaController;
        $idUsuario = Auth::user()->idUsuario;
        $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
        $param = new Request($param);
        $persona = $controlPersona->buscar($param);
        $persona = json_decode($persona);
        $idPersona = $persona[0]->idPersona;
        $paramTrabajos = new Request(['idPersona'=>$idPersona]);
        $listaTrabajos = $this->buscar($paramTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        

        return view('anuncio.historial',compact('listaTrabajos'));

    }
}

