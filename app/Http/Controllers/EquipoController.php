<?php

namespace App\Http\Controllers;

use Validator;
use App\Equipo;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class EquipoController extends Controller
{
    protected $folderview      = 'app.equipo';
    protected $tituloAdmin     = 'Opcion equipo';
    protected $tituloRegistrar = 'Registrar equipo';
    protected $tituloModificar = 'Modificar equipo';
    protected $tituloEliminar  = 'Eliminar equipo';
    protected $rutas           = array('create' => 'equipo.create', 
            'edit'   => 'equipo.edit', 
            'delete' => 'equipo.eliminar',
            'search' => 'equipo.buscar',
            'index'  => 'equipo.index',
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
        $entidad          = 'Equipo';
        $descripcion      = Libreria::getParam($request->input('descripcion'));
        
        $filtro           = array();
        $filtro[]         = ['descripcion', 'LIKE', '%'.strtoupper($descripcion).'%'];


        $resultado        = Equipo::where($filtro)->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Modelo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Placa', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Motor', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Año de Fbr', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Marca', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Contratista', 'numero' => '1');
        $cabecera[]       = array('valor' => 'UA', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Area', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Asientos', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Chasis', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Carrocería', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Color', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Vencimiento SOAT', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Vencimiento GPS', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Vencimiento RTV', 'numero' => '1');
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
        $entidad          = 'Equipo';
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
        $entidad  = 'Equipo';
        $equipo = null;

//        $marcas = Marca::orderBy('descripcion','asc')->get();
        $cboMarca = array();
        $cboMarca += array('0' => 'Selecione marca');
//        foreach($marcas as $k=>$v){
//            $cboMarca += array($v->id=>$v->descripcion);
//        }

//        $areas = Area::orderBy('descripcion','asc')->get();
        $cboArea = array();
        $cboArea += array('0' => 'Selecione área');
//        foreach($areas as $k=>$v){
//            $cboArea += array($v->id=>$v->descripcion);
//        }


//        $contratistas = Contratista::orderBy('descripcion','asc')->get();
        $cboContratista = array();
        $cboContratista += array('0' => 'Selecione contratista');
//        foreach($contratistas as $k=>$v){
//            $cboContratista += array($v->id=>$v->razonsocial);
//        }



        $formData = array('equipo.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('equipo', 'formData', 'entidad', 'boton', 'listar', 'cboMarca', 'cboArea', 'cboContratista'));
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
        $reglas     = array('codigo' => 'required|max:20',
    						'descripcion' => 'required|max:30',
    						'modelo' => 'required|max:25',
    						'marca_id' => 'required',
    						'anio' => 'required',
    						'contratista_id' => 'required',
    						'ua_id' => 'required',
    						'fechavencimientosoat' => 'required',
    						'fechavencimientogps' => 'required',
    						'fechavencimientortv' => 'required');
        $mensajes = array(
        	'codigo.required'         		  => 'Debe ingresar un código',
            'descripcion.required' 		      => 'Debe ingresar una descripcion',
            'modelo.required'         		  => 'Debe ingresar el modelo',
            'marca_id.required'  	  		  => 'Debe ingresar una descripcion',
            'anio.required'    				  => 'Debe ingresar la fecha de fabricación',
            'contratista_id.required'   	  => 'Debe ingresar la fecha de fabricación',
            'ua_id.required'    			  => 'Debe ingresar la fecha de fabricación',
            'fechavencimientosoat.required'   => 'Debe ingresar la fecha de vencimiento de SOAT',
            'fechavencimientogps.required'    => 'Debe ingresar la fecha de vencimiento de GPS',
            'fechavencimientortv.required'    => 'Debe ingresar la fecha de vencimiento de RTV'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $equipo = new Equipo();
            $equipo->codigo 	 		  = strtoupper($request->input('codigo'));
            $equipo->descripcion 		  = strtoupper($request->input('descripcion'));
            $equipo->modelo 			  = strtoupper($request->input('modelo'));
            $equipo->marca_id 			  = $request->input('marca_id');
            $equipo->anio 				  = $request->input('anio');
            $equipo->contratista_id 	  = $request->input('contratista_id');
            $equipo->ua_id 				  = $request->input('ua_id');
            $equipo->fechavencimientosoat = $request->input('fechavencimientosoat');
            $equipo->fechavencimientogps  = $request->input('fechavencimientogps');
            $equipo->fechavencimientortv  = $request->input('fechavencimientortv');
            $equipo->save();
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
        $existe = Libreria::verificarExistencia($id, 'equipo');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $equipo = Equipo::find($id);

//        $marcas = Marca::orderBy('descripcion','asc')->get();
        $cboMarca = array();
        $cboMarca += array('0' => 'Selecione marca');
//        foreach($marcas as $k=>$v){
//            $cboMarca += array($v->id=>$v->descripcion);
//        }

//        $areas = Area::orderBy('descripcion','asc')->get();
        $cboArea = array();
        $cboArea += array('0' => 'Selecione área');
//        foreach($areas as $k=>$v){
//            $cboArea += array($v->id=>$v->descripcion);
//        }


//        $contratistas = Contratista::orderBy('descripcion','asc')->get();
        $cboContratista = array();
        $cboContratista += array('0' => 'Selecione contratista');
//        foreach($contratistas as $k=>$v){
//            $cboContratista += array($v->id=>$v->razonsocial);
//        }

        $entidad  = 'Equipo';
        $formData = array('equipo.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('equipo', 'formData', 'entidad', 'boton', 'listar', 'cboMarca', 'cboArea', 'cboContratista'));
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
        $existe = Libreria::verificarExistencia($id, 'equipo');
        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array('codigo' => 'required|max:20',
    						'descripcion' => 'required|max:30',
    						'modelo' => 'required|max:25',
    						'marca_id' => 'required',
    						'anio' => 'required',
    						'contratista_id' => 'required',
    						'ua_id' => 'required',
    						'fechavencimientosoat' => 'required',
    						'fechavencimientogps' => 'required',
    						'fechavencimientortv' => 'required');
        $mensajes = array(
            'codigo.required'         		  => 'Debe ingresar un código',
            'descripcion.required' 		      => 'Debe ingresar una descripcion',
            'modelo.required'         		  => 'Debe ingresar el modelo',
            'marca_id.required'  	  		  => 'Debe ingresar una descripcion',
            'anio.required'    				  => 'Debe ingresar la fecha de fabricación',
            'fechavencimientosoat.required'   => 'Debe ingresar la fecha de vencimiento de SOAT',
            'fechavencimientogps.required'    => 'Debe ingresar la fecha de vencimiento de GPS',
            'fechavencimientortv.required'    => 'Debe ingresar la fecha de vencimiento de RTV'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $equipo = Equipo::find($id);
            $equipo->codigo 	 		  = strtoupper($request->input('codigo'));
            $equipo->descripcion 		  = strtoupper($request->input('descripcion'));
            $equipo->modelo 			  = strtoupper($request->input('modelo'));
            $equipo->marca_id 			  = $request->input('marca_id');
            $equipo->anio 				  = $request->input('anio');
            $equipo->contratista_id 	  = $request->input('contratista_id');
            $equipo->ua_id 				  = $request->input('ua_id');
            $equipo->fechavencimientosoat = $request->input('fechavencimientosoat');
            $equipo->fechavencimientogps  = $request->input('fechavencimientogps');
            $equipo->fechavencimientortv  = $request->input('fechavencimientortv');
            $equipo->save();
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
        $existe = Libreria::verificarExistencia($id, 'equipo');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $equipo = Equipo::find($id);
            $equipo->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'equipo');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje = true;
        $modelo   = Equipo::find($id);
        $entidad  = 'Equipo';
        $formData = array('route' => array('equipo.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }
}
