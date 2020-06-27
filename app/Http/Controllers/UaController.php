<?php

namespace App\Http\Controllers;

use App\Librerias\Libreria;
use App\Rules\SelectDifZero;
use App\Ua;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UaController extends Controller{
    protected $folderview      = 'app.ua';
    protected $tituloAdmin     = 'Administrar ua';
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
        $entidad          = 'Propietario';
        $nombre             = Libreria::getParam($request->input('descripcion'));
        $resultado        = Ua::where('descripcion', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();   
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fondos', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Responsable', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo de costo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Unidad', 'numero' => '1');
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
            'tipo' => 'required',
            'fondos' => 'required',
            'responsable' => 'required',
            'tipo_costo' => 'required',
            'unidad_id' => ['required', new SelectDifZero()],
        ];
        $mensajes = [
            'codigo.required' => 'Su código es requerido',
            'codigo.unique' => 'Su código proporcionado ya existe, especifique otro',
            'descripcion.required' => 'Su descripcion es requerida',
            'tipo.required' => 'Su tipo es requerido',
            'fondos.required' => 'Sus fondos son requeridos',
            'responsable.required' => 'Su responsable es requerido',
            'tipo_costo.required' => 'Su tipo de costo es requerido',
            'unidad_id.required' => 'Su unidad es requerida'
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
            $ua -> tipo = $request -> input('tipo');
            $ua -> fondos = $request -> input('fondos');
            $ua -> responsable = $request -> input('responsable');
            $ua -> tipo_costo = $request -> input('tipo_costo');
            $ua -> unidad_id = $request -> input('unidad_id');
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
            'tipo' => 'required',
            'fondos' => 'required',
            'responsable' => 'required',
            'tipo_costo' => 'required',
            'unidad_id' => ['required', new SelectDifZero()],
        ];
        $mensajes = [
            'codigo.required' => 'Su código es requerido',
            'codigo.unique' => 'Su código proporcionado ya existe, especifique otro',
            'descripcion.required' => 'Su descripcion es requerida',
            'tipo.required' => 'Su tipo es requerido',
            'fondos.required' => 'Sus fondos son requeridos',
            'responsable.required' => 'Su responsable es requerido',
            'tipo_costo.required' => 'Su tipo de costo es requerido',
            'unidad_id.required' => 'Su unidad es requerida'
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
            $ua -> tipo = $request -> input('tipo');
            $ua -> fondos = $request -> input('fondos');
            $ua -> responsable = $request -> input('responsable');
            $ua -> tipo_costo = $request -> input('tipo_costo');
            $ua -> unidad_id = $request -> input('unidad_id');
            $ua -> save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego){

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
}
