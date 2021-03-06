<?php

namespace App\Http\Controllers;

use App\Abastecimiento;
use App\AbastecimientoCombustible;
use App\Concesionaria;
use App\Conductor;
use App\Equipo;
use App\Exports\AbastecimientoCombustibleExport;
use App\Exports\ReporteDiariodeCombustible;
use App\Librerias\Libreria;
use App\Rules\SearchUaPadre;
use App\Rules\SelectDifZero;
use App\Ua;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UaExport;
use App\Grifo;
use App\Imports\UaImport;
use App\Rules\AuthenticateUser;
use App\Rules\SearchConductorRule;
use App\Rules\SearchEquipo;
use App\Rules\SearchGrifoRule;
use App\Tipocombustible;
use App\User;
use App\Vehiculo;
use Exception;
use Illuminate\Support\Facades\Hash;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;
use App\Events\UserHasCreatedOrDeleted;
use App\Events\UserHasEdited;


use function PHPSTORM_META\map;

class AbastecimientoCombustibleController extends Controller{
    protected $folderview      = 'app.abast-combustible';
    protected $tituloAdmin     = 'Abastecimiento de Combustible';
    protected $tituloRegistrar = 'Registrar abastecimiento';
    protected $tituloModificar = 'Modificar abastecimiento';
    protected $tituloEliminar  = 'Eliminar abastecimiento';
    protected $rutas           = array('create' => 'abastecimiento.create', 
            'edit'   => 'abastecimiento.edit', 
            'delete' => 'abastecimiento.eliminar',
            'search' => 'abastecimiento.buscar',
            'index'  => 'abastecimiento.index',
    );

