<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Conductor;
use App\Contratista;
use App\Concesionaria;
use App\Conductorconcesionaria;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;

class ConductorController extends Controller
{
    protected $folderview      = 'app.conductores';
    protected $tituloAdmin     = 'Conductores';
    protected $tituloRegistrar = 'Registrar conductor';
    protected $tituloModificar = 'Modificar conductor';
    protected $tituloEliminar  = 'Eliminar conductor';
    protected $tituloActivar  = 'Activar conductor';
    protected $rutas           = array('create' => 'conductores.create', 
            'edit'   => 'conductores.edit', 
            'delete' => 'conductores.eliminar',
            'activar' => 'conductores.activar',
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

        $estado           = $request->input('estado');
        $categoria_id        = $request->input('categoria_id');
        $contratista      = $request->input('contratista');
        $resultado        = Conductor::getFilter($estado , $filter, $categoria_id, $contratista);
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'titulo_activar', 'ruta'));
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
            'licencia_letra' => 'required|alpha',
            'categoria' => 'required',
            'fechavencimiento' => 'required',
            'contratista_id' => 'required',
        );
        $mensajes = array(
            'dni.required' => 'Debe ingresar un DNI',
            'dni.integer' => 'DNI inválido',
            'dni.digits' => 'DNI debe tener 8 cifras',
            'licencia_letra.required' => 'Licencia incompleta',
            'licencia_letra.alpha' => 'Licencia inválida',
            'categoria.required' => 'Seleccione categoría',
            'fechavencimiento.required' => 'Seleccione fecha de vencimiento',
            'contratista_id.required' => 'Seleccione contratista',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $concesionariaAct = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
                                ->join('users','users.id','=','userconcesionaria.user_id')
                                ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
                                ->select('concesionaria.id','concesionaria.razonsocial')->first();
            $idConcAct = $concesionariaAct->id;

            //Busco al conductor
            $conductorBuscado = Conductor::where('dni', $request->input('dni'))->first();
            if($conductorBuscado == null) {
                $conductor = new Conductor();
                $conductor->dni= $request->input('dni');
                $conductor->apellidos= mb_strtoupper($request->input('apellidos'), 'utf-8');
                $conductor->nombres= mb_strtoupper($request->input('nombres'), 'utf-8');
                $conductor->licencia= mb_strtoupper($request->input('licencia_letra'), 'utf-8') . '-' . $request->input('dni') ;
                $conductor->categoria= $request->input('categoria');
                $conductor->fechavencimiento= mb_strtoupper($request->input('fechavencimiento'), 'utf-8');
                $conductor->contratista_id= mb_strtoupper($request->input('contratista_id'), 'utf-8');
                $conductor->save();
    
                $conductorconcesionaria = new Conductorconcesionaria();
                $conductorconcesionaria->conductor_id = $conductor->id;
                $conductorconcesionaria->concesionaria_id = $idConcAct;
                $conductorconcesionaria->save();
            } else {
                $conductorconcesionaria = new Conductorconcesionaria();
                $conductorconcesionaria->conductor_id = $conductorBuscado->id;
                $conductorconcesionaria->concesionaria_id = $idConcAct;
                $conductorconcesionaria->save();
            }


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
            'licencia_letra' => 'required|alpha',
            'categoria' => 'required',
            'fechavencimiento' => 'required',
            'contratista_id' => 'required',
        );
        $mensajes = array(
            'dni.required' => 'Debe ingresar un DNI',
            'dni.integer' => 'DNI inválido',
            'dni.digits' => 'DNI debe tener 8 cifras',
            'licencia_letra.required' => 'Licencia incompleta',
            'licencia_letra.alpha' => 'Licencia inválida',
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
            $conductor->dni= $request->input('dni');
            $conductor->apellidos= mb_strtoupper($request->input('apellidos'), 'utf-8');
            $conductor->nombres= mb_strtoupper($request->input('nombres'), 'utf-8');
            $conductor->licencia= mb_strtoupper($request->input('licencia_letra'), 'utf-8') . '-' . $request->input('dni');
            $conductor->categoria= $request->input('categoria');
            $conductor->fechavencimiento= mb_strtoupper($request->input('fechavencimiento'), 'utf-8');
            $conductor->contratista_id= mb_strtoupper($request->input('contratista_id'), 'utf-8');
            $conductor->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'conductor');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje=true;
        $modelo   = Conductor::find($id);
        $entidad  = 'Conductor';
        $formData = array('route' => array('conductores.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }

    public function destroy($id)
    {
        $concesionariaAct = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
                                ->join('users','users.id','=','userconcesionaria.user_id')
                                ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
                                ->select('concesionaria.id','concesionaria.razonsocial')->first();
        $idConcAct = $concesionariaAct->id;

        $conductorBuscado = Conductor::where('conductor.id', $id)
                        ->join('conductorconcesionaria', 'conductorconcesionaria.conductor_id', '=', 'conductor.id')
                        ->where('conductorconcesionaria.concesionaria_id', $idConcAct)->first();

        if ($conductorBuscado == null) {
            $cadena = '<blockquote><p class="text-danger">Registro no existe en la base de datos. No manipular ID</p></blockquote>';
			$cadena .= '<button class="btn btn-warning btn-sm" id="btnCerrarexiste"><i class="fa fa-times fa-lg"></i> Cerrar</button>';
			$cadena .= "<script type=\"text/javascript\">
							$(document).ready(function() {
								$('#btnCerrarexiste').attr('onclick','cerrarModal(' + (contadorModal - 1) + ');').unbind('click');
							}); 
						</script>";
			return $cadena;
        }
        $error = DB::transaction(function() use($id, $idConcAct){
            $conductorconcesionaria = Conductorconcesionaria::where('conductor_id', $id)->where('concesionaria_id', $idConcAct)->first();
            $conductorconcesionaria->estado = false;
            $conductorconcesionaria->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function activar($id, $listarLuego){
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Conductor::find($id);
        $entidad  = 'Conductor';
        $formData = array('route' => array('conductores.reactivar', $id), 'method' => 'GET', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Activar';
        return view('app.confirmar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function reactivar($id){

        $concesionariaAct = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
                                ->join('users','users.id','=','userconcesionaria.user_id')
                                ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
                                ->select('concesionaria.id','concesionaria.razonsocial')->first();
        $idConcAct = $concesionariaAct->id;

        $conductorBuscado = Conductor::where('conductor.id', $id)
                        ->join('conductorconcesionaria', 'conductorconcesionaria.conductor_id', '=', 'conductor.id')
                        ->where('conductorconcesionaria.concesionaria_id', $idConcAct)->first();

        if ($conductorBuscado == null) {
            $cadena = '<blockquote><p class="text-danger">Registro no existe en la base de datos. No manipular ID</p></blockquote>';
			$cadena .= '<button class="btn btn-warning btn-sm" id="btnCerrarexiste"><i class="fa fa-times fa-lg"></i> Cerrar</button>';
			$cadena .= "<script type=\"text/javascript\">
							$(document).ready(function() {
								$('#btnCerrarexiste').attr('onclick','cerrarModal(' + (contadorModal - 1) + ');').unbind('click');
							}); 
						</script>";
			return $cadena;
        }
        $error = DB::transaction(function() use($id, $idConcAct){
            $conductorconcesionaria = Conductorconcesionaria::where('conductor_id', $id)->where('concesionaria_id', $idConcAct)->first();
            $conductorconcesionaria->estado = true;
            $conductorconcesionaria->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function existeConductor(Request $request) {
        $concesionariaAct = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
                                ->join('users','users.id','=','userconcesionaria.user_id')
                                ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
                                ->select('concesionaria.id','concesionaria.razonsocial')->first();
        $idConcAct = $concesionariaAct->id;

        return $res = Conductor::withTrashed()
                ->join('conductorconcesionaria', 'conductorconcesionaria.conductor_id', '=', 'conductor.id')
                ->where(function($subquery) use ($idConcAct) {
                    $subquery->where('conductorconcesionaria.concesionaria_id', $idConcAct);
                })
                ->where('dni', $request->dni)->get();
    }
}
