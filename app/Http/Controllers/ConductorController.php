<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Conductor;
use App\Contratista;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;

class ConductorController extends Controller
{
    protected $folderview      = 'app.conductores';
    protected $tituloAdmin     = 'Conductores';
    protected $tituloRegistrar = 'Registrar conductor';
    protected $tituloModificar = 'Modificar conductor';
    protected $tituloEliminar  = 'Eliminar conductor';
    protected $rutas           = array('create' => 'conductores.create', 
            'edit'   => 'conductores.edit', 
            'delete' => 'conductores.eliminar',
            'search' => 'conductores.buscar',
            'index'  => 'conductores.index',
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request) {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Conductor';
        $filter           = Libreria::getParam($request->input('filter'));

        $categoria        = $request->input('categoria');
        $contratista_id      = $request->input('contratista_id');
        $resultado        = Conductor::getFilter($filter, $categoria, $contratista_id);
        $lista            = $resultado->get();

        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Apellidos y nombres', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Categoria', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Licencia', 'numero' => '1');
        $cabecera[]       = array('valor' => 'F.Vencimiento', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Contratista', 'numero' => '1');
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

    public function index() {
        $entidad          = 'Conductor';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;

        $arrCategorias    = array(
            'all' => 'TODOS',
            'A-I' => 'A-I',
            'A-IIa' => 'A-IIa',
            'A-IIb' => 'A-IIb',
            'A-IIIa' => 'A-IIIa',
            'A-IIIb' => 'A-IIIb',
            'A-IIIc' => 'A-IIIc',
        );

        $arrContratista      = Contratista::getAll();
        $cboContratista = array('all' => 'TODOS');
        foreach($arrContratista as $k=>$v){
            $cboContratista += array($v->id=>$v->razonsocial);
        }
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'arrCategorias', 'cboContratista', 'ruta'));
    }

    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'Conductor';
        $conductor = null;
        $licenciaLetra = null;
        $formData = array('conductores.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        $arrCategorias    = array(
            '' => 'Seleccione Categoría',
            'A-I' => 'A-I',
            'A-IIa' => 'A-IIa',
            'A-IIb' => 'A-IIb',
            'A-IIIa' => 'A-IIIa',
            'A-IIIb' => 'A-IIIb',
            'A-IIIc' => 'A-IIIc',
        );
        $arrContratista      = Contratista::getAll();
        $cboContratista = array('' => 'Seleccione');
        foreach($arrContratista as $k=>$v){
            $cboContratista += array($v->id=>$v->razonsocial);
        }
        return view($this->folderview.'.mant')->with(compact('conductor', 'formData', 'entidad', 'boton', 'licenciaLetra', 'arrCategorias', 'cboContratista', 'listar'));
    }

    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array(
            'dni' => 'required|integer|digits:8',
            'licencia_letra' => 'required',
            'categoria' => 'required',
            'fechavencimiento' => 'required',
            'contratista_id' => 'required',
        );
        $mensajes = array(
            'dni.required' => 'Debe ingresar un DNI',
            'dni.integer' => 'DNI inválido',
            'dni.digits' => 'DNI debe tener 8 cifras',
            'licencia_letra.required' => 'Licencia incompleta',
            'categoria.required' => 'Seleccione categoría',
            'fechavencimiento.required' => 'Seleccione fecha de vencimiento',
            'contratista_id.required' => 'Seleccione contratista',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $conductor = new Conductor();
            $conductor->dni= strtoupper($request->input('dni'));
            $conductor->apellidos= strtoupper($request->input('apellidos'));
            $conductor->nombres= strtoupper($request->input('nombres'));
            $conductor->licencia= strtoupper($request->input('licencia_letra')) . '-' . strtoupper($request->input('dni'));
            $conductor->categoria= $request->input('categoria');
            $conductor->fechavencimiento= strtoupper($request->input('fechavencimiento'));
            $conductor->contratista_id= strtoupper($request->input('contratista_id'));
            $conductor->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'conductor');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $conductor = Conductor::find($id);
        $licenciaLetra = $conductor->licencia[0];
        $entidad  = 'Conductor';
        $formData = array('conductores.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $arrCategorias    = array(
            '' => 'Seleccione Categoría',
            'A-I' => 'A-I',
            'A-IIa' => 'A-IIa',
            'A-IIb' => 'A-IIb',
            'A-IIIa' => 'A-IIIa',
            'A-IIIb' => 'A-IIIb',
            'A-IIIc' => 'A-IIIc',
        );
        $arrContratista      = Contratista::getAll();
        $cboContratista = array('' => 'Seleccione');
        foreach($arrContratista as $k=>$v){
            $cboContratista += array($v->id=>$v->razonsocial);
        }
        return view($this->folderview.'.mant')->with(compact('conductor', 'formData', 'entidad', 'boton', 'licenciaLetra', 'arrCategorias', 'cboContratista', 'listar'));
    }

    public function update(Request $request, $id) {
        $existe = Libreria::verificarExistencia($id, 'conductor');
        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'dni' => 'required|integer|digits:8',
            'licencia_letra' => 'required',
            'categoria' => 'required',
            'fechavencimiento' => 'required',
            'contratista_id' => 'required',
        );
        $mensajes = array(
            'dni.required' => 'Debe ingresar un DNI',
            'dni.integer' => 'DNI inválido',
            'dni.digits' => 'DNI debe tener 8 cifras',
            'licencia_letra.required' => 'Licencia incompleta',
            'categoria.required' => 'Seleccione categoría',
            'fechavencimiento.required' => 'Seleccione fecha de vencimiento',
            'contratista_id.required' => 'Seleccione contratista',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request, $id){
            $conductor = Conductor::find($id);
            $conductor->dni= strtoupper($request->input('dni'));
            $conductor->apellidos= strtoupper($request->input('apellidos'));
            $conductor->nombres= strtoupper($request->input('nombres'));
            $conductor->licencia= strtoupper($request->input('licencia_letra')) . '-' . strtoupper($request->input('dni'));
            $conductor->categoria= $request->input('categoria');
            $conductor->fechavencimiento= strtoupper($request->input('fechavencimiento'));
            $conductor->contratista_id= strtoupper($request->input('contratista_id'));
            $conductor->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function existeConductor(Request $request) {
        return $res = Conductor::where('dni', $request->dni)->get();
    }
}
