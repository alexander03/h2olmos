<?php

namespace App\Http\Controllers;

use App\AbastecimientoCombustible;
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
use App\Imports\UaImport;
use App\Rules\SearchConductorRule;
use App\Rules\SearchEquipo;
use App\Rules\SearchGrifoRule;
use Exception;

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
        $nombre             = Libreria::getParam($request->input('descripcion'));
        $resultado        = AbastecimientoCombustible::where('fecha_abastecimiento', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('fecha_abastecimiento', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Grifo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo de combustible', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Conductor', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ua', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Unidad', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Marca', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Modelo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Placa/serie', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Empresa', 'numero' => '1');
        $cabecera[]       = array('valor' => 'QTD(GL)', 'numero' => '1');
        $cabecera[]       = array('valor' => 'QTD(L)', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Km', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Abastecimiento por día', 'numero' => '1');
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
    
    public function index(){
        
        $entidad          = 'AbastecimientoCombustible';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    public function create(Request $request){

        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'AbastecimientoCombustible';
        $abastecimiento = null;
        $formData = array('abastecimiento.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 

        return view($this->folderview.'.mant')->with(compact('abastecimiento', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function store(Request $request){
    
        $reglas = [
            'fecha_abastecimiento' => 'required',
            'grifo_id' => ['required', new SearchGrifoRule()],
            'tipo_combustible' => 'required',
            'conductor_id' => ['required', new SearchConductorRule()],
            'ua_id' => ['required', new SearchUaPadre()],
            'equipo_id' => ['required', new SearchEquipo()],
            'qtdgl' => 'required',
            'qtdl' => 'required',
            'km' => 'required',
            'abastecimiento_dia' => 'required'
        ];
        $mensajes = [
            'fecha_abastecimiento.required' => 'Su fecha de abastecimiento es requerida',
            'grifo_id.required' => 'El grifo es requerido',
            'tipo_combustible.required' => 'El tipo de combustible es requerido',
            'conductor_id.required' => 'El conductor es requerido',
            'ua_id.required' => 'Su ua es requerida',
            'equipo_id.required' => 'El equipo es requerido',
            'qtdgl.required' => 'Su QTD(GL) es requerido',
            'qtdl.required' => 'Su QTD(L) es requerido',
            'km.required' => 'Su km es requerido',
            'abastecimiento_dia.required' => 'Su abastecimiento por día es requerido'
		];
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        
        $error = DB::transaction(function() use($request){
            $abastecimiento = new AbastecimientoCombustible();
            $abastecimiento -> fecha_abastecimiento = $request -> input('fecha_abastecimiento');
            $abastecimiento -> grifo_id = $request -> input('grifo_id');
            $abastecimiento -> tipo_combustible = $request -> input('tipo_combustible');
            $abastecimiento -> conductor_id = $request -> input('conductor_id');
            $abastecimiento -> ua_id = $request -> input('ua_id');
            $abastecimiento -> equipo_id = $request -> input('equipo_id');
            $abastecimiento -> qtdgl = $request -> input('qtdgl');
            $abastecimiento -> qtdl = $request -> input('qtdl');
            $abastecimiento -> km = $request -> input('km');
            $abastecimiento -> abastecimiento_dia = $request -> input('abastecimiento_dia');
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

        return view($this->folderview.'.mant')->with(compact('abastecimiento', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function update(Request $request, $id){

        $reglas = [
            'fecha_abastecimiento' => 'required',
            'grifo_id' => ['required', new SearchGrifoRule()],
            'tipo_combustible' => 'required',
            'conductor_id' => ['required', new SearchConductorRule()],
            'ua_id' => ['required', new SearchUaPadre()],
            'equipo_id' => ['required', new SearchEquipo()],
            'qtdgl' => 'required',
            'qtdl' => 'required',
            'km' => 'required',
            'abastecimiento_dia' => 'required'
        ];

        $mensajes = [
            'fecha_abastecimiento.required' => 'Su fecha de abastecimiento es requerida',
            'grifo_id.required' => 'El grifo es requerido',
            'tipo_combustible.required' => 'El tipo de combustible es requerido',
            'conductor_id.required' => 'El conductor es requerido',
            'ua_id.required' => 'Su ua es requerida',
            'equipo_id.required' => 'El equipo es requerido',
            'qtdgl.required' => 'Su QTD(GL) es requerido',
            'qtdl.required' => 'Su QTD(L) es requerido',
            'km.required' => 'Su km es requerido',
            'abastecimiento_dia.required' => 'Su abastecimiento por día es requerido'
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
            $abastecimiento -> fecha_abastecimiento = $request -> input('fecha_abastecimiento');
            $abastecimiento -> grifo_id = $request -> input('grifo_id');
            $abastecimiento -> tipo_combustible = $request -> input('tipo_combustible');
            $abastecimiento -> conductor_id = $request -> input('conductor_id');
            $abastecimiento -> ua_id = $request -> input('ua_id');
            $abastecimiento -> equipo_id = $request -> input('equipo_id');
            $abastecimiento -> qtdgl = $request -> input('qtdgl');
            $abastecimiento -> qtdl = $request -> input('qtdl');
            $abastecimiento -> km = $request -> input('km');
            $abastecimiento -> abastecimiento_dia = $request -> input('abastecimiento_dia');
            $abastecimiento -> save();
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
            $tipohora = AbastecimientoCombustible::find($id);
            $tipohora->delete();
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

        $consulta = "select id, nombres, apellidos, dni from conductor where
            deleted_at IS NULL AND
            apellidos LIKE UPPER('%".$query."%') OR dni LIKE '%".$query."%'";
        $res = DB::select($consulta);
        
        return response() -> json($res);
    }

    //PETICION GET QUE DEVUELVE TODOS LOS DATOS EQUIPO
    public function searchAutocompleteEquipo($query){

        $consulta = "select id, codigo, descripcion from equipo where
            deleted_at IS NULL AND
            codigo LIKE '%".$query."%' OR descripcion LIKE '%".$query."%'";
        $res = DB::select($consulta);
        
        return response() -> json($res);
    }
}

