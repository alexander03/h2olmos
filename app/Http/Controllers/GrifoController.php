<?php

namespace App\Http\Controllers;

use Validator;
use App\Grifo;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GrifoController extends Controller
{
   
    protected $folderview      = 'app.grifo';
    protected $tituloAdmin     = 'Grifo';
    protected $tituloRegistrar = 'Registrar grifo';
    protected $tituloModificar = 'Modificar grifo';
    protected $tituloEliminar  = 'Eliminar grifo';
    protected $rutas           = array('create' => 'grifo.create', 
            'edit'   => 'grifo.edit', 
            'delete' => 'grifo.eliminar',
            'search' => 'grifo.buscar',
            'index'  => 'grifo.index',
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
        $entidad          = 'Grifo';
        $descripcion      = Libreria::getParam($request->input('descripcion'));
        
        $filtro           = array();
        $filtro[]         = ['descripcion', 'LIKE', '%'.strtoupper($descripcion).'%'];


        $resultado        = Grifo::where($filtro)->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ubicación', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Lugar de abastecimiento', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Contacto', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Correo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Teléfono', 'numero' => '1');
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidad          = 'Grifo';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'Grifo';
        $grifo = null;
        $formData = array('grifo.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('grifo', 'formData', 'entidad', 'boton', 'listar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array(
            'descripcion' => 'required|max:25',
            'ubicacion' => 'required|max:25',
            'abastecimiento' => 'required|max:25',
            'contacto' => 'required|max:30',
            'telefono' => 'required|max:9',
            'correo' => 'required|max:25'
        );
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción',
            'descripcion.max'              => 'La descripción supera los 25 caracteres',
            'ubicacion.required'           => 'Debe ingresar una ubicacion',
            'ubicacion.max'                => 'La ubicacion supera los 25 caracteres',
            'abastecimiento.required'      => 'Debe ingresar una abastecimiento',
            'abastecimiento.max'           => 'La abastecimiento supera los 25 caracteres',
            'contacto.required'            => 'Debe ingresar una contacto',
            'contacto.max'                 => 'La contacto supera los 30 caracteres',
            'telefono.required'            => 'Debe ingresar una telefono',
            'telefono.max'                 => 'La telefono supera los 9 caracteres',
            'correo.required'              => 'Debe ingresar una correo',
            'correo.max'                   => 'La correo supera los 25 caracteres'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $grifo = new Grifo();
            $grifo->descripcion = strtoupper($request->input('descripcion'));
            $grifo->ubicacion = strtoupper($request->input('ubicacion'));
            $grifo->abastecimiento = strtoupper($request->input('abastecimiento'));
            $grifo->contacto = strtoupper($request->input('contacto'));
            $grifo->telefono = $request->input('telefono');
            $grifo->correo = $request->input('correo');
            $grifo->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'grifo');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $grifo = Grifo::find($id);
        $entidad  = 'Grifo';
        $formData = array('grifo.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('grifo', 'formData', 'entidad', 'boton', 'listar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'grifo');
        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'descripcion' => 'required|max:25',
            'ubicacion' => 'required|max:25',
            'abastecimiento' => 'required|max:25',
            'contacto' => 'required|max:30',
            'telefono' => 'required|max:9',
            'correo' => 'required|max:25'
        );
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción',
            'descripcion.max'              => 'La descripción supera los 25 caracteres',
            'ubicacion.required'           => 'Debe ingresar una ubicacion',
            'ubicacion.max'                => 'La ubicacion supera los 25 caracteres',
            'abastecimiento.required'      => 'Debe ingresar una abastecimiento',
            'abastecimiento.max'           => 'La abastecimiento supera los 25 caracteres',
            'contacto.required'            => 'Debe ingresar una contacto',
            'contacto.max'                 => 'La contacto supera los 30 caracteres',
            'telefono.required'            => 'Debe ingresar una telefono',
            'telefono.max'                 => 'La telefono supera los 9 caracteres',
            'correo.required'              => 'Debe ingresar una correo',
            'correo.max'                   => 'La correo supera los 25 caracteres'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $grifo = Grifo::find($id);
            $grifo->descripcion = strtoupper($request->input('descripcion'));
            $grifo->ubicacion = strtoupper($request->input('ubicacion'));
            $grifo->abastecimiento = strtoupper($request->input('abastecimiento'));
            $grifo->contacto = strtoupper($request->input('contacto'));
            $grifo->telefono = $request->input('telefono');
            $grifo->correo = $request->input('correo');
            $grifo->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'grifo');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $grifo = Grifo::find($id);
            $grifo->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'grifo');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje = true;
        $modelo   = Grifo::find($id);
        $entidad  = 'Grifo';
        $formData = array('route' => array('grifo.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }

}