    public function buscar(Request $request){

        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'AbastecimientoCombustible';
        $fechaQuery       = Libreria::getParam($request->input('date_abastecimiento'));
        $codigoUaQuery    = Libreria::getParam($request->input('codigo_ua'));
        $grifoQuery       = Libreria::getParam($request->input('grifo'));
        $placaQuery       = Libreria::getParam($request->input('placa'));
        //Buscar ua 
        $uaException = false;
        if( isset($codigoUaQuery) ){
            $uaDB = Ua::select('id') -> where('codigo', 'LIKE', "%{$codigoUaQuery}%") -> first();   
            //*Excepcion si no encuentra registro
            ( isset( $uaDB ) ) ? $uaException = false : $uaException = true;
        }
        $uaId = (isset( $uaDB )) ? $uaDB -> id : null;
        //Buscar grifo
        $grifoException = false;
        if( isset($grifoQuery) ){
            $grifoDB = Grifo::select('id') -> where('descripcion', 'LIKE', "%{$grifoQuery}%") -> first();
            //*Excepcion si no encuentra registro
            ( isset( $grifoDB ) ) ? $grifoException = false: $grifoException = true;
        }
        $grifoId = (isset( $grifoDB )) ? $grifoDB -> id : null;
        //Buscar equipo
        $equipVehiException = false;
        if( isset($placaQuery) ){
            $equipoDB = Equipo::select('id') -> where('placa', 'LIKE', "%{$placaQuery}%") -> first();
            $vehiculoDB = Vehiculo::select('id') -> where('placa', 'LIKE', "%{$placaQuery}%") -> first();
            if( isset($equipoDB) ){
                $vehiculoDB = new Vehiculo();
                $vehiculoDB -> id = -1;
            }else if( isset($vehiculoDB) ){
                $equipoDB = new Equipo();
                $equipoDB -> id = -1;
            }
            //*Excepcion si no encuentra registro
            ( isset($equipoDB) || isset($vehiculoDB) ) ? $equipVehiException = false : $equipVehiException = true;
        }
        $equipoId = (isset( $equipoDB )) ? $equipoDB -> id : null;
        $vehiculoId = (isset( $vehiculoDB )) ? $vehiculoDB -> id : null;
        //Resultado
        $resultado = AbastecimientoCombustible::
            where([
                ['fecha_abastecimiento', 'LIKE', '%'.$fechaQuery.'%'],
                ['ua_id', 'LIKE', "%{$uaId}%"],
                ['grifo_id', 'LIKE', "%{$grifoId}%"]
            ])-> orderBy('fecha_abastecimiento', 'ASC'); 
        //Query compleja 
        if( isset($equipoId) || isset($vehiculoId) ){
            $resultado = AbastecimientoCombustible::
                where([
                    ['fecha_abastecimiento', 'LIKE', '%'.$fechaQuery.'%'],
                    ['ua_id', 'LIKE', "%{$uaId}%"],
                    ['grifo_id', 'LIKE', "%{$grifoId}%"],
                    ['equipo_id', 'LIKE', "%{$equipoId}%"]
                ])->orWhere('vehiculo_id', 'LIKE', "%{$vehiculoId}%")
                -> orderBy('fecha_abastecimiento', 'ASC'); 
        }
        ( $uaException || $grifoException || $equipVehiException ) ? $lista = [] : $lista = $resultado->get();  
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha de abastecimiento', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Grifo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo de combustible', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Conductor - Responsable', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Codigo UA', 'numero' => '1');
        $cabecera[]       = array('valor' => 'UA', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Unidad', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Marca', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Modelo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Placa/serie', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Empresa', 'numero' => '1');
        $cabecera[]       = array('valor' => 'QTD(GL)', 'numero' => '1');
        $cabecera[]       = array('valor' => 'QTD(L)', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Km', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Abastecimiento por día', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Motivo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Comprobante', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número de comprobante', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Hora de inicio', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Hora de fin', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Lugar de abastecimiento', 'numero' => '1');
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
    
    public function index(){
        
        $entidad          = 'AbastecimientoCombustible';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $cboGrifos = Grifo::select('id','descripcion')->get();
        return view($this->folderview.'.admin')->with(compact('entidad', 'cboGrifos' ,'title', 'titulo_registrar', 'ruta'));
    }

    public function create(Request $request){

        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'AbastecimientoCombustible';
        $abastecimiento = null;
        $formData = array('abastecimiento.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        $lstAbastecimientos = Abastecimiento::all();
        $lstTipoCombustibles = Tipocombustible::all();

        return view($this->folderview.'.mant')->with(compact('abastecimiento', 'formData', 'entidad', 'boton', 'listar', 'lstAbastecimientos', 'lstTipoCombustibles'));
    }

    public function store(Request $request){
    
        $reglas = [
            'fecha_abastecimiento' => 'required',
            'grifo_id' => ['required', new SearchGrifoRule()],
            'usuario' => ['required'],
            'password' => ['required', new AuthenticateUser($request->input('usuario'))],
            'ua_id' => ['required', new SearchUaPadre()],
            'equipo_id' => ['nullable', new SearchEquipo()],
            'qtdgl' => 'required',
            'qtdl' => 'required',
            'km' => 'required',
            'abastecimiento_dia' => 'required',
            'motivo' => 'required',
            'comprobante' => 'required',
            'numero_comprobante' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'nullable|after_or_equal:hora_inicio',
            'abastecimiento_id' => 'required',
            'tipocombustible_id' => 'required'
        ];
        $mensajes = [
            'fecha_abastecimiento.required' => 'Su fecha de abastecimiento es requerida',
            'grifo_id.required' => 'El grifo es requerido',
            'usuario.required' => 'El usuario es requerido',
            'password.required' => 'El password es requerido',
            'ua_id.required' => 'Su ua es requerida',
            'equipo_id.required' => 'El equipo o vehículo es requerido',
            'qtdgl.required' => 'Su QTD(GL) es requerido',
            'qtdl.required' => 'Su QTD(L) es requerido',
            'km.required' => 'Su km es requerido',
            'abastecimiento_dia.required' => 'Su abastecimiento por día es requerido',
            'motivo.required' => 'El motivo es requerido',
            'comprobante.required' => 'El comprobante es requerido',
            'numero_comprobante.required' => 'El número de comprobante es requerido',
            'hora_inicio.required' => 'Su fecha de inicio es requerida',
            'hora_fin.required' => 'Su fecha de fin es requerida',
            'hora_fin.after_or_equal' => 'Su fecha de fin no puede ser menor que la de inicio',
            'abastecimiento_id.required' => 'El lugar de abastecimiento es requerido',
            'tipocombustible_id.required' => 'El tipo de combustible es requerido'
        ];
        
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        
        $error = DB::transaction(function() use($request){
            $abastecimiento = new AbastecimientoCombustible();
            $abastecimiento -> fecha_abastecimiento = $request -> input('fecha_abastecimiento');
            //BUSCAR GRIFO
            if($request -> input('grifo_id')){
                $grifoDB =  Grifo::where('descripcion', $request -> input('grifo_id')) -> get();
                $abastecimiento -> grifo_id = (!($grifoDB -> isEmpty())) ? $grifoDB[0] -> id : null;
            }
            //BUSCAR USUARIO
            $usuarioDB = User::where('username', $request -> input('usuario')) -> get();
            $abastecimiento -> user_id = $usuarioDB[0] -> id;
            
            //BUSCAR UA
            if($request -> input('ua_id')){
                $uaDB =  Ua::where('codigo', $request -> input('ua_id')) -> get();
                $abastecimiento -> ua_id = (!($uaDB -> isEmpty())) ? $uaDB[0] -> id : null;
            }
            //BUSCAR EQUIPO
            if($request -> input('equipo_id')){
                if($request -> input('equipo_tipo') === 'e'){
                    $equipoDB =  Equipo::where('id', $request -> input('equipo_id')) -> get();
                    $abastecimiento -> equipo_id = (!($equipoDB -> isEmpty())) ? $equipoDB[0] -> id : null;
                }
                if($request -> input('equipo_tipo') === 'v'){
                    $vehiculoDB =  Vehiculo::where('id', $request -> input('equipo_id')) -> get();
                    $abastecimiento -> vehiculo_id = (!($vehiculoDB -> isEmpty())) ? $vehiculoDB[0] -> id : null;

                    //ACTUALIZO H. ACTUAL DEL VEHICULO
                    $vehiculo = $vehiculoDB[0];
                    $vehiculo->kilometraje_rec =  $request->input('km') - $vehiculo->kilometraje_act;
                    $vehiculo->save();
                }   
            }
            $abastecimiento -> qtdgl = $request -> input('qtdgl');
            $abastecimiento -> qtdl = $request -> input('qtdl');
            $abastecimiento -> km = $request -> input('km');
            $abastecimiento -> abastecimiento_dia = $request -> input('abastecimiento_dia');
            $abastecimiento -> motivo = $request -> input('motivo');
            $abastecimiento -> comprobante = $request -> input('comprobante');
            $abastecimiento -> numero_comprobante = $request -> input('numero_comprobante');
            $abastecimiento -> hora_inicio = $request -> input('hora_inicio');
            $abastecimiento -> hora_fin = $request -> input('hora_fin');
            $abastecimiento -> abastecimiento_id = $request -> input('abastecimiento_id');
            $abastecimiento -> tipocombustible_id = $request -> input('tipocombustible_id');


            event( new UserHasCreatedOrDeleted($abastecimiento->id,'abastecimiento_combustible', auth()->user()->id,'crear'));
            $abastecimiento -> save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function show($id){}

    public function edit($id, Request $request){

        $existe = Libreria::verificarExistencia($id, 'abastecimiento_combustible');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $abastecimiento = AbastecimientoCombustible::find($id);
        $entidad  = 'AbastecimientoCombustible';
        $formData = array('abastecimiento.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $lstAbastecimientos = Abastecimiento::all();
        $lstTipoCombustibles = Tipocombustible::all();

        return view($this->folderview.'.mant')->with(compact('abastecimiento', 'formData', 'entidad', 'boton', 'listar', 'lstAbastecimientos', 'lstTipoCombustibles'));
    }

    public function update(Request $request, $id){

        $reglas = [
            'fecha_abastecimiento' => 'required',
            'grifo_id' => ['required', new SearchGrifoRule()],
            'usuario' => ['required'],
            'password' => ['required'],
            'ua_id' => ['required', new SearchUaPadre()],
            'equipo_id' => ['nullable', new SearchEquipo()],
            'qtdgl' => 'required',
            'qtdl' => 'required',
            'km' => 'required',
            'abastecimiento_dia' => 'required',
            'motivo' => 'required',
            'comprobante' => 'required',
            'numero_comprobante' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'nullable|after_or_equal:hora_inicio',
            'abastecimiento_id' => 'required',
            'tipocombustible_id' => 'required'
        ];

        $mensajes = [
            'fecha_abastecimiento.required' => 'Su fecha de abastecimiento es requerida',
            'grifo_id.required' => 'El grifo es requerido',
            'usuario.required' => 'El usuario es requerido',
            'password.required' => 'El password es requerido',
            'ua_id.required' => 'Su ua es requerida',
            'equipo_id.required' => 'El equipo o vehículo es requerido',
            'qtdgl.required' => 'Su QTD(GL) es requerido',
            'qtdl.required' => 'Su QTD(L) es requerido',
            'km.required' => 'Su km es requerido',
            'abastecimiento_dia.required' => 'Su abastecimiento por día es requerido',
            'motivo.required' => 'El motivo es requerido',
            'comprobante.required' => 'El comprobante es requerido',
            'numero_comprobante.required' => 'El número de comprobante es requerido',
            'hora_inicio.required' => 'Su fecha de inicio es requerida',
            'hora_fin.required' => 'Su fecha de fin es requerida',
            'fecha_fin.after_or_equal' => 'Su fecha de fin no puede ser menor que la de inicio',
            'abastecimiento_id.required' => 'El lugar de abastecimiento es requerido',
            'tipocombustible_id.required' => 'El tipo de combustible es requerido'
        ];
        
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $existe = Libreria::verificarExistencia($id, 'abastecimiento_combustible');
        if ($existe !== true) {
            return $existe;
        }

        $error = DB::transaction(function() use($request, $id){
            $abastecimiento = AbastecimientoCombustible::find($id);
            $abastecimientoCop = $abastecimiento;
            $abastecimiento -> fecha_abastecimiento = $request -> input('fecha_abastecimiento');
            //BUSCAR GRIFO
            if($request -> input('grifo_id')){
                $grifoDB =  Grifo::where('descripcion', $request -> input('grifo_id')) -> get();
                $abastecimiento -> grifo_id = (!($grifoDB -> isEmpty())) ? $grifoDB[0] -> id : null;
            }
            //BUSCAR CONDUCTOR
            if($request -> input('conductor_id')){
                $abastecimiento -> conductor_fake = null;
                $conductorDB =  Conductor::where('dni', $request -> input('conductor_id')) -> get();
                $abastecimiento -> conductor_id = (!($conductorDB -> isEmpty())) ? $conductorDB[0] -> id : null;
                if($abastecimiento -> conductor_id === null) $abastecimiento -> conductor_fake = strtoupper($request -> input('conductor_id'));
            }
            //BUSCAR UA
            if($request -> input('ua_id')){
                $uaDB =  Ua::where('codigo', $request -> input('ua_id')) -> get();
                $abastecimiento -> ua_id = (!($uaDB -> isEmpty())) ? $uaDB[0] -> id : null;
            }
            //BUSCAR EQUIPO
            if($request -> input('equipo_id')){
                if($request -> input('equipo_tipo') === 'e'){
                    $abastecimiento -> vehiculo_id = null;
                    $equipoDB =  Equipo::where('id', $request -> input('equipo_id')) -> get();
                    $abastecimiento -> equipo_id = (!($equipoDB -> isEmpty())) ? $equipoDB[0] -> id : null;
                }
                if($request -> input('equipo_tipo') === 'v'){
                    $abastecimiento -> equipo_id = null;
                    $vehiculoDB =  Vehiculo::where('id', $request -> input('equipo_id')) -> get();
                    $abastecimiento -> vehiculo_id = (!($vehiculoDB -> isEmpty())) ? $vehiculoDB[0] -> id : null;

                    //ACTUALIZO K. RECORRIDO DEL VEHICULO
                    $vehiculo = $vehiculoDB[0];
                    $vehiculo->kilometraje_rec =  $request->input('km') - $vehiculo->kilometraje_act;
                    $vehiculo->save();
                }   
            }
            $abastecimiento -> qtdgl = $request -> input('qtdgl');
            $abastecimiento -> qtdl = $request -> input('qtdl');
            $abastecimiento -> km = $request -> input('km');
            $abastecimiento -> abastecimiento_dia = $request -> input('abastecimiento_dia');
            $abastecimiento -> motivo = $request -> input('motivo');
            $abastecimiento -> comprobante = $request -> input('comprobante');
            $abastecimiento -> numero_comprobante = $request -> input('numero_comprobante');
            $abastecimiento -> hora_inicio = $request -> input('hora_inicio');
            $abastecimiento -> hora_fin = $request -> input('hora_fin');
            $abastecimiento -> abastecimiento_id = $request -> input('abastecimiento_id');
            $abastecimiento -> tipocombustible_id = $request -> input('tipocombustible_id');

            $abastecimiento -> save();


            event(new UserHasEdited($abastecimientoCop,$abastecimiento,'abastecimiento_combustible',auth()->user()->id));
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego){

        $existe = Libreria::verificarExistencia($id, 'abastecimiento_combustible');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje = true;
        $modelo   = AbastecimientoCombustible::find($id);
        $entidad  = 'AbastecimientoCombustible';
        $formData = array('route' => array('abastecimiento.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }

    public function destroy($id){

        $existe = Libreria::verificarExistencia($id, 'abastecimiento_combustible');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $abastecimiento = AbastecimientoCombustible::find($id);
            event( new UserHasCreatedOrDeleted($abastecimiento->id,'abastecimiento_combustible', auth()->user()->id,'eliminar'));
            $abastecimiento->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    //PETICION GET QUE DEVUELVE TODOS LOS DATOS GRIFO
    public function searchAutocompleteGrifo($query){
    
        $consulta = "select id, descripcion from grifo where
            deleted_at IS NULL AND
            descripcion LIKE '%{$query}%'";
        $res = DB::select($consulta);
        
        return response() -> json($res);
    }

    //PETICION GET QUE DEVUELVE TODOS LOS DATOS CONDUCTOR
    public function searchAutocompleteConductor($query){

        $consulta = "select id, nombres, apellidos, dni, CONCAT(nombres, ' ', apellidos, ' - ', dni) as 'search' 
            from conductor where
            deleted_at IS NULL AND
            apellidos LIKE UPPER('%".$query."%') OR dni LIKE '%".$query."%'";
        $res = DB::select($consulta);
        
        return response() -> json($res);
    }

    //PETICION GET QUE DEVUELVE TODOS LOS DATOS EQUIPO O VEHICULO
    public function searchAutocompleteEquipo($query){

        $consulta = "select id, tipo, descripcion, ua, ua_desc,
            CONCAT(ua, ' - ', descripcion) as 'search'
            from view_equipo_vehiculo
            where deleted_at IS NULL AND 
            concesionaria_id = {$this -> getConsecionariaActual()} AND
            (ua LIKE '%".$query."%' OR descripcion LIKE '%".$query."%')";
        $res = DB::select($consulta);
        
        return response() -> json($res);
    }

    //EXPORT EXCEL
    public function exportExcel(){
        
        return Excel::download(new AbastecimientoCombustibleExport, 'abast-combustible-list.xlsx');
    }

    //EXPORT EXCEL AND PDF
    public function exportControlDiario(Request $request){

        if($request->tipo == 1){
            return Excel::download(new ReporteDiariodeCombustible($request->fecha,$request->grifo), 'abast-combustible-diario.xlsx');
        }else{

            $namefile = 'abast-combustible-diario-' . $request->fecha . '.pdf';

            $fechaAbast = $request->fecha;
            $idGrifo = $request->grifo;
            
            $queryVehiculo = AbastecimientoCombustible::select(
                'abastecimiento_combustible.id as id',
                DB::raw('(CASE WHEN c.user_id IS NULL THEN us.name ELSE CONCAT(c.apellidos, " ", c.nombres) END) AS res'), 
                'c.dni as dni',
                'ua.codigo as code',
                DB::raw('(CASE WHEN vh.modelo IS NULL THEN "-" ELSE vh.modelo END) AS desceq'), 
                'mc.descripcion as descmc', 
                DB::raw('(CASE WHEN vh.placa IS NULL THEN "-" ELSE vh.placa END) AS eqpl'),
                'km', 'qtdgl', 'abastecimiento_combustible.hora_inicio', 'abastecimiento_combustible.hora_fin',
                DB::raw('(CASE WHEN ct.razonsocial IS NULL THEN "-" ELSE ct.razonsocial END) AS crza') )
                -> leftJoin('grifo as g', 'g.id', '=', 'grifo_id')
                -> leftJoin('users as us', 'us.id', '=', 'abastecimiento_combustible.user_id')
                -> leftJoin('conductor as c', 'c.user_id', '=', 'abastecimiento_combustible.user_id')
                -> leftjoin('ua', 'ua.id', '=', 'ua_id')
                -> leftJoin('vehiculo as vh', 'vh.id', '=', 'vehiculo_id')
                -> leftJoin('marca as mc', 'mc.id', '=', 'vh.marca_id')
                -> leftJoin('contratista as ct', 'ct.id', '=', 'vh.contratista_id')
                -> leftJoin('tipocombustible as tcom', 'tcom.id', '=', 'abastecimiento_combustible.tipocombustible_id')
                -> leftJoin('abastecimiento as abast', 'abast.id', '=', 'abastecimiento_combustible.abastecimiento_id')
                -> whereNull('abastecimiento_combustible.deleted_at')
                -> where([
                    [ 'abastecimiento_combustible.fecha_abastecimiento', '=', $fechaAbast ],
                    [ 'abastecimiento_combustible.grifo_id', '=', $idGrifo ]
                ]);

            $resultQuery = AbastecimientoCombustible::select(
                'abastecimiento_combustible.id as id',
                DB::raw('(CASE WHEN c.user_id IS NULL THEN us.name ELSE CONCAT(c.apellidos, " ", c.nombres) END) AS res'),
                'c.dni as dni',
                'ua.codigo as code',
                DB::raw('(CASE WHEN eq.descripcion IS NULL THEN "-" ELSE eq.descripcion END) AS desceq'),
                'mc.descripcion as descmc', 
                DB::raw('(CASE WHEN eq.placa IS NULL THEN "-" ELSE eq.placa END) AS eqpl'), 
                'km', 'qtdgl', 'abastecimiento_combustible.hora_inicio', 'abastecimiento_combustible.hora_fin',
                DB::raw('(CASE WHEN ct.razonsocial IS NULL THEN "-" ELSE ct.razonsocial END) AS crza') )
                -> leftJoin('grifo as g', 'g.id', '=', 'grifo_id')
                -> leftJoin('users as us', 'us.id', '=', 'abastecimiento_combustible.user_id')
                -> leftJoin('conductor as c', 'c.user_id', '=', 'abastecimiento_combustible.user_id')
                -> leftjoin('ua', 'ua.id', '=', 'ua_id')
                -> leftJoin('equipo as eq', 'eq.id', '=', 'equipo_id')
                -> leftJoin('marca as mc', 'mc.id', '=', 'eq.marca_id')
                -> leftJoin('contratista as ct', 'ct.id', '=', 'eq.contratista_id')
                -> leftJoin('tipocombustible as tcom', 'tcom.id', '=', 'abastecimiento_combustible.tipocombustible_id')
                -> leftJoin('abastecimiento as abast', 'abast.id', '=', 'abastecimiento_combustible.abastecimiento_id')
                -> whereNull('abastecimiento_combustible.deleted_at')
                -> unionAll($queryVehiculo)
                -> where([
                    [ 'abastecimiento_combustible.fecha_abastecimiento', '=', $fechaAbast ],
                    [ 'abastecimiento_combustible.grifo_id', '=', $idGrifo ]
                ])
                -> get();
            
            $newResult = [];
            $arrId = [];
        
            for($i = 0; $i < count($resultQuery); $i++) { 

                if(isset($arrId[0])){
                    $isRepeat = false;
                    foreach($arrId as $id){
                        if($resultQuery[$i] -> id === $id) $isRepeat = true;
                    }
                    if(!$isRepeat) array_push($newResult, $resultQuery[$i]);
                    array_push($arrId, $resultQuery[$i] -> id);
                }else{
                    $arrId = [ $resultQuery[0] -> id ];
                    $newResult = [ $resultQuery[0] ];
                }
            }

            for($i = 0; $i < count($newResult); $i++) unset($newResult[$i] -> id);
            $collectionResult = collect($newResult);

            $data['data'] = $collectionResult;
            $html = view('app.abast-combustible.pdf.control_diario_combustible', $data)->render();
            $mpdf = new Mpdf(['orientation' => 'L']);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            $mpdf->Output($namefile, "I");
        }
    }

    private function getConsecionariaActual(){

        $ConcesionariaActual = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
            ->join('users','users.id','=','userconcesionaria.user_id')
            ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
            ->select('concesionaria.id','concesionaria.razonsocial')->get();
        $idConcAct=$ConcesionariaActual[0]->id;

        return $idConcAct;
    }
}

