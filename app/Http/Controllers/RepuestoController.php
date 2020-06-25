<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Repuesto;
use App\Unidad;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;

class RepuestoController extends Controller
{
    protected $folderview      = 'app.repuestos';
    protected $tituloAdmin     = 'Repuestos';
    protected $tituloRegistrar = 'Registrar repuesto';
    protected $tituloModificar = 'Modificar repuesto';
    protected $tituloEliminar  = 'Eliminar repuesto';
    protected $rutas           = array('create' => 'repuestos.create', 
            'edit'   => 'repuestos.edit', 
            'delete' => 'repuestos.eliminar',
            'search' => 'repuestos.buscar',
            'index'  => 'repuestos.index',
    );

         /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Repuesto';
        $filter           = Libreria::getParam($request->input('filter'));
        $unidad           = $request->input('unidad');
        $resultado        = Repuesto::getFilter($filter, $unidad);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
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

    public function index()
    {
        $entidad          = 'Repuesto';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $arrUnidades      = Unidad::getAll();
        $cboUnidades = array('all' => 'TODOS');
        foreach($arrUnidades as $k=>$v){
            $cboUnidades += array($v->id=>$v->descripcion);
        }
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'cboUnidades', 'ruta'));
    }

    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'Repuesto';
        $repuesto = null;
        $formData = array('repuestos.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        $arrUnidades = Unidad::getAll();
        $cboUnidades = array('' => 'Seleccione');
        foreach($arrUnidades as $k=>$v){
            $cboUnidades += array($v->id=>$v->descripcion);
        }
        return view($this->folderview.'.mant')->with(compact('repuesto', 'formData', 'entidad', 'boton', 'cboUnidades', 'listar'));
    }

    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array(
            'codigo' => 'required|integer|digits:7',
            'descripcion' => 'required|max:100',
            'unidad_id' => 'required'
        );
        $mensajes = array(
            'codigo.required' => 'Debe ingresar un código',
            'codigo.integer' => 'Código inválido',
            'codigo.digits' => 'El código debe tener 7 cifras',
            'descripcion.required' => 'Debe ingresar una descripcion',
            'unidad_id.required' => 'Debe seleccionar una unidad'
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $repuesto = new Repuesto();
            $repuesto->codigo= strtoupper($request->input('codigo'));
            $repuesto->descripcion= strtoupper($request->input('descripcion'));
            $repuesto->unidad_id= strtoupper($request->input('unidad_id'));
            $repuesto->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'repuesto');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $repuesto = Repuesto::find($id);
        $entidad  = 'Repuesto';
        $formData = array('repuestos.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $arrUnidades = Unidad::getAll();
        $cboUnidades = array('' => 'Seleccione');
        foreach($arrUnidades as $k=>$v){
            $cboUnidades += array($v->id=>$v->descripcion);
        }
        return view($this->folderview.'.mant')->with(compact('repuesto', 'formData', 'entidad', 'boton', 'cboUnidades', 'listar'));
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'repuesto');
        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'codigo' => 'required|integer|digits:7',
            'descripcion' => 'required|max:100',
            'unidad_id' => 'required'
        );
        $mensajes = array(
            'codigo.required' => 'Debe ingresar un código',
            'codigo.integer' => 'Código inválido',
            'codigo.digits' => 'El código debe tener 7 cifras',
            'descripcion.required' => 'Debe ingresar una descripcion',
            'unidad_id.required' => 'Debe seleccionar una unidad'
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request, $id){
            $repuesto = Repuesto::find($id);
            $repuesto->codigo= strtoupper($request->input('codigo'));
            $repuesto->descripcion= strtoupper($request->input('descripcion'));
            $repuesto->unidad_id= strtoupper($request->input('unidad_id'));
            $repuesto->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'repuesto');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $brand = Repuesto::find($id);
            $brand->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'repuesto');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje=true;
        $modelo   = Repuesto::find($id);
        $entidad  = 'Repuesto';
        $formData = array('route' => array('repuestos.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }
}
