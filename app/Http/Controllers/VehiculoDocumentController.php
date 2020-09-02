<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Vehiculo;
use App\Librerias\Libreria;
use App\Vehiculodocument;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VehiculoDocumentController extends Controller
{
    protected $folderview      = 'app.vehiculodocument';
    protected $tituloAdmin     = 'Documentos de vehículo';
    protected $tituloRegistrar = 'Registrar documento';
    protected $tituloModificar = 'Modificar documento';
    protected $tituloEliminar  = 'Eliminar documento';
    protected $rutas           = array('create' => 'vehiculodocument.create', 
            'edit'   => 'vehiculodocument.edit', 
            'delete' => 'vehiculodocument.eliminar',
            'search' => 'vehiculodocument.buscar',
            'index'  => 'vehiculodocument.index',
        );

       /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'vehiculodocument';

        $vehiculo_id      = Libreria::getParam($request->input('vehiculo_id'));
        $tipo             = Libreria::getParam($request->input('tipo'));
  

        $filtro           = array();
        $filtro[]         = ['vehiculo_id',$vehiculo_id];
        $filtro[]         = ['tipo', $tipo];

        $resultado        = Vehiculodocument::where($filtro)->orderBy('fecha');

        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha de V', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');
        
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $ruta             = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index( Request $request ){
        
        $entidad          = 'vehiculodocument';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $vehiculo_id	  = $request->input('vehiculo_id');
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'vehiculo_id'));
    }

    public  function create(){

    }
    public function store(Request $request){


        $reglas     = array(
    						'fecha' 				=> 'required'
                        );
        $mensajes = array(
        	'fecha.required'         		  => 'Debe ingresar una fecha',  
            );

        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
     		$vehiculodocument = new Vehiculodocument();

     		$vehiculodocument->fecha =  $request->input('fecha');
     		$vehiculodocument->tipo =  $request->input('tipo');
     		$vehiculodocument->vehiculo_id = $request->input('vehiculo_id');

            $vehiculodocument->save();
        });
        return is_null($error) ? "OK" : $error;
    }
    public function edit(){

    }
    public function update($id, Request $request){
    	$existe = Libreria::verificarExistencia($id, 'vehiculodocument');
        if ($existe !== true) {
            return $existe;
        }
    	$reglas     = array(
    						'fecha' 				=> 'required'
                        );
        $mensajes = array(
        	'fecha.required'         		  => 'Debe ingresar una fecha',  
            );

        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request, $id){
     		$vehiculodocument =  Vehiculodocument::find($id);

     		$vehiculodocument->fecha =  $request->input('fecha');
     		$vehiculodocument->tipo =  $request->input('tipo');
     		$vehiculodocument->vehiculo_id = $request->input('vehiculo_id');

            $vehiculodocument->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'vehiculodocument');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $vehiculo = Vehiculodocument::find($id);
            $vehiculo->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'vehiculodocument');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje = true;
        $modelo   = Vehiculo::find($id);
        $entidad  = 'vehiculodocument';
        $formData = array('route' => array('vehiculodocument.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }



}
