<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Trabajo;
use App\Unidad;
use App\Equipo;
use App\Vehiculo;
use App\RegManVeh;
use App\Ua;
use App\Rules\SearchUaPadre;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Concesionaria;
use App\DescripcionRegManVeh;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;
use App\Events\UserHasEdited;
use App\Events\UserHasCreatedOrDeleted;

class RegManVehController extends Controller
{
    protected $folderview      = 'app.regmanveh';
    protected $tituloAdmin     = 'Registro de Mantenimiento Vehicular';
    protected $tituloRegistrar = 'Registro de Mantenimiento Vehicular';
    protected $tituloModificar = 'Modificar Mantenimiento Vehicular';
    protected $tituloEliminar  = 'Eliminar Mantenimiento Vehicular';
    protected $tituloActivar  = 'Activar mantenimiento';
    protected $rutas           = array(
       // 'create' => 'regmanveh.createregmanveh',
        'createtrabajo' => 'regmanveh.createtrabajo',
        'buscarporua' => 'regmanveh.buscarporua',
        'edit'   => 'regmanveh.edit', 
        'delete' => 'regmanveh.eliminar',
        'activar' => 'regmanveh.activar',
        'search' => 'regmanveh.buscar',
        'store' => 'regmanveh.store',
        'index'  => 'regmanveh.index',
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'RegManVeh';
        $filter           = Libreria::getParam($request->input('filter'));
		$ConcesionariaActual = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
        ->join('users','users.id','=','userconcesionaria.user_id')
        ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
       	->select('concesionaria.id','concesionaria.razonsocial')->get();
       	$idConcAct=$ConcesionariaActual[0]->id;

		$fechainicio= $request->input('fechainicio');
        $fechafin= $request->input('fechafin');

        $resultado= RegManVeh::where('regmanveh.concesionaria_id',$idConcAct)
        ->where(function($q) use ($fechainicio, $fechafin) {
                if ( $fechainicio !== null ) $q->where('regmanveh.fechasalida','>=', $fechainicio);
                if ( $fechafin !== null ) $q->where('regmanveh.fechaentrada','<=', $fechafin);
            })
        ->where(function($q) use ($filter){
        $q->where('regmanveh.cliente', 'like', '%'.$filter.'%')
          ->orWhere('regmanveh.ua_id', 'like', '%'.$filter.'%')
          ->orWhere('regmanveh.ordencompra', 'like', '%'.$filter.'%')
          ->orWhere('regmanveh.telefono', 'like', '%'.$filter.'%')
          ->orWhere('regmanveh.fechaentrada', 'like', '%'.$filter.'%')
          ->orWhere('regmanveh.fechasalida', 'like', '%'.$filter.'%');
     	});


        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cliente', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DOCMAT', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Placa', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Km Inicial', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Km Mant.', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Km Final', 'numero' => '1');
        $cabecera[]       = array('valor' => 'FechaEntrada', 'numero' => '1');
        $cabecera[]       = array('valor' => 'FechaSalida', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Telefono', 'numero' => '1');
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
        $entidad          = 'RegManVeh';
        $title            = $this->tituloAdmin;
        $tituloRegistrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        
        return view($this->folderview.'.admin')->with(compact('entidad', 'title','tituloRegistrar', 'ruta'));
    }


    public function createtrabajo(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'RegManVeh';
        $regmanveh = null;
        $arrConcesionarias = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
        ->join('users','users.id','=','userconcesionaria.user_id')
        ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
       	->select('concesionaria.id','concesionaria.razonsocial')->get();
        $oObservaciones=array(new DescripcionRegManVeh());
        $oObservaciones[0]->id=-1 ; 
        $uades="";
        $placa="";
        $vehiculo_id="";
        $idconc=$arrConcesionarias[0]->id;
        $oConcesionaria=$arrConcesionarias[0]->razonsocial;
        //$oTipos=array('' => 'Seleccione Tipo');
        $oTipos=array('' => 'Seleccione Tipo');
        $oTipos=array('1' => 'Preventivo');
        $oTipos+=array('2' => 'Correctivo');
        $formData = array('regmanveh.createregmanveh');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant2')->with(compact('regmanveh', 'oTipos','formData', 'entidad','oConcesionaria','idconc','uades','placa','vehiculo_id','oObservaciones', 'boton', 'listar'));
    }

