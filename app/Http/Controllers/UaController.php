<?php

namespace App\Http\Controllers;

use App\Concesionaria;
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
use DateTime;
use Exception;

class UaController extends Controller{
    protected $folderview      = 'app.ua';
    protected $tituloAdmin     = 'Ua';
    protected $tituloRegistrar = 'Registrar ua';
    protected $tituloModificar = 'Modificar ua';
    protected $tituloEliminar  = 'Eliminar ua';
    protected $rutas           = array('create' => 'ua.create', 
            'edit'   => 'ua.edit', 
            'delete' => 'ua.eliminar',
            'search' => 'ua.buscar',
            'index'  => 'ua.index',
    );

    public function buscar(Request $request){

        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Ua';
        $nombre           = Libreria::getParam($request->input('descripcion'));
        $codigo           = Libreria::getParam($request -> input('codigo'));
        $resultado        = Ua::where([
                [ 'descripcion', 'LIKE', '%'.strtoupper($nombre).'%' ],
                [ 'codigo', 'LIKE', '%'.$codigo.'%' ],
                [ 'concesionaria_id', $this -> getConsecionariaActual() ] 
                ])->orderBy('descripcion', 'ASC');
        $lista            = $resultado -> get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ua Padre', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Habilitada', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha de inicio', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha de fin', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');
        
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $ruta             = $this->rutas;

        $uaLst =  Ua::all();
        foreach($uaLst as $uaDB){
            $hoy = new DateTime(date("Y-m-d")); 
            $fechaFin = new DateTime($uaDB -> fecha_fin);
            if($hoy > $fechaFin){          
               $uaNew = new Ua();
               $uaNew = $uaDB;
               $uaNew -> habilitada = false;
               $uaNew -> save();
           }
        }

        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista = $resultado -> paginate($filas);
            $request->replace(array('page' => $paginaactual));

            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }
    

    public function index(){
        
        $entidad          = 'Ua';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    public function create(Request $request, Unidad $unidadModel){

        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'Ua';
        $ua = null;
        $formData = array('ua.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 

        $unidadList = $unidadModel -> all();
        return view($this->folderview.'.mant')->with(compact('ua', 'formData', 'entidad', 'boton', 'listar', 'unidadList'));
    }

    public function store(Request $request){

        $reglas     = [
            'codigo' => 'required|unique:ua',
            'descripcion' => 'required',
            'habilitada' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'nullable|after_or_equal:fecha_inicio',
            'ua_padre_id' => [ new SearchUaPadre() ]
        ];
        $mensajes = [
            'codigo.required' => 'Su código es requerido',
            'codigo.unique' => 'Su código proporcionado ya existe, especifique otro',
            'descripcion.required' => 'Su descripcion es requerida',
            'habilitada.required' => 'El estado de la ua es requerida',
            'fecha_inicio.required' => 'Su fecha de inicio es requerida',
            'fecha_fin.after_or_equal' => 'Su fecha de fin no puede ser menor que la de inicio'
		];
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $listar     = Libreria::getParam($request->input('listar'), 'NO');
    
        $error = DB::transaction(function() use($request){
            $ua = new Ua();
            $ua -> codigo = $request -> input('codigo');
            $ua -> descripcion = strtoupper($request->input('descripcion'));
            $ua -> habilitada = $request -> input('habilitada');
            $ua -> concesionaria_id = $this -> getConsecionariaActual();
            $ua -> fecha_inicio = $request -> input('fecha_inicio');
            $ua -> fecha_fin = $request -> input('fecha_fin');
            //BUSCAR
            if($request -> input('ua_padre_id')){
                $uaDB =  Ua::where('codigo', $request -> input('ua_padre_id')) -> get();
                $ua -> ua_padre_id = (!( $uaDB -> isEmpty() )) ? $uaDB[0] -> id : null;
            }
            $ua -> save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function show($id){}

    public function edit($id, Request $request, Unidad $unidadModel){

        $existe = Libreria::verificarExistencia($id, 'ua');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $ua = Ua::find($id);
        $entidad  = 'Ua';
        $formData = array('ua.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';

        $unidadList = $unidadModel -> all();
        return view($this->folderview.'.mant')->with(compact('ua', 'formData', 'entidad', 'boton', 'listar', 'unidadList'));
    }

    public function update(Request $request, $id){

        $reglas     = [
            'codigo' => 'required|unique:ua,codigo,'.$id,
            'descripcion' => 'required',
            'habilitada' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'nullable|after_or_equal:fecha_inicio',
            'ua_padre_id' => [ new SearchUaPadre() ]
        ];
        $mensajes = [
            'codigo.required' => 'Su código es requerido',
            'codigo.unique' => 'Su código proporcionado ya existe, especifique otro',
            'descripcion.required' => 'Su descripcion es requerida',
            'habilitada.required' => 'El estado de la ua es requerida',
            'fecha_inicio.required' => 'Su fecha de inicio es requerida',
            'fecha_fin.after_or_equal' => 'Su fecha de fin no puede ser menor que la de inicio'
        ];

        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $existe = Libreria::verificarExistencia($id, 'ua');
        if ($existe !== true) {
            return $existe;
        }

        $error = DB::transaction(function() use($request, $id){
            $ua = Ua::find($id);
            $ua -> codigo = $request -> input('codigo');
            $ua -> descripcion = strtoupper($request->input('descripcion'));
            $ua -> habilitada = $request -> input('habilitada');
            $ua -> fecha_inicio = $request -> input('fecha_inicio');
            $ua -> fecha_fin = $request -> input('fecha_fin');
            //BUSCAR
            if($request -> input('ua_padre_id')){
                $uaDB =  Ua::where('codigo', $request -> input('ua_padre_id')) -> get();
                $ua -> ua_padre_id = (!( $uaDB -> isEmpty() )) ? $uaDB[0] -> id : null;
            }
            $ua -> save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego, Ua $uaModel){

        $existe = Libreria::verificarExistencia($id, 'ua');
        if ($existe !== true) {
            return $existe;
        }

        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje = true;
        $modelo   = Ua::find($id);
        $entidad  = 'Ua';
        $formData = array('route' => array('ua.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }

    public function destroy($id){

        $existe = Libreria::verificarExistencia($id, 'ua');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $ua = Ua::find($id);
            $ua->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    //PETICION GET QUE DEVUELVE TODOS LOS DATOS
    public function searchAutocomplete($query){
        // 
        $consulta = "SELECT id, codigo, descripcion, CONCAT(codigo, ' - ', descripcion) AS 'search'  
            FROM ua WHERE
            deleted_at IS NULL AND
            habilitada IS TRUE AND
            concesionaria_id = {$this -> getConsecionariaActual()} AND
            (codigo LIKE '%".$query."%' OR descripcion LIKE '%".$query."%')";
        $res = DB::select($consulta);
        
        return response() -> json($res);
    }

    //EXPORTAR E IMPORTAR EXCEL
    public function importExcel(Request $request){

        try{
            $file = $request -> file('ua-excel');
            Excel::import(new UaImport, $file);
            $res = ['ok' => true];

            return response() -> json($res);

        }catch(Exception $ex){
            $res = ['ok' => false, 'ex' => $ex];
       
            return response() -> json($res);
        }
    }

    public function exportExcel(){

        return Excel::download(new UaExport, 'ua-list.xlsx');
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

