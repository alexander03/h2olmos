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
use App\Concesionaria;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Mpdf\Mpdf;
use App\Contratista;
use App\Vehiculodocument;


// INICIO DE MODIFICACION
use App\Rules\RulePlacaExist;
// FIN DE MODIFICACION


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
        $fecha_registro_inicial = $request->input('fecha_registro_inicial');
        $fecha_registro_final   = $request->input('fecha_registro_final');
        $resultado        = Checklistvehicular::getFilter($fecha_registro_inicial, $fecha_registro_final);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'F. Registro', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Equipo/Vehiculo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'K. Inicial', 'numero' => '1');
        $cabecera[]       = array('valor' => 'K. Final', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Lider del area', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Conductor', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Opciones', 'numero' => '2');
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
        $conductor = [
            'id' => null,
            'dni' => '',
            'nombres' => ''
        ];
        // $arrConductores = Conductor::getAll();
        // $cboConductores = array('' => 'Seleccione');
        // foreach($arrConductores as $k=>$v){
        //     $cboConductores += array($v->id => $v->nombres . $v->apellidos);
        // }
        return view($this->folderview.'.mant_checklistvehicular')->with(compact('checklistvehicular', 'formData', 'entidad', 'unidad_placa', 'unidad_descripcion', 'conductor', 'boton', 'listar'));
    }

    public function store(Request $request) {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');

        $today = \Carbon\Carbon::now('America/Lima')->toDateString();
        $min = $request->all()['k_inicial'];

        $reglas     = array(
            'fecha_registro' => 'required|date|after_or_equal:' . $today,
            'unidad_placa' => (new RulePlacaExist()),
            'k_inicial' => 'required|numeric|min:0',
            'k_final' => 'required|numeric|min:' . ($min + 1),
            'lider_area' => 'required|max:300',
            'conductor_id' => 'exists:App\Conductor,id'
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
            'conductor_id.exists' => 'Debe ingresar un conductor'
        );
        
        $validacion = Validator::make($request->all(), $reglas, $mensajes);

        if ( $validacion->fails() ) {
            return $validacion->messages()->toJson();
        }
        
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

                //ACTUALIZO K. RECORRIDO DEL VEHICULO
                $vehiculo->kilometraje_rec =  $request->input('k_final') - $vehiculo->kilometraje_act;
                $vehiculo->save();
            }

            $checklistvehicular->k_inicial = $request->input('k_inicial');
            $checklistvehicular->k_final = $request->input('k_final');
            $checklistvehicular->lider_area = mb_strtoupper($request->input('lider_area'), 'utf-8');
            $checklistvehicular->conductor_id= $request->input('conductor_id');
            $checklistvehicular->observaciones = $request->input('observaciones');
            $checklistvehicular->incidentes = $request->input('incidentes');
            $checklistvehicular->sistema_electrico = json_decode($request->input('sistema_electrico'));
            $checklistvehicular->sistema_mecanico = json_decode($request->input('sistema_mecanico'));
            $checklistvehicular->accesorios = json_decode($request->input('accesorios'));
            $checklistvehicular->documentos = json_decode($request->input('documentos'));
            $checklistvehicular->concesionaria_id = Concesionaria::getConcesionariaActual()->id;
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
            $unidad_descripcion = $vehiculo->modelo;

            //ACTUALIZO H. ACTUAL DEL VEHICULO
            $vehiculo->kilometraje_rec =  $request->input('k_final') - $vehiculo->kilometraje_act;
            $vehiculo->save();
        }

        $entidad  = 'Checklistvehicular';
        $formData = array('mantcorrprev.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $conductor = Conductor::select('id', 'dni', DB::raw("CONCAT(nombres, ' ', apellidos) AS nombres"))->where('id', '=', $checklistvehicular->conductor_id)->first();
        // $arrConductores      = Conductor::getAll();
        // $cboConductores = array('' => 'Seleccione');
        // foreach($arrConductores as $k=>$v){
        //     $cboConductores += array($v->id => $v->nombres . $v->apellidos);
        // }

        $sistema_electrico = $checklistvehicular->sistema_electrico;
        $sistema_mecanico = $checklistvehicular->sistema_mecanico;
        $accesorios = $checklistvehicular->accesorios;
        $documentos = $checklistvehicular->documentos;

        return view($this->folderview.'.mant_checklistvehicular')
            ->with(compact('checklistvehicular', 'formData', 'entidad', 'boton', 'unidad_placa', 'unidad_descripcion', 'conductor', 'sistema_electrico', 'sistema_mecanico', 'accesorios', 'documentos', 'listar'));
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'Checklistvehicular');
        if ($existe !== true) {
            return $existe;
        }
        
        $today = \Carbon\Carbon::now('America/Lima')->toDateString();
        $min = $request->all()['k_inicial'];

        $reglas     = array(
            'fecha_registro' => 'required|date|after_or_equal:' . $today,
            'unidad_placa' => (new RulePlacaExist()),
            'k_inicial' => 'required|numeric|min:0',
            'k_final' => 'required|numeric|min:' . $min,
            'lider_area' => 'required|max:300',
            'conductor_id' => 'exists:App\Conductor,id'
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
            'conductor_id.exists' => 'Debe ingresar un conductor'
        );
        
        $validacion = Validator::make($request->all(), $reglas, $mensajes);

        if ( $validacion->fails() ) {
            return $validacion->messages()->toJson();
        }
        
        $error = DB::transaction(function() use($request, $id){
            $checklistvehicular = Checklistvehicular::find($id);
            $checklistvehicular->fecha_registro= $request->input('fecha_registro');

            $placa = $request->input('unidad_placa');

            $equipo = Equipo::where('placa', $placa)->first();
            $checklistvehicular->equipo_id = $equipo!=null ? $equipo->id : null;

            $vehiculo = Vehiculo::where('placa', $placa)->first();
            $checklistvehicular->vehiculo_id = $vehiculo!=null ? $vehiculo->id : null;

            $checklistvehicular->k_inicial = $request->input('k_inicial');
            $checklistvehicular->k_final = $request->input('k_final');
            $checklistvehicular->lider_area = mb_strtoupper($request->input('lider_area'), 'utf-8');
            $checklistvehicular->conductor_id= $request->input('conductor_id');
            $checklistvehicular->observaciones = $request->input('observaciones');
            $checklistvehicular->incidentes = $request->input('incidentes');

            if($request->input('sistema_electrico') != null) $checklistvehicular->sistema_electrico = json_decode($request->input('sistema_electrico'));
            if($request->input('sistema_mecanico') != null) $checklistvehicular->sistema_mecanico = json_decode($request->input('sistema_mecanico'));
            if($request->input('accesorios') != null) $checklistvehicular->accesorios = json_decode($request->input('accesorios'));
            if($request->input('documentos') != null) $checklistvehicular->documentos = json_decode($request->input('documentos'));
            
            $checklistvehicular->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function searchUnidad(Request $request) {
        $filter = $request->filter;
        $concesionaria_id = Concesionaria::getConcesionariaActual()->id;

        $equipos = Equipo::select('placa', 'descripcion')
                        ->where('concesionaria_id', '=', $concesionaria_id)
                        ->where(function ($query) use ($filter) {
                            $query->where('placa', 'like', '%'.$filter.'%')
                                ->orWhere('descripcion', 'like', '%'.$filter.'%');
                        })->withTrashed()->get();

        $vehiculos = Vehiculo::select('placa', 'modelo AS descripcion')
                            ->where('concesionaria_id', '=', $concesionaria_id)
                            ->where(function ($query) use ($filter) {
                                $query->where('placa', 'like', '%'.$filter.'%')
                                    ->orWhere('modelo', 'like', '%'.$filter.'%');
                            })->withTrashed()->get();
        
        return [
            'equipos' => $equipos,
            'vehiculos' => $vehiculos
        ];
    }

    public function generatePDF(Request $request) {
        if ( $request->checklistvehicular_id == null || !is_numeric($request->checklistvehicular_id) ) return;

        $namefile = 'Check List Vehicular - '.time().'.pdf';  
        
        $checklistvehicular = Checklistvehicular::leftJoin('equipo', 'equipo.id', '=', 'checklistvehicular.equipo_id')
                                                ->leftJoin('vehiculo', 'vehiculo.id', 'checklistvehicular.vehiculo_id')
                                                ->join('conductor', 'conductor.id', 'checklistvehicular.conductor_id')
                                                ->leftJoin('marca AS marca_equipo', 'marca_equipo.id', 'equipo.marca_id')
                                                ->leftJoin('marca AS marca_vehiculo', 'marca_vehiculo.id', 'vehiculo.marca_id')
                                                ->leftJoin('contratista AS contratista_vehiculo', 'contratista_vehiculo.id', 'vehiculo.contratista_id')
                                                ->leftJoin('contratista AS contratista_equipo', 'contratista_equipo.id', 'equipo.contratista_id')
                                                ->select('checklistvehicular.fecha_registro', 'checklistvehicular.k_inicial', 'checklistvehicular.k_final', 'checklistvehicular.lider_area', 'checklistvehicular.observaciones', 'checklistvehicular.incidentes', 
                                                        'checklistvehicular.sistema_electrico', 'checklistvehicular.sistema_mecanico', 'checklistvehicular.accesorios', 'checklistvehicular.documentos',
                                                        'equipo.placa as equipo_placa', 'marca_equipo.descripcion AS equipo_marca', 'equipo.modelo AS equipo_modelo', 'contratista_equipo.razonsocial AS equipo_contratista', 'contratista_equipo.id AS equipo_contratista_id', 'equipo.descripcion as equipo_descripcion',
                                                        'vehiculo.placa AS vehiculo_placa', 'marca_vehiculo.descripcion AS vehiculo_marca', 'vehiculo.modelo AS vehiculo_modelo', 'contratista_vehiculo.razonsocial AS vehiculo_contratista', 'contratista_vehiculo.id AS vehiculo_contratista_id', 'vehiculo.color AS vehiculo_color', 'vehiculo.motor AS vehiculo_combustible', 'vehiculo.id AS vehiculo_id',
                                                        'conductor.nombres as conductor_nombres', 'conductor.apellidos as conductor_apellidos', 'conductor.licencia')
                                                // ->select('checklistvehicular.fecha_registro')
                                                ->where('checklistvehicular.id', '=', $request->checklistvehicular_id)->withTrashed()->first();

        if ( $checklistvehicular == NULL ) return redirect('/home');

        $data = [];

        $is_v = $checklistvehicular->vehiculo_placa != NULL ? true : false;
        
        // datos que puede ser de vehiculo o equipo
        $data['placa'] = $is_v ? $checklistvehicular->vehiculo_placa : $checklistvehicular->equipo_placa;
        $data['marca'] = $is_v ? $checklistvehicular->vehiculo_marca : $checklistvehicular->equipo_marca;
        $data['modelo'] = $is_v ? $checklistvehicular->vehiculo_modelo : $checklistvehicular->equipo_modelo;
        $data['contratista'] = $is_v ? $checklistvehicular->vehiculo_contratista : $checklistvehicular->equipo_contratista;
        $contratista = $is_v ? $checklistvehicular->vehiculo_contratista_id : $checklistvehicular->equipo_contratista_id;
        $contratista = Contratista::join('concesionaria', 'concesionaria.ruc', '=', 'contratista.ruc')
                                ->select('contratista.ruc')->where('contratista.id', '=', $contratista)->first();
        $data['directo'] = is_null($contratista) ? 0 : 1;
        
        // datos que es de vehiculo
        $data['ua'] = $checklistvehicular->vehiculo_ua;
        $data['color'] = $checklistvehicular->vehiculo_color;
        $data['combustible'] = $checklistvehicular->vehiculo_combustible;
        $data['fecha_soat'] = Vehiculodocument::select('fecha')
                                            ->where('vehiculo_id', '=', $checklistvehicular->vehiculo_id)
                                            ->where('tipo', '=', 'SOAT')->first()['fecha'];
        
        // datos que es de equipo
        $data['descripcion'] = $checklistvehicular->equipo_descripcion;

        // datos del checklistvehicular
        $data['fecha_registro'] = $checklistvehicular->fecha_registro;
        $data['k_inicial'] = $checklistvehicular->k_inicial;
        $data['k_final'] = $checklistvehicular->k_final;
        $data['lider_area'] = $checklistvehicular->lider_area;
        $data['observaciones'] = strtoupper($checklistvehicular->observaciones);
        $data['incidentes'] = strtoupper($checklistvehicular->incidentes);

        // datos del conductor
        $data['conductor'] = $checklistvehicular->conductor_nombres . ' ' . $checklistvehicular->conductor_apellidos;
        $data['licencia'] = $checklistvehicular->licencia;
        
        $limite = intval((count($checklistvehicular->sistema_electrico) + count($checklistvehicular->sistema_mecanico) + count($checklistvehicular->accesorios) + count($checklistvehicular->documentos) + 4)/2);
        
        $steps = [ 
            [
                'title' => 'SISTEMA ELECTRICO',
                'values' => $checklistvehicular->sistema_electrico
            ], [
                'title' => 'SISTEMA MECANICO',
                'values' => $checklistvehicular->sistema_mecanico
            ], [
                'title' => 'ACCESORIOS',
                'values' => $checklistvehicular->accesorios
            ], [
                'title' => 'DOCUMENTOS',
                'values' => $checklistvehicular->documentos
            ]
        ];

        $lista = [];
        $row = -1;  // para saber en que fila esta
        foreach ($steps as $step) { // para controlar la etapa en la que se encuentra
            $row++; //aumento de uno en uno
            $lista[] = [
                'title' => true,
                'caption' => $step['title'],
                'value_yes' => 'SI',
                'value_not' => 'NO'
            ];
            foreach ($step['values'] as $param) {
                $row++;
                if ( $row == $limite ) {
                    $lista[] = [
                        'title' => true,
                        'caption' => $step['title'],
                        'value_yes' => 'SI',
                        'value_not' => 'NO'
                    ];
                }
                $lista[] = [
                    'title' => false,
                    'caption' => mb_strtoupper($param['titulo'], 'UTF-8'),
                    'value_yes' => ( !is_null($param['estado']) && $param['estado'] )? 'X': '',
                    'value_not' => ( !is_null($param['estado']) && !$param['estado'] )? 'X': ''
                ];
                
            }
        }
        
        $data['lista'] = $lista;
        $data['limite'] = $limite;
        $data['namefile'] = $namefile;
        // dd($data);
        $html = view('app.mantcorrprev.pdf.template_individual', $data)->render();

        $mpdf = new Mpdf();
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);

        $mpdf->Output($namefile, "I");
    }


    // INICIO DE MODIFICACION
    public function searchConductor(Request $request){
        $filter = $request->filter;
        $concesionaria_id = Concesionaria::getConcesionariaActual()->id;

        $list = Conductor::rightJoin('conductorconcesionaria AS cc', 'cc.conductor_id', '=', 'conductor.id')
                        ->select('conductor.id', 'dni', DB::raw("CONCAT(nombres, ' ', apellidos) AS nombres"))
                        ->where(function ($subquery) use ($filter) {
                            $subquery->where('dni', 'like', '%'.$filter.'%')
                                    ->orWhere(DB::raw("CONCAT(nombres, ' ', apellidos)"), 'like', '%'.$filter.'%');
                        })
                        ->where('cc.concesionaria_id', '=', $concesionaria_id)
                        ->orderBy('dni', 'desc')->get();

        return [
            'list' => $list
        ];
    }
    // FIN DE MODIFICACION


}