<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Conductor;
use App\Conductordocument;
use Illuminate\Support\Facades\DB;

class ConductordocumentController extends Controller
{
    protected $folderview      = 'app.conductordocument';
    protected $tituloAdmin     = 'Documentos del conductor';
    protected $tituloRegistrar = 'Registrar documento';
    protected $tituloModificar = 'Modificar documento';
    protected $tituloEliminar  = 'Eliminar documento';
    protected $rutas           = array('create' => 'conductordocument.create', 
            'edit'   => 'conductordocument.edit', 
            'delete' => 'conductordocument.eliminar',
            'search' => 'conductordocument.buscar',
            'index'  => 'conductordocument.index',
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
        $entidad          = 'conductordocument';

        $conductor_id      = Libreria::getParam($request->input('conductor_id'));
        $tipo             = Libreria::getParam($request->input('tipo'));

        $resultado        = Conductordocument::getlist($conductor_id, $tipo);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'F. Registro', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Archivo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Opciones', 'numero' => '2');
        
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
        
        $entidad          = 'conductordocument';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $conductor_id	  = $request->input('conductor_id');
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'conductor_id'));
    }

    public function store(Request $request){
        $reglas = array(
    		'fecha'   => 'required',
            'archivo' => 'required'
        );
        $mensajes = array(
        	'fecha.required'   => 'Debe ingresar una fecha',  
            'archivo.required' => 'Debe ingresar archivo'
        );

        $validacion = Validator::make($request->all(), $reglas, $mensajes);

        if ($validacion->fails()) return $validacion->messages()->toJson();

        $error = DB::transaction(function() use($request){

     		$conductordocument = new Conductordocument();

     		$conductordocument->tipo =  $request->input('tipo');

            $archivo  = $request->file('archivo');
            $fileName =   date("Y_m_d") . '_'. $archivo->getClientOriginalName();
            $vehiculodocument->archivo =  $fileName;
            $archivo->move(public_path('files/documento_vehiculo/'), $fileName);       
            

     		$vehiculodocument->vehiculo_id = $request->input('vehiculo_id');

            $vehiculodocument->save();
        });
        return is_null($error) ? "OK" : $error;
    }
}
