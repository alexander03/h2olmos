<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Repuesto;
use App\Unidad;
use App\Equipo;
use App\Vehiculo;
use App\RegRepVeh;
use App\Checklistvehicular;
use App\Ua;
use App\Rules\SearchUaPadre;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Concesionaria;
use App\DescripcionRegRepVeh;
use Mpdf\Mpdf;

class RegRepVehController extends Controller
{
    protected $folderview      = 'app.regrepveh';
    protected $tituloAdmin     = 'Registro de Repuesto Vehicular';
    protected $tituloRegistrar = 'Registro de Repuesto Vehicular';
    protected $tituloModificar = 'Modificar Repuesto Vehicular';
    protected $tituloEliminar  = 'Eliminar Repuesto Vehicular';
    protected $tituloActivar  = 'Activar repuesto';
    protected $rutas           = array(
       // 'create' => 'regrepveh.createregrepveh',
        'createrepuesto' => 'regrepveh.createrepuesto',
        'buscarporua' => 'regrepveh.buscarporua',
        'edit'   => 'regrepveh.edit', 
        'delete' => 'regrepveh.eliminar',
        'activar' => 'regrepveh.activar',
        'search' => 'regrepveh.buscar',
        'store' => 'regrepveh.store',
        'index'  => 'regrepveh.index',
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'RegRepVeh';
        $filter           = Libreria::getParam($request->input('filter'));
		$ConcesionariaActual = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
        ->join('users','users.id','=','userconcesionaria.user_id')
        ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
       	->select('concesionaria.id','concesionaria.razonsocial')->get();
       	$idConcAct=$ConcesionariaActual[0]->id;

        $fechainicio= $request->input('fechainicio');
        $fechafin= $request->input('fechafin');
        $resultado= RegRepVeh::where('regrepveh.concesionaria_id',$idConcAct)
        ->where(function($q) use ($fechainicio, $fechafin) {
                if ( $fechainicio !== null ) $q->where('regrepveh.fechasalida','>=', $fechainicio);
                if ( $fechafin !== null ) $q->where('regrepveh.fechaentrada','<=', $fechafin);
            })
        ->where(function($q) use ($filter){
        $q->where('regrepveh.cliente', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.ua_id', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.telefono', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.ordencompra', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.fechaentrada', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.fechasalida', 'like', '%'.$filter.'%');
     	});


        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cliente', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Orden de Compra', 'numero' => '1');
        $cabecera[]       = array('valor' => 'UA', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Km Inicial', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Km Mant.', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Km Final', 'numero' => '1');
        $cabecera[]       = array('valor' => 'FechaEntrada', 'numero' => '1');
        $cabecera[]       = array('valor' => 'FechaSalida', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Telefono', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Opciones', 'numero' => '3');
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
        $entidad          = 'RegRepVeh';
        $title            = $this->tituloAdmin;
        $tituloRegistrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        
        return view($this->folderview.'.admin')->with(compact('entidad', 'title','tituloRegistrar', 'ruta'));
    }


    public function createrepuesto(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'RegRepVeh';
        $regrepveh = null;
        $arrConcesionarias = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
        ->join('users','users.id','=','userconcesionaria.user_id')
        ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
       	->select('concesionaria.id','concesionaria.razonsocial')->get();
        $oObservaciones=array(new DescripcionRegRepVeh());
        $oObservaciones[0]->id=-1 ; 
        $ua="";
        $idconc=$arrConcesionarias[0]->id;
        $oConcesionaria=$arrConcesionarias[0]->razonsocial;
        //$oTipos=array('' => 'Seleccione Tipo');
        $oTipos=array('' => 'Seleccione Tipo');
        $oTipos=array('1' => 'Preventivo');
        $oTipos+=array('2' => 'Correctivo');
        $formData = array('regrepveh.createregrepveh');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant2')->with(compact('regrepveh', 'oTipos','formData', 'entidad','oConcesionaria','idconc','ua','oObservaciones', 'boton', 'listar'));
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
        $entidad  = 'RegRepVeh';
        $repuesto = null;
        $formData = array('repuestos.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        $arrUnidades = Unidad::getAll();
        $cboUnidades = array('' => 'Seleccione');
        foreach($arrUnidades as $k=>$v){
            $cboUnidades += array($v->id=>$v->descripcion);
        }
        return view($this->folderview.'.mant_checklistvehicular')->with(compact('repuesto', 'formData', 'entidad', 'boton', 'cboUnidades', 'listar'));
    }

    public function store(Request $request){

        $reglas = [
            'concesionaria_id' => 'required',
            'cliente' => 'required|max:250',
            'ordencompra' => 'required|max:250',
            'ua_id' => ['required', new SearchUaPadre()],
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
            'ordencompra.required' => 'Orden compra Campo Vacío',
            'cliente.max' => 'Nombre de Cliente muy extenso, máximo 250 caracteres',
            'ordencompra.max' => 'Orden de Compra muy extensa, máximo 250 caracteres',
            'ua_id.required' => 'UA Campo Vacío',
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

        $idn=DB::select("SHOW TABLE STATUS LIKE 'regrepveh'");
        $next_id=$idn[0]->Auto_increment;

        
        $error = DB::transaction(function() use($request,$next_id){
            $regrepv = new RegRepVeh();
            $regrepv -> id =$next_id;
            $regrepv -> cliente  = $request -> input('cliente');
            $regrepv -> ordencompra  = $request -> input('ordencompra');
            $regrepv -> concesionaria_id  = $request -> input('concesionaria_id');
            $regrepv -> ua_id = $request -> input('ua_id');
            $regrepv -> kminicial = $request -> input('kminicial');
            $regrepv -> kmman = $request -> input('kmman');
            $regrepv -> kmfinal = $request -> input('kmfinal');
            $regrepv -> fechaentrada = $request -> input('fechaentrada');
            $regrepv -> fechasalida = $request -> input('fechasalida');
            $regrepv -> tipomantenimiento = $request -> input('tipomantenimiento');
            $regrepv -> telefono = $request -> input('telefono');
            $regrepv -> save();

            //ACTUALIZO H. ACTUAL DEL VEHICULO
            $vehiculo = Vehiculo::where('ua_id', $request->input('ua_id'))->first();
            $vehiculo->kilometraje_rec =  $request->input('kmfinal') - $vehiculo->kilometraje_act;
            $vehiculo->save();
        });


        $cantidades=$request->cantidad;
        $repuestosid=$request->repuestoid;
        $montos=$request->monto;
        for ($i = 0; $i < count($cantidades); $i++) {
           $error = DB::transaction(function() use($i,$request,$next_id,$cantidades,$repuestosid,$montos){
            $descripcionregrepv = new DescripcionRegRepVeh();
            $descripcionregrepv -> regrepveh_id =$next_id;
            $descripcionregrepv -> cantidad  = $cantidades[$i];
            $descripcionregrepv -> repuesto_id  = intval($repuestosid[$i]);
            $descripcionregrepv -> monto = $montos[$i];;
            $descripcionregrepv -> save();
        }); 
        }

        


        return is_null($error) ? "OK" : $error;
    }


    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'regrepveh');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje = true;
        $modelo   = RegRepVeh::find($id);
        $entidad  = 'RegRepVeh';
        $formData = array('route' => array('regrepveh.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'regrepveh');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $regrepveh = RegRepVeh::find($id);
            $regrepveh->delete();
        });
        return is_null($error) ? "OK" : $error;
    }



    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'regrepveh');
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
        $regrepveh = RegRepVeh::find($id);
        $oObservaciones=DescripcionRegRepVeh::where('regrepveh_id','=',$id)
            ->join('repuesto', 'descripcionregrepveh.repuesto_id', '=', 'repuesto.id')
            ->join('unidad', 'repuesto.unidad_id', '=', 'unidad.id')
            ->select('descripcionregrepveh.id as id','descripcionregrepveh.monto as monto','descripcionregrepveh.cantidad as cantidad','repuesto.codigo as codigo','repuesto.id as repuesto_id','repuesto.descripcion as descripcion','unidad.descripcion as unidad')
        ->get();

