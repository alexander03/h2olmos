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

        $today = \Carbon\Carbon::now('America/Lima')->toDateString();
        $min = $request->all()['k_inicial'];

        $reglas     = array(
            'fecha_registro' => 'required|date|after_or_equal:' . $today,
            'unidad_placa' => 'required|regex:@^([\d\w]+)(-\1)?$@i',
            'k_inicial' => 'required|integer|min:0',
            'k_final' => 'required|integer|min:' . $min,
            'lider_area' => 'required|max:300',
            'conductor_id' => 'required|integer'
        );

        $mensajes = array(
            'fecha_registro.required' => 'Debe seleccionar una fecha',
            'fecha_registro.date' => 'La fecha tiene formato incorrecto',
            'fecha_registro.after_or_equal' => 'La fecha ingresada es incorrecta',
            'unidad_placa.required' => 'Debe ingresar una unidad placa',
            'unidad_placa.regex' => 'La unidad placa ingresada es incorrecta',
            'k_inicial.required' => 'Debe ingresar un kilometraje inicial',
            'k_inicial.min' => 'El kilometraje inicial ingresado es incorrecto',
            'k_final.required' => 'Debe ingresar un kilometraje final',
            'k_final.min' => 'El kilometraje final ingresado es incorrecto',
            'lider_area.required' => 'Debe ingresar un lider de area',
            'lider_area.max' => 'El nombre del lider de area debe tener max. 300 caracteres',
            'conductor_id.required' => 'Debe seleccionar una conductor'
        );
        
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

        return view($this->folderview.'.mant_checklistvehicular')->with(compact('checklistvehicular', 'formData', 'entidad', 'boton', 'unidad_placa', 'unidad_descripcion', 'cboConductores', 'sistema_electrico', 'sistema_mecanico', 'accesorios', 'documentos', 'listar'));
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'Checklistvehicular');
        if ($existe !== true) {
            return $existe;
        }
        // $reglas = array(
        //     'unidad_id' => 'required',
        //     'codigo' => ['required', 'digits:7',Rule::unique('repuesto')->ignore($id)],
        //     'descripcion' => ['required','max:100',Rule::unique('repuesto')->ignore($id)],
        // );
        // $mensajes = array(
        //     'codigo.required' => 'Debe ingresar un código',
        //     'codigo.digits' => 'El código debe tener 7 cifras',
        //     'codigo.unique' => 'El código ya existe',
        //     'descripcion.required' => 'Debe ingresar una descripcion',
        //     'descripcion.max' => 'La descripcion debe tener max. 100 caracteres',
        //     'descripcion.unique' => 'La descripción ya existe',
        //     'unidad_id.required' => 'Debe seleccionar una unidad'
        // );
        // $validacion = Validator::make($request->all(), $reglas, $mensajes);
        // if ($validacion->fails()) {
        //     return $validacion->messages()->toJson();
        // }
        $error = DB::transaction(function() use($request, $id){
            $checklistvehicular = Checklistvehicular::find($id);
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

            if($request->input('sistema_electrico') != null) $checklistvehicular->sistema_electrico = json_decode($request->input('sistema_electrico'));
            if($request->input('sistema_mecanico') != null) $checklistvehicular->sistema_mecanico = json_decode($request->input('sistema_mecanico'));
            if($request->input('accesorios') != null) $checklistvehicular->accesorios = json_decode($request->input('accesorios'));
            if($request->input('documentos') != null) $checklistvehicular->documentos = json_decode($request->input('documentos'));
            
            $checklistvehicular->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function existeUnidad(Request $request) {
        $res = Equipo::withTrashed()->where('placa', $request->placa)->first();
        if($res != null) return ['unidad' => $res];
        return [ 'unidad' => Vehiculo::withTrashed()->where('placa', $request->placa)->first()];
    }
}
