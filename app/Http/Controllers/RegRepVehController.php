<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Repuesto;
use App\Unidad;
use App\Equipo;
use App\RegRepVeh;
use App\Ua;
use App\Rules\SearchUaPadre;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Concesionaria;
use App\DescripcionRegRepVeh;

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

        $resultado= RegRepVeh::where('regrepveh.concesionaria_id',$idConcAct)
        ->where(function($q) use ($filter){
        $q->where('regrepveh.cliente', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.ua_id', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.telefono', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.fechaentrada', 'like', '%'.$filter.'%')
          ->orWhere('regrepveh.fechasalida', 'like', '%'.$filter.'%');
     	});


        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cliente', 'numero' => '1');
        $cabecera[]       = array('valor' => 'UA', 'numero' => '1');
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

        foreach($arrConcesionarias as $k=>$v){
            $oConcesionarias = array($v->id=>$v->razonsocial);
        }
        //$oTipos=array('' => 'Seleccione Tipo');
        $oTipos=array('' => 'Seleccione Tipo');
        $oTipos=array('1' => 'Preventivo');
        $oTipos+=array('2' => 'Correctivo');
        $formData = array('regrepveh.createregrepveh');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant2')->with(compact('regrepveh', 'oTipos','formData', 'entidad','oConcesionarias','oObservaciones', 'boton', 'listar'));
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
            'cliente' => 'required|max:10',
            'ua_id' => ['required', new SearchUaPadre()],
            'fechaentrada' => 'required',
            'fechasalida' => 'required',
            'kmman' => 'required',
            'kminicial' => 'required',
            'kmfinal' => 'required',
            'tipomantenimiento' => 'required',
            'telefono' => 'required'
        ];

        $mensajes = [
            'cliente.required' => 'Cliente Campo Vacío',
            'cliente.max' => 'Nombre de Cliente muy largo, máximo 250 caracteres',
            'ua_id.required' => 'UA Campo Vacío',
            'fechaentrada.required' => 'Fecha Entrada Campo Vacío',
            'fechasalida.required' => 'Fecha Salida Campo Vacío',
            'kmman.required' => 'Km de Mantenimiento Campo Vacío',
            'kminicial.required' => 'Km Inicial Campo Vacío',
            'kmfinal.required' => 'Km Final Campo Vacío',
            'tipomantenimiento.required' => 'Tipo de Mantenimiento No Seleccionado',
            'telefono.required' => 'Campo Vacío'
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
        });


        $cantidades=$request->cantidad;
        $unidades=$request->unidad;
        $codigos=$request->codigo;
        $montos=$request->monto;
        $descripciones=$request->descripcion;
        for ($i = 0; $i < count($cantidades); $i++) {
           $error = DB::transaction(function() use($i,$request,$next_id,$cantidades,$unidades,$codigos,$montos,$descripciones){
            $descripcionregrepv = new DescripcionRegRepVeh();
            $descripcionregrepv -> regrepveh_id =$next_id;
            $descripcionregrepv -> cantidad  = $cantidades[$i];
            $descripcionregrepv -> unidad  = $unidades[$i];;
            $descripcionregrepv -> codigo = $codigos[$i];;
            $descripcionregrepv -> monto = $montos[$i];;
            $descripcionregrepv -> descripcion = $descripciones[$i];;
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

        foreach($arrConcesionarias as $k=>$v){
            $oConcesionarias = array($v->id=>$v->razonsocial);
        }
        

        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $regrepveh = RegRepVeh::find($id);
        $oObservaciones=DescripcionRegRepVeh::where('regrepveh_id','=',$id)->get();


        
        $entidad  = 'RegRepVeh';
        $formData = array('regrepveh.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant2')->with(compact('regrepveh','oConcesionarias','oObservaciones', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function update(Request $request, $id)
    {

        $reglas = [
            'concesionaria_id' => 'required',
            'cliente' => 'required|max:10',
            'ua_id' => ['required', new SearchUaPadre()],
            'fechaentrada' => 'required',
            'fechasalida' => 'required',
            'kmman' => 'required',
            'kminicial' => 'required',
            'kmfinal' => 'required',
            'tipomantenimiento' => 'required',
            'telefono' => 'required'
        ];

        $mensajes = [
            'cliente.required' => 'Cliente Campo Vacío',
            'cliente.max' => 'Nombre de Cliente muy largo, máximo 250 caracteres',
            'ua_id.required' => 'UA Campo Vacío',
            'fechaentrada.required' => 'Fecha Entrada Campo Vacío',
            'fechasalida.required' => 'Fecha Salida Campo Vacío',
            'kmman.required' => 'Km de Mantenimiento Campo Vacío',
            'kminicial.required' => 'Km Inicial Campo Vacío',
            'kmfinal.required' => 'Km Final Campo Vacío',
            'tipomantenimiento.required' => 'Tipo de Mantenimiento No Seleccionado',
            'telefono.required' => 'Campo Vacío'
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

        });
        $ids=$request->idid;
        $cantidades=$request->cantidad;
        $unidades=$request->unidad;
        $codigos=$request->codigo;
        $montos=$request->monto;
        $descripciones=$request->descripcion;
        for ($i = 0; $i < count($cantidades); $i++) {
           $error = DB::transaction(function() use($id,$i,$ids,$request,$cantidades,$unidades,$codigos,$montos,$descripciones){
            $descripcionregrepv = new DescripcionRegRepVeh();
            if($ids[$i]>=0){$descripcionregrepv = DescripcionRegRepVeh::find($ids[$i]);}
            $descripcionregrepv -> regrepveh_id =$id;
            $descripcionregrepv -> cantidad  = $cantidades[$i];
            $descripcionregrepv -> unidad  = $unidades[$i];;
            $descripcionregrepv -> codigo = $codigos[$i];;
            $descripcionregrepv -> monto = $montos[$i];;
            $descripcionregrepv -> descripcion = $descripciones[$i];;
            $descripcionregrepv -> save();
        }); 
        }

        $idseliminados=$request->idseliminados;

        if($idseliminados!=null){
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



}