        $oua = Ua::where('codigo','=',$regrepveh->ua_id)->get();
        $ua= $oua[0]->descripcion;
        
        $entidad  = 'RegRepVeh';
        $formData = array('regrepveh.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant2')->with(compact('regrepveh','oConcesionaria','idconc','ua','oObservaciones', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function update(Request $request, $id)
    {

        $reglas = [
            'concesionaria_id' => 'required',
            'cliente' => 'required|max:250',
            'ordencompra' => 'required|max:250',
            'ua_id' => ['required', new SearchUaPadre()],
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
            'ordencompra.required' => 'Orden compra Campo Vacío',
            'cliente.max' => 'Nombre de Cliente muy extenso, máximo 250 caracteres',
            'ordencompra.max' => 'Orden de Compra muy extensa, máximo 250 caracteres',
            'ua_id.required' => 'UA Campo Vacío',
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




        $existe = Libreria::verificarExistencia($id, 'regrepveh');
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
            $regrepv = RegRepVeh::find($id);
            $regrepv -> cliente  = $request -> input('cliente');
            $regrepv -> ordencompra  = $request -> input('ordencompra');
            $regrepv -> concesionaria_id  = $request -> input('concesionaria_id');
            $regrepv -> ua_id = $request -> input('ua_id');
            $regrepv -> kmman = $request -> input('kmman');
            $regrepv -> kminicial = $request -> input('kminicial');
            $regrepv -> kmfinal = $request -> input('kmfinal');
            $regrepv -> fechaentrada = $request -> input('fechaentrada');
            $regrepv -> fechasalida = $request -> input('fechasalida');
            $regrepv -> tipomantenimiento = $request -> input('tipomantenimiento');
            $regrepv -> telefono = $request -> input('telefono');
            
            $regrepv -> save();

            //ACTUALIZO K. RECORRIDO DEL VEHICULO
            $vehiculo = Vehiculo::where('ua_id', $request->input('ua_id'))->first();
            $vehiculo->kilometraje_rec =  $request->input('kmfinal') - $vehiculo->kilometraje_act;
            $vehiculo->save();
        });
        $ids=$request->idobservacion;
        $montos=$request->monto;
        $cantidades=$request->cantidad;
        $repuestosid=$request->repuestoid;
        for ($i = 0; $i < count($cantidades); $i++) {
           $error = DB::transaction(function() use($id,$i,$ids,$request,$cantidades,$repuestosid,$montos){
            $descripcionregrepv = new DescripcionRegRepVeh();
            if($ids[$i]>=0){$descripcionregrepv = DescripcionRegRepVeh::find($ids[$i]);}
            $descripcionregrepv -> regrepveh_id =$id;
            $descripcionregrepv -> cantidad  = $cantidades[$i];
            $descripcionregrepv -> repuesto_id  = $repuestosid[$i];
            $descripcionregrepv -> monto = $montos[$i];;
            $descripcionregrepv -> save();
        }); 
        }

        $idseliminados=$request->idseliminados;

       /* echo "<script>console.log('Debug idobservacion: " . print_r($ids) . "' );</script>";
         echo "<script>console.log('Debug idobservacion: " . print_r($montos) . "' );</script>";
        echo "<script>console.log('Debug repuestosid: " . print_r($repuestosid) . "' );</script>";
        echo "<script>console.log('Debug idseliminados: " . print_r($idseliminados) . "' );</script>";
        */if($idseliminados!=null){
            foreach($idseliminados as $k=>$idd){
                $error = DB::transaction(function() use($idd){
                    if($idd>0){
                $regrepveh = DescripcionRegRepVeh::find($idd);
                $regrepveh->delete();}
                }); 
            }
        }   






        return is_null($error) ? "OK" : $error;
    }


public function searchAutocompleteRepuesto($query){

        $consulta = "select repuesto.id as id,repuesto.codigo as codigo, repuesto.descripcion as descripcion, CONCAT(`codigo`, ' - ', repuesto.descripcion) as 'search', unidad.descripcion as unidad
            from repuesto inner join unidad on repuesto.unidad_id = unidad.id
            where repuesto.deleted_at IS NULL AND
            (`codigo` LIKE '%".$query."%' OR repuesto.descripcion LIKE '%".$query."%')";
        $res = DB::select($consulta);
        
        return response() -> json($res);
    }

public function generatePDF(Request $request) {
    $id=$request->id;
        if ( $request->id == null || !is_numeric($request->id) ) return;

        $namefile = 'RegistroDeRepuestoVehicular - '.time().'.pdf';  
        
        $ConcesionariaActual = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
        ->join('users','users.id','=','userconcesionaria.user_id')
        ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
        ->select('concesionaria.id','concesionaria.razonsocial')->get();
        $ConcAct=$ConcesionariaActual[0]->razonsocial;
        $regrepveh = RegRepVeh::find($id);
        $oObservaciones=DescripcionRegRepVeh::where('regrepveh_id','=',$id)
            ->join('repuesto', 'descripcionregrepveh.repuesto_id', '=', 'repuesto.id')
            ->join('unidad', 'repuesto.unidad_id', '=', 'unidad.id')
            ->select('descripcionregrepveh.id as id','descripcionregrepveh.monto as monto','descripcionregrepveh.cantidad as cantidad','repuesto.codigo as codigo','repuesto.id as repuesto_id','repuesto.descripcion as descripcion','unidad.descripcion as unidad')
        ->get();
        

        $data=[];
        $data['concesionaria'] = $ConcAct;
        $data['cliente'] = $regrepveh->cliente;
        $data['ordencompra'] = $regrepveh->ordencompra;
        $data['ua_id'] = $regrepveh->ua_id;
        $data['tipomantenimiento']=$regrepveh->tipomantenimiento==1?'Preventivo':'Correctivo';
        $data['kmman'] = $regrepveh->kmman;
        $data['kminicial'] = $regrepveh->kminicial;
        $data['kmfinal'] = $regrepveh->kmfinal;
        $data['telefono'] = $regrepveh->telefono;
        $data['fechaentrada'] = $regrepveh->fechaentrada;
        $data['fechasalida'] = $regrepveh->fechasalida;
        $data['regrepveh'] = $regrepveh;
        $data['observaciones'] = $oObservaciones;
        $data['namefile'] = $namefile;

        $posibleequipo=Equipo::join('ua','equipo.ua_id','=','ua.id')
        ->join('marca','equipo.marca_id','=','marca.id')->where('ua.codigo','=',$regrepveh->ua_id)
        ->select('equipo.descripcion as unidad','equipo.placa as placa','equipo.modelo as modelo','marca.descripcion as marca')->get();
        $posiblevehiculo=Vehiculo::join('ua','vehiculo.ua_id','=','ua.id')
        ->join('marca','vehiculo.marca_id','=','marca.id')->where('ua.codigo','=',$regrepveh->ua_id)
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
        }

        // dd($data);
        $html = view('app.regrepveh.pdf.template_individual', $data)->render();

        $mpdf = new Mpdf();
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);

        $mpdf->Output($namefile, "I");
    }

}