    public function buscarporua(Request $request){
        $resultado = Ua::where('codigo', '=',$request->get("ua"))->get();
        
        if (count($resultado)>0) {
            $eq = Equipo::where('ua_id', '=',$resultado[0]->id)->get();

            if (count($eq)>0) {
                return json_encode(array('gg'=>"UA correcta: ".$eq[0]['descripcion']));
            }else{
            return json_encode(array('gg'=>'LA UA NO TIENE EQUIPO'));}
        }else{
        return json_encode(array('gg'=>'NO EXISTE UA'));}
    }

    public function createchecklistvehicular(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'RegManVeh';
        $mantenimiento = null;
        $formData = array('mantenimientos.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        $arrUnidades = Unidad::getAll();
        $cboUnidades = array('' => 'Seleccione');
        foreach($arrUnidades as $k=>$v){
            $cboUnidades += array($v->id=>$v->descripcion);
        }
        return view($this->folderview.'.mant_checklistvehicular')->with(compact('mantenimiento', 'formData', 'entidad', 'boton', 'cboUnidades', 'listar'));
    }

    public function store(Request $request){

        $reglas = [
            'concesionaria_id' => 'required',
            'cliente' => 'required|max:250',
            'ordencompra' => 'required|max:250',
            'vehiculo_id' => 'required',
            'fechaentrada' => 'required',
            'fechasalida' => 'required',
            'kmman' => 'required',
            'kminicial' => 'required',
            'kmfinal' => 'required',
            'tipomantenimiento' => 'required',
            'telefono' => 'required',
            'cantidad.*' => 'required',
            'monto.*' => 'required',
            'cuantasdescripciones'=>'required'
        ];

        $mensajes = [
            'cliente.required' => 'Cliente Campo Vacío',
            'ordencompra.required' => 'DOCMAT Campo Vacío',
            'cliente.max' => 'Nombre de Cliente muy extenso, máximo 250 caracteres',
            'ordencompra.max' => 'DOCMAT muy extensa, máximo 250 caracteres',
            'vehiculo_id.required' => 'Seleccione un vehículo válido',
            'fechaentrada.required' => 'Fecha Entrada Campo Vacío',
            'fechasalida.required' => 'Fecha Salida Campo Vacío',
            'kmman.required' => 'Km de Mantenimiento Campo Vacío',
            'kminicial.required' => 'Km Inicial Campo Vacío',
            'kmfinal.required' => 'Km Final Campo Vacío',
            'tipomantenimiento.required' => 'Tipo de Mantenimiento No Seleccionado',
            'telefono.required' => 'Teléfono Campo Vacío',
            'cantidad.*.required' => 'Ingrese Cantidad todas las Observaciones',
            'monto.*.required' => 'Ingrese Monto todas las Observaciones',
            'cuantasdescripciones.required' => 'Ingrese al menos una Observación'
        ];
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $listar     = Libreria::getParam($request->input('listar'), 'NO');

        $idn=DB::select("SHOW TABLE STATUS LIKE 'regmanveh'");
        $next_id=$idn[0]->Auto_increment;

        
        $error = DB::transaction(function() use($request,$next_id){
            $regmanv = new RegManVeh();
            $regmanv -> id =$next_id;
            $regmanv -> cliente  = $request -> input('cliente');
            $regmanv -> ordencompra  = $request -> input('ordencompra');
            $regmanv -> concesionaria_id  = $request -> input('concesionaria_id');
            $regmanv -> ua_id = $request -> input('vehiculo_id');
            $regmanv -> kminicial = $request -> input('kminicial');
            $regmanv -> kmman = $request -> input('kmman');
            $regmanv -> kmfinal = $request -> input('kmfinal');
            $regmanv -> fechaentrada = $request -> input('fechaentrada');
            $regmanv -> fechasalida = $request -> input('fechasalida');
            $regmanv -> fecharegistro = now();
            $regmanv -> tipomantenimiento = $request -> input('tipomantenimiento');
            $regmanv -> telefono = $request -> input('telefono');
            $regmanv -> save();

            event( new UserHasCreatedOrDeleted($regmanv->id,'regmanv', auth()->user()->id,'crear'));
        });

        $vehiculo=Vehiculo::find($request -> input('vehiculo_id'));
        $vehiculo->kilometraje_rec=$request -> input('kmfinal')-$vehiculo->kilometraje_act;
        $vehiculo->save();


        $cantidades=$request->cantidad;
        $mantenimientosid=$request->trabajoid;
        $montos=$request->monto;
        for ($i = 0; $i < count($cantidades); $i++) {
           $error = DB::transaction(function() use($i,$request,$next_id,$cantidades,$mantenimientosid,$montos){
            $descripcionregmanv = new DescripcionRegManVeh();
            $descripcionregmanv -> regmanveh_id =$next_id;
            $descripcionregmanv -> cantidad  = $cantidades[$i];
            $descripcionregmanv -> trabajo_id  = intval($mantenimientosid[$i]);
            $descripcionregmanv -> monto = $montos[$i];;
            $descripcionregmanv -> save();
        }); 
        }

        


        return is_null($error) ? "OK" : $error;
    }


    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'regmanveh');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje = true;
        $modelo   = RegManVeh::find($id);
        $entidad  = 'RegManVeh';
        $formData = array('route' => array('regmanveh.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'regmanveh');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $regmanveh = RegManVeh::find($id);

            event( new UserHasCreatedOrDeleted($regmanveh->id,'regmanv', auth()->user()->id,'eliminar'));
            $regmanveh->delete();
        });
        return is_null($error) ? "OK" : $error;
    }



    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'regmanveh');
        if ($existe !== true) {
            return $existe;
        }

        $arrConcesionarias = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
        ->join('users','users.id','=','userconcesionaria.user_id')
        ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
       	->select('concesionaria.id','concesionaria.razonsocial')->get();

        $idconc=$arrConcesionarias[0]->id;
        $oConcesionaria=$arrConcesionarias[0]->razonsocial;
        

        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $regmanveh = RegManVeh::find($id);
        $oObservaciones=DescripcionRegManVeh::where('regmanveh_id','=',$id)
            ->join('trabajo', 'descripcionregmanveh.trabajo_id', '=', 'trabajo.id')
            ->select('descripcionregmanveh.id as id','descripcionregmanveh.monto as monto','descripcionregmanveh.cantidad as cantidad','trabajo.id as trabajo_id','trabajo.descripcion as descripcion')->get();

        $oua = Vehiculo::where('id','=',$regmanveh->ua_id)->get();
        $placa= $oua[0]->placa;
        $oua2 = Ua::where('id','=',$oua[0]->ua_id)->get();
        $uades= $oua2[0]->codigo;
        $uades=$uades;
        $vehiculo_id=$regmanveh->ua_id;
        
        $entidad  = 'RegManVeh';
        $formData = array('regmanveh.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant2')->with(compact('regmanveh','oConcesionaria','idconc','oObservaciones', 'placa','uades','vehiculo_id', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function update(Request $request, $id)
    {

        $reglas = [
            'concesionaria_id' => 'required',
            'cliente' => 'required|max:250',
            'ordencompra' => 'required|max:250',
            'vehiculo_id' => 'required',
            'fechaentrada' => 'required',
            'fechasalida' => 'required',
            'kmman' => 'required',
            'kminicial' => 'required',
            'kmfinal' => 'required',
            'tipomantenimiento' => 'required',
            'telefono' => 'required',
            'cantidad.*' => 'required',
            'monto.*' => 'required',
            'cuantasdescripciones'=>'required'
        ];

        $mensajes = [
            'cliente.required' => 'Cliente Campo Vacío',
            'ordencompra.required' => 'DOCMAT Campo Vacío',
            'cliente.max' => 'Nombre de Cliente muy extenso, máximo 250 caracteres',
            'ordencompra.max' => 'DOCMAT muy extensa, máximo 250 caracteres',
            'vehiculo_id.required' => 'Seleccione un vehículo válido',
            'fechaentrada.required' => 'Fecha Entrada Campo Vacío',
            'fechasalida.required' => 'Fecha Salida Campo Vacío',
            'kmman.required' => 'Km de Mantenimiento Campo Vacío',
            'kminicial.required' => 'Km Inicial Campo Vacío',
            'kmfinal.required' => 'Km Final Campo Vacío',
            'tipomantenimiento.required' => 'Tipo de Mantenimiento No Seleccionado',
            'telefono.required' => 'Campo Vacío',
            'cantidad.*.required' => 'Ingrese Cantidad todas las Observaciones',
            'monto.*.required' => 'Ingrese Monto todas las Observaciones',
            'cuantasdescripciones.required' => 'Ingrese al menos una Observación'
        ];
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }




        $existe = Libreria::verificarExistencia($id, 'regmanveh');
        if ($existe !== true) {
            return $existe;
        }
      	$reglas     = [
            
        ];
        $mensajes = [
            
		];
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 



        $error = DB::transaction(function() use($request, $id){
            $regmanv = RegManVeh::find($id);

            $regmanvOrg = $regmanv;

            $regmanv -> cliente  = $request -> input('cliente');
            $regmanv -> ordencompra  = $request -> input('ordencompra');
            $regmanv -> concesionaria_id  = $request -> input('concesionaria_id');
            $regmanv -> ua_id = $request -> input('vehiculo_id');
            $regmanv -> kmman = $request -> input('kmman');
            $regmanv -> kminicial = $request -> input('kminicial');
            $regmanv -> kmfinal = $request -> input('kmfinal');
            $regmanv -> fechaentrada = $request -> input('fechaentrada');
            $regmanv -> fechasalida = $request -> input('fechasalida');
            $regmanv -> tipomantenimiento = $request -> input('tipomantenimiento');
            $regmanv -> telefono = $request -> input('telefono');
            $regmanv -> save();

            event( new UserHasEdited($regmanvOrg,$regmanv,'propietario', auth()->user()->id));
        });


        $vehiculo=Vehiculo::find($request -> input('vehiculo_id'));
        $vehiculo->kilometraje_rec=$request -> input('kmfinal')-$vehiculo->kilometraje_act;
        $vehiculo->save();


        $ids=$request->idobservacion;
        $montos=$request->monto;
        $cantidades=$request->cantidad;
        $mantenimientosid=$request->trabajoid;
        for ($i = 0; $i < count($cantidades); $i++) {
           $error = DB::transaction(function() use($id,$i,$ids,$request,$cantidades,$mantenimientosid,$montos){
            $descripcionregmanv = new DescripcionRegManVeh();
            if($ids[$i]>=0){$descripcionregmanv = DescripcionRegManVeh::find($ids[$i]);}
            $descripcionregmanv -> regmanveh_id =$id;
            $descripcionregmanv -> cantidad  = $cantidades[$i];
            $descripcionregmanv -> trabajo_id  = $mantenimientosid[$i];
            $descripcionregmanv -> monto = $montos[$i];;
            $descripcionregmanv -> save();
        }); 
        }

        $idseliminados=$request->idseliminados;

        if($idseliminados!=null){
            foreach($idseliminados as $k=>$idd){
                $error = DB::transaction(function() use($idd){
                    if($idd>0){
                $regmanveh = DescripcionRegManVeh::find($idd);
                $regmanveh->delete();}
                }); 
            }
        }   






        return is_null($error) ? "OK" : $error;
    }


public function searchAutocompleteTrabajo($query){

        $consulta = "select  id, descripcion, descripcion as 'search'
            from trabajo 
            where trabajo.deleted_at IS NULL AND
            (descripcion LIKE '%".$query."%')";
        $res = DB::select($consulta);
        
        return response() -> json($res);
    }

	public function generatePDF(Request $request) {
	    $id=$request->id;
        if ( $request->id == null || !is_numeric($request->id) ) return;

        $namefile = 'RegistroDeMantenimientoVehicular - '.time().'.pdf'; 
        
        $ConcesionariaActual = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
        ->join('users','users.id','=','userconcesionaria.user_id')
        ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
        ->select('concesionaria.id','concesionaria.razonsocial')->get();
        $ConcAct=$ConcesionariaActual[0]->razonsocial;
        $regmanveh = RegManVeh::find($id);
        $oObservaciones=DescripcionRegManVeh::where('regmanveh_id','=',$id)
            ->join('trabajo', 'descripcionregmanveh.trabajo_id', '=', 'trabajo.id')
            ->select('descripcionregmanveh.id as id','descripcionregmanveh.monto as monto','descripcionregmanveh.cantidad as cantidad','trabajo.id as trabajo_id','trabajo.descripcion as descripcion')->get();
        
        $data=[];
        $data['concesionaria'] = $ConcAct;
        $data['cliente'] = $regmanveh->cliente;
        $data['ordencompra'] = $regmanveh->ordencompra;
        $data['ua_id'] = $regmanveh->ua_id;
        $data['tipomantenimiento']=$regmanveh->tipomantenimiento==1?'PREVENTIVO':'CORRECTIVO';
        $data['kmman'] = $regmanveh->kmman;
        $data['kminicial'] = $regmanveh->kminicial;
        $data['kmfinal'] = $regmanveh->kmfinal;
        $data['telefono'] = $regmanveh->telefono;
        $data['fechaentrada'] = $regmanveh->fechaentrada;
        $data['fechasalida'] = $regmanveh->fechasalida;
        $data['fecharegistro'] = $regmanveh->fecharegistro;
        $data['regmanveh'] = $regmanveh;
        $data['observaciones'] = $oObservaciones;
        $data['namefile'] = $namefile;
        $posiblevehiculo=Vehiculo::join('ua','vehiculo.ua_id','=','ua.id')
        ->join('marca','vehiculo.marca_id','=','marca.id')->where('vehiculo.id','=',$regmanveh->ua_id)
        ->select('vehiculo.placa as placa','vehiculo.modelo as modelo','marca.descripcion as marca','ua.codigo as uacodigo')->get();

        $data['unidad'] = '--';
        $data['placa'] = $posiblevehiculo[0]->placa;
        $data['modelo'] = $posiblevehiculo[0]->modelo;
        $data['marca'] = $posiblevehiculo[0]->marca;
        $data['uacodigo'] = $posiblevehiculo[0]->uacodigo;

/*
        $posibleequipo=Equipo::join('ua','equipo.ua_id','=','ua.id')
        ->join('marca','equipo.marca_id','=','marca.id')->where('ua.codigo','=',$regmanveh->ua_id)
        ->select('equipo.descripcion as unidad','equipo.placa as placa','equipo.modelo as modelo','marca.descripcion as marca')->get();
        $posiblevehiculo=Vehiculo::join('ua','vehiculo.ua_id','=','ua.id')
        ->join('marca','vehiculo.marca_id','=','marca.id')->where('ua.codigo','=',$regmanveh->ua_id)
        ->select('vehiculo.placa as placa','vehiculo.modelo as modelo','marca.descripcion as marca')->get();
        

        if(count($posibleequipo)>0||count($posiblevehiculo)>0){
                if(count($posibleequipo)>0){
                    $data['unidad'] = $posibleequipo[0]->unidad;
                    $data['placa'] = $posibleequipo[0]->placa;
                    $data['modelo'] = $posibleequipo[0]->modelo;
                    $data['marca'] = $posibleequipo[0]->marca;
                }else{
                    $data['unidad'] = '--';
                    $data['placa'] = $posiblevehiculo[0]->placa;
                    $data['modelo'] = $posiblevehiculo[0]->modelo;
                    $data['marca'] = $posiblevehiculo[0]->marca;
                }
        }else{
            $data['unidad'] = '--';
            $data['placa'] = '--';
            $data['modelo'] = '--';
            $data['marca'] = '--';
        }*/


        // dd($data);
        $html = view('app.regmanveh.pdf.template_individual', $data)->render();

        $mpdf = new Mpdf();
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);

        $mpdf->Output($namefile, "I");
	    }

}
