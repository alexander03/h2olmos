<?php

namespace App\Http\Controllers;

use Validator;
use App\Equipo;
use App\Area;
use App\Tipohora;
use App\Ua;
use App\Controldiario;
use App\Contratista;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use App\Rules\SearchUaPadre;
use App\Rules\SearchEquipo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ControlDiarioController extends Controller
{
    protected $folderview      = 'app.controldiario';
    protected $tituloAdmin     = 'Control diario de equipos';
    protected $tituloRegistrar = 'Registrar controldiario';
    protected $tituloModificar = 'Modificar controldiario';
    protected $tituloEliminar  = 'Eliminar controldiario';
    protected $rutas           = array('create' => 'controldiario.create', 
            'edit'   => 'controldiario.edit', 
            'delete' => 'controldiario.eliminar',
            'search' => 'controldiario.buscar',
            'index'  => 'controldiario.index',
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
        $entidad          = 'Controldiario';

        $ua     	  = Libreria::getParam($request->input('ua'));
        $equipo_ua      = Libreria::getParam($request->input('equipo_ua'));
  		$descripcion = Libreria::getParam($request->input('descripcion'));

        $filtro           = array();
        $filtro[]         = ['codigo', 'LIKE', '%'.strtoupper($ua).'%'];
        $filtro[]         = ['codigo', 'LIKE', '%'.strtoupper($equipo_ua).'%'];
        $filtro[]         = ['descripcion', 'LIKE', '%'.strtoupper($descripcion).'%'];
/*
        if($ua_id != 0 ){
			$filtro[]         = ['ua_id', '=', $ua_id];        	
        }
*/
        $resultado        = Controldiario::whereHas('ua', function($query) use($filtro){
        									$query->where($filtro[0][0],$filtro[0][1],$filtro[0][2]);
        								})->orWhereHas('equipo', function($query) use($filtro){
        									$query->where($filtro[1][0],$filtro[1][1],$filtro[1][2])
        									->orWhere($filtro[2][0],$filtro[2][1],$filtro[2][2]);
        								})->orderBy('fecha', 'ASC');

        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ua equipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Desc equipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Contratista', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ua', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Parada', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Horas', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo de hora', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Turno', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Viajes', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Inicio', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Acceso', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ua origen', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Desc origen', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Destino', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ua Destino', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Desc Destino', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Material', 'numero' => '1');
		$cabecera[]       = array('valor' => 'Observaciones', 'numero' => '1');
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
        $entidad          = 'Controldiario';
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
        $entidad  = 'Controldiario';
        $controldiario = null;

/*
        $uas = Ua::orderBy('descripcion','asc')->get();
        $cboUa = array();
        $cboUa += array('0' => 'Selecione UA');
//        $cboUa += array('1' => '12345ua');
        foreach($uas as $k=>$v){
            $cboUa += array($v->id=>$v->descripcion . '-' .$v->codigo );
        }
*/
        $thoras = Tipohora::orderBy('codigo','asc')->get();
        $cboThoras = array();
        $cboThoras += array('0' => 'Horas de trabajo');
        foreach($thoras as $k=>$v){
            $cboThoras += array($v->id => $v->descripcion . ' - ' .$v->codigo);
        }

        $cboTurnos = array();
        $cboTurnos += array(0 => 'Diurno');
        $cboTurnos += array(1 => 'Nocturno');

        $formData = array('controldiario.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('controldiario', 'cboTurnos' ,'formData', 'entidad', 'boton', 'listar','cboThoras'));
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
        $reglas     = array('equipo_id' 			=> [new SearchEquipo()],
    						'tipohora_id' 			=> 'numeric',
                            'turno'                 => 'boolean',
    						'hora_inicio'			=> 'required',
    						'hora_fin'				=> 'required|after:hora_inicio',
    						'fecha'  				=> 'date'
                        );
        $mensajes = array(
            'tipohora_id.numeric'  	  		  => 'Tipo de hora inválido',
            'turno.boolean'                   => 'Ingrese un turno válido',
            'hora_inicio.required'			  => 'Debe una hora de inicio válida',
            'hora_fin.required'    			  => 'Debe una hora de finalzación válida',
            'hora_fin.after'    			  => 'Debe una hora de finalzación es menor que la hora de inicio',
            'fecha.date'					  => 'Debe ingresar una fecha válida'
            );


        $validacion = Validator::make($request->all(), $reglas, $mensajes);

        $validacion->sometimes('ua_id',[ 'required', new SearchUaPadre() ], function($input){
        	return $input->tipohora_id == 0 ;
        });

        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $controldiario = new Controldiario();

            $equipoDB = Equipo::where('codigo',$request->input('equipo_id')-> get());  
            $controldiario->equipo_id 	 		  = $equipoDB[0]->id;
            
            if(input('tipohora_id') == 0){
	            $uaDB =  Ua::where('codigo', $request -> input('ua_padre_id')) -> get();
	            $controldiario->ua_id 	 			  = $uaDB[0]->id;
	        }else{
	            $tipohoraDB = Tipohora::where('codigo',$request -> input('tipohora_id')) ->get();
	            $controldiario->tipohora_id 	 	  = $tipohoraDB[0]->id;
	        }

	        $controldiario->hora_inicio = $request -> input('hora_inicio');
	        $controldiario->hora_fin 	= $request -> input('hora_fin');
	        $controldiario->fecha 		= $request -> input('fecha');


            $controldiario->save();
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
        $existe = Libreria::verificarExistencia($id, 'controldiario');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $vehiculo = Vehiculo::find($id);

     
/*        $uas = Ua::orderBy('descripcion','asc')->get();
        $cboUa = array();
        $cboUa += array('0' => 'Selecione UA');
//        $cboUa += array('1' => '1543ua');
        foreach($uas as $k=>$v){
            $cboUa += array($v->id=>$v->descripcion . '-' .$v->codigo);
        }        
*/		
        $thoras = Tipohora::orderBy('codigo','asc')->get();
        $cboUa = array();
        $cboUa += array('0' => 'Selecione UA');
        foreach($thoras as $k=>$v){
            $cboThoras += array($v->id=>$v->descripcion . '-' .$v->codigo);
        }

        $cboTurnos = array();
        $cboTurnos += array(0 => 'Diurno');
        $cboTurnos += array(1 => 'Nocturno');

        $entidad  = 'Vehiculo';
        $formData = array('vehiculo.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('vehiculo', 'cboTurnos', 'formData', 'entidad', 'boton', 'listar','cboThoras'));
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
        $existe = Libreria::verificarExistencia($id, 'controldiario');
        if ($existe !== true) {
            return $existe;
        }
         $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array('equipo_id' 			=> [new SearchEquipo()],
    						'tipohora_id' 			=> 'numeric',
                            'turno'                 => 'boolean',
    						'hora_inicio'			=> 'required',
    						'hora_fin'				=> 'required|after:hora_inicio',
    						'fecha'  				=> 'date'
                        );
        $mensajes = array(
        	'equipo_id.required'         	  => 'Debe ingresar un código de equipo',
            'tipohora_id.numeric'  	  		  => 'Tipo de hora inválido',
            'turno.boolean'                   => 'Ingrese un turno válido',
            'hora_inicio.required'			  => 'Debe una hora de inicio válida',
            'hora_fin.required'    			  => 'Debe una hora de finalzación válida',
            'hora_fin.after'    			  => 'Debe una hora de finalzación es menor que la hora de inicio',
            'fecha.date'					  => 'Debe ingresar una fecha válida'
            );


        $validacion = Validator::make($request->all(), $reglas, $mensajes);

        $validacion->sometimes('ua_id',[ 'required' ,new SearchUaPadre() ], function($input){
        	return $input->tipohora_id == 0;
        });

        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $vehiculo =  Vehiculo::find($id);
            $equipoDB = Equipo::where('codigo',$request->input('equipo_id')-> get());  
            $controldiario->equipo_id 	 		  = $equipoDB[0]->id;
            
            if(input('tipohora_id') == 0){
	            $uaDB =  Ua::where('codigo', $request -> input('ua_padre_id')) -> get();
	            $controldiario->ua_id 	 			  = $uaDB[0]->id;
	            $controldiario->tipohora_id = null;
	        }else{
	            $tipohoraDB = Tipohora::where('codigo',$request -> input('tipohora_id')) ->get();
	            $controldiario->tipohora_id 	 	  = $tipohoraDB[0]->id;
	            $controldiario->ua_id = 0;
	        }

	        $controldiario->hora_inicio = $request -> input('hora_inicio');
	        $controldiario->hora_fin 	= $request -> input('hora_fin');
	        $controldiario->fecha 		= $request -> input('fecha');
            

            $vehiculo->save();
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
        $existe = Libreria::verificarExistencia($id, 'controldiario');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $vehiculo = Vehiculo::find($id);
            $vehiculo->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'controldiario');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje = true;
        $modelo   = Controldiario::find($id);
        $entidad  = 'controldiario';
        $formData = array('route' => array('vehiculo.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }

    public function autocomplete(){
        $uas = Ua::select('codigo','descripcion')->get();

        return response() -> json($uas);
    }
}
