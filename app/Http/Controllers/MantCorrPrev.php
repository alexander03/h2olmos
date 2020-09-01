<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Checklistvehicular;
use App\Unidad;
use App\Equipo;
use App\Vehiculo;
use App\Conductor;
use App\Ua;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Concesionaria;

class MantCorrPrev extends Controller
{
    protected $folderview      = 'app.mantcorrprev';
    protected $tituloAdmin     = 'Check list vehicular';
    protected $tituloCheckListVehicular = 'Nuevo Check List Vehicular';
    protected $tituloRegistrar = 'Registro de Repuesto Vehicular';
    protected $tituloModificar = 'Modificar repuesto';
    protected $tituloEliminar  = 'Eliminar repuesto';
    protected $tituloActivar  = 'Activar repuesto';
    protected $rutas           = array(
        // 'createchecklistvehicular' => 'mantcorrprev.createchecklistvehicular', 
        'create' => 'mantcorrprev.create',
        // 'createrepuesto' => 'mantcorrprev.createrepuesto',
        'buscarporua' => 'mantcorrprev.buscarporua',
        'edit'   => 'mantcorrprev.edit', 
        // 'delete' => 'mantcorrprev.eliminar',
        'activar' => 'mantcorrprev.activar',
        'search' => 'mantcorrprev.buscar',
        'store' => 'mantcorrprev.store',
        'index'  => 'mantcorrprev.index',
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Checklistvehicular';
        // $filter           = Libreria::getParam($request->input('filter'));
        // $estado           = $request->input('estado');
        // $unidad           = $request->input('unidad');
        $fecha_registro   = $request->input('fecha_registro');
        $resultado        = Checklistvehicular::getFilter($fecha_registro);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'F. Registro', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Equipo/Vehiculo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'K. Inicial', 'numero' => '1');
        $cabecera[]       = array('valor' => 'K. Final', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Lider del area', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Conductor', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $titulo_registrar = $this->tituloRegistrar;
        $titulo_activar  = $this->tituloActivar;
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar','titulo_registrar', 'titulo_activar','ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index()
    {
        $entidad          = 'Checklistvehicular';
        $title            = $this->tituloAdmin;
        $tituloCheckListVehicular = $this->tituloCheckListVehicular;
        $tituloRegistrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'tituloCheckListVehicular','tituloRegistrar', 'ruta'));
    }

    public function create(Request $request) {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'Checklistvehicular';
        $checklistvehicular = null;
        $unidad_placa = null;
        $unidad_descripcion = null;
        $formData = array('mantcorrprev.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        $arrConductores = Conductor::getAll();
        $cboConductores = array('' => 'Seleccione');
        foreach($arrConductores as $k=>$v){
            $cboConductores += array($v->id => $v->nombres . $v->apellidos);
        }
        return view($this->folderview.'.mant_checklistvehicular')->with(compact('checklistvehicular', 'formData', 'entidad', 'unidad_placa', 'unidad_descripcion', 'cboConductores', 'boton', 'listar'));
    }

    public function store(Request $request) {
        
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        // $reglas     = array(
            //     'codigo' => 'required|digits:7|unique:repuesto,codigo',
            //     'descripcion' => 'required|max:100|unique:repuesto,descripcion',
            //     'unidad_id' => 'required'
            // );
            // $mensajes = array(
                //     'codigo.required' => 'Debe ingresar un código',
                //     'codigo.unique' => 'Este código ya existe',
                //     'codigo.digits' => 'El código debe tener 7 cifras',
                //     'descripcion.required' => 'Debe ingresar una descripcion',
                //     'descripcion.unique' => 'Esta descripción ya existe',
                //     'descripcion.max' => 'La descripcion debe tener max. 100 caracteres',
                //     'unidad_id.required' => 'Debe seleccionar una unidad'
                // );
                // $validacion = Validator::make($request->all(), $reglas, $mensajes);
                // if ($validacion->fails()) {
                    //     return $validacion->messages()->toJson();
                    // }
        $error = DB::transaction(function() use($request){
            
            $checklistvehicular = new Checklistvehicular();
            $checklistvehicular->fecha_registro= $request->input('fecha_registro');

            $placa = $request->input('unidad_placa');
            $equipo = Equipo::where('placa', $placa)->first();
            if($equipo != null) {
                $checklistvehicular->equipo_id= $equipo->id;
            }else {
                $vehiculo = Vehiculo::where('placa', $placa)->first();
                $checklistvehicular->vehiculo_id= $vehiculo->id;
            }

            $checklistvehicular->k_inicial = $request->input('k_inicial');
            $checklistvehicular->k_final = $request->input('k_final');
            $checklistvehicular->lider_area = mb_strtoupper($request->input('lider_area'), 'utf-8');
            $checklistvehicular->conductor_id= $request->input('conductor_id');
            $checklistvehicular->observaciones = $request->input('observaciones');
            $checklistvehicular->sistema_electrico = json_decode($request->input('sistema_electrico'));
            $checklistvehicular->sistema_mecanico = json_decode($request->input('sistema_mecanico'));
            $checklistvehicular->accesorios = json_decode($request->input('accesorios'));
            $checklistvehicular->documentos = json_decode($request->input('documentos'));

            
            $checklistvehicular->save();




        });
        return is_null($error) ? "OK" : $error;
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'checklistvehicular');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $checklistvehicular = Checklistvehicular::find($id);
        
        if($checklistvehicular->equipo_id != '') {
            $equipo = Equipo::find($checklistvehicular->equipo_id);
            $unidad_placa = $equipo->placa;
            $unidad_descripcion = $equipo->descripcion;
        } else {
            $vehiculo = Vehiculo::find($checklistvehicular->vehiculo_id);
            $unidad_placa = $vehiculo->placa;
            $unidad_descripcion = $vehiculo->descripcion;
        }

        $entidad  = 'Checklistvehicular';
        $formData = array('mantcorrprev.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $arrConductores      = Conductor::getAll();
        $cboConductores = array('' => 'Seleccione');
        foreach($arrConductores as $k=>$v){
            $cboConductores += array($v->id => $v->nombres . $v->apellidos);
        }

        $sistema_electrico = $checklistvehicular->sistema_electrico;
        $sistema_mecanico = $checklistvehicular->sistema_mecanico;
        $accesorios = $checklistvehicular->accesorios;
        $documentos = $checklistvehicular->documentos;

        // return implode($cboConductores);

        return view($this->folderview.'.mant_checklistvehicular')->with(compact('checklistvehicular', 'formData', 'entidad', 'boton', 'unidad_placa', 'unidad_descripcion', 'cboConductores', 'sistema_electrico', 'sistema_mecanico', 'accesorios', 'documentos', 'listar'));
    }

    public function existeUnidad(Request $request) {
        $res = Equipo::withTrashed()->where('placa', $request->placa)->first();
        if($res != null) return ['unidad' => $res];
        return [ 'unidad' => Vehiculo::withTrashed()->where('placa', $request->placa)->first()];
    }
}
