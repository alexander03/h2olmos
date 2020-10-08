<?php

namespace App\Http\Controllers;


use App\Vehiculo;
use App\Checklistvehicular;
use App\AbastecimientoCombustible;
use App\RegManVeh;
use App\RegRepVeh;
use App\Librerias\Libreria;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportKilometrajeController extends Controller
{
    protected $folderview      = 'app.reportkilometraje';
    protected $tituloAdmin     = 'Reporte de kilometraje';
    protected $tituloRegistrar = 'Registrar repuesto';
    protected $tituloModificar = 'Modificar repuesto';
    protected $tituloEliminar  = 'Eliminar repuesto';
    protected $tituloActivar  = 'Activar repuesto';
    protected $rutas           = array('create' => 'reportkilometraje.create', 
            'edit'   => 'reportkilometraje.edit', 
            'search' => 'reportkilometraje.buscar',
            'index'  => 'reportkilometraje.index',
    );

     public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Reportkilometraje';
        $estado           = $request->input('estado');
        $placa            = $request->input('placa');
        $rule = [];	
        switch ($estado) {
        	case '1':
        	$rule[] = ['kilometraje.limite_inf' , '>' , ' vehiculo.kilometraje_rec'];
        	$rule[] = ['kilometraje.limite_sup' , '>' , ' vehiculo.kilometraje_rec'];
        		break;
        	case '2':
        		$rule[] = ['kilometraje.limite_inf' , '>' , ' vehiculo.kilometraje_rec'];
        		$rule[] = ['kilometraje.limite_sup' , '<' , ' vehiculo.kilometraje_rec'];
        		break;
        	case '3':
        		$rule[] = ['kilometraje.limite_inf' , '<' , ' vehiculo.kilometraje_rec'];
        		$rule[] = ['kilometraje.limite_sup' , '<' , ' vehiculo.kilometraje_rec'];
        		break;

        	default:
        		break;
        }
        $resultado        = Vehiculo::whereHas('kilometraje' , function($query) use($rule){
        						$query->where($rule);
       						 } )->where('placa','LIKE','%' . $placa . '%')
        						->where('concesionaria_id', $this->consecionariaActual());
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Modelo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Placa', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Kilometraje inicial', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Kilometraje recorrido', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Estado', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Opciones', 'numero' => '1');
        $titulo_modificar = $this->tituloModificar;
        
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar','ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index()
    {
        $entidad          = 'Reportkilometraje';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'vehiculo');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');

        $entidad  = 'Reportkilometraje';
        $formData = array('repuestos.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';

        $UltimosMant = collect([]);


        //ultimos mantenimientos especiales
        $UltimoChecklist = Checklistvehicular::where('especial',true)
        					->where('vehiculo_id',$id)->select('id','fecha_registro as fecha', 'vehiculo_id')->get()->first();
        if($UltimoChecklist){
        	$UltimosMant->offsetSet(1,$UltimoChecklist);
        }
        $UltimoControlCombustible = AbastecimientoCombustible::where('especial',true)->where('vehiculo_id',$id)
        								->select('id','fecha_abastecimiento as fecha', 'vehiculo_id')->get()->first();
        if($UltimoControlCombustible){
        	$UltimosMant->offsetSet(2,$UltimoControlCombustible);
        }
        $UltimoRegRepVeh = RegRepVeh::where('especial',true)->where('vehiculo_id',$id)
        						->select('id','fechasalida as fecha','vehiculo_id')->get()->first();
        if($UltimoRegRepVeh){
        	$UltimosMant->offsetSet(3,$UltimoRegRepVeh);
        }
        $UltimoRegManVeh = RegManVeh::where('especial',true)->where('vehiculo_id',$id)
        						->select('id','fechasalida as fecha','vehiculo_id')->get()->first();
        if($UltimoRegManVeh){
        	$UltimosMant->offsetSet(4,$UltimoRegManVeh);
        }
        
        
        $FechaUltimoMantEspecial = null;

        //Verifica si ya existió antes un mant especial
        if($UltimosMant->first()){
        	        $UltimosMant->sortDesc('fecha');
        
        	        $FechaUltimoMantEspecial = $UltimosMant->first()->fecha;

        }

        $listaChecklistvehicular = Checklistvehicular::where('vehiculo_id', $id)
        							->where(function($q) use ($FechaUltimoMantEspecial){
        								if($FechaUltimoMantEspecial){
        									$q->where('fecha_registro','>=',$FechaUltimoMantEspecial);
        								}
        							})->select('id','k_final as kmfinal')->get()->slice(0, 4);

        $listaChecklistvehicular = $listaChecklistvehicular.map(function ($item, $key) {
									    return $item->put('tipo', 1 );;
									});

        $listaAbastecimientoCombustible = AbastecimientoCombustible::where('vehiculo_id', $id)
        									->where(function($q) use ($FechaUltimoMantEspecial){
		        								if($FechaUltimoMantEspecial){
		        									$q->where('fecha_abastecimiento','>=',$FechaUltimoMantEspecial);
		        								}
		        							})->select('id','km as kmfinal')->get()->slice(0, 4);

		$listaAbastecimientoCombustible = $listaAbastecimientoCombustible.map(function ($item, $key) {
										    return $item->put('tipo', 2);;
										});

		$listaRegRepVeh = RegRepVeh::where('vehiculo_id', $id)
        									->where(function($q) use ($FechaUltimoMantEspecial){
		        								if($FechaUltimoMantEspecial){
		        									$q->where('fechasalida','>=',$FechaUltimoMantEspecial);
		        								}
		        							})->select('id','kmfinal')->get()->slice(0, 4);

		$listaRegRepVeh = $RegRepVeh.map(function ($item, $key) {
						    	return $item->put('tipo', 3);;
							});

		$listaRegManVeh = RegManVeh::where('vehiculo_id', $id)
        									->where(function($q) use ($FechaUltimoMantEspecial){
		        								if($FechaUltimoMantEspecial){
		        									$q->where('fechasalida','>=',$FechaUltimoMantEspecial);
		        								}
		        							})->select('id','kmfinal')->get()->slice(0, 4);

		$listaRegManVeh = $RegManVeh.map(function ($item, $key) {
						  		 return $item->put('tipo', 4);;
							});
		       
       // 
		//Uniendo todos las listas
		$ListaFinal = $listaChecklistvehicular->merge($listaAbastecimientoCombustible);

		$ListaFinal = $ListaFinal->merge($listaRegRepVeh);

		$ListaFinal = $ListaFinal->merge($listaRegManVeh);

		$ListaFinal->sortDesc('kmfinal');
        

        $vehiculo = Vehiculo::find($id)->get();
        


        return view($this->folderview.'.mant')->with(compact('repuesto','ListaFinal', 'vehiculo' ,'formData', 'entidad', 'boton', 'cboUnidades', 'listar'));
    }

    public function update(Request $request)
    {

        $error = DB::transaction(function() use($request){

        	$tipo = $request->tipo;
	        $Mant_id   = $request->mant_id;
	        $vehiculo_id  = $request->vehiculo_id;


	        $vehiculo = Vehiculo::find($vehiculo_id);
	        $vehiculo->kilometraje_rec = 0;

	        switch (strval($tipo) ) {
	        	case '1':
	        		$Mantantenimiento = Checklistvehicular::find($Mant_id);
	        		$vehiculo->kilometraje_act = $Mantantenimiento->k_final;

	        		break;

	        	case '2':
	        		$Mantantenimiento = AbastecimientoCombustible::find($Mant_id);
	        		$vehiculo->kilometraje_act = $Mantantenimiento->km;
	        		break;

	        	case '3':
	        		$Mantantenimiento = RegRepVeh::find($Mant_id);
	        		$vehiculo->kilometraje_act = $Mantantenimiento->kmfinal;
	        		break;

	        	default:
	        		$Mantantenimiento = RegManVeh::find($Mant_id);
	        		$vehiculo->kilometraje_act = $Mantantenimiento->kmfinal;
	        		break;
	        }

	        $Mantantenimiento->especial = true;
	        $Mantantenimiento->save();
	        $vehiculo->save();
	        

	    });

        return is_null($error) ? "OK" : $error;
    }

    private function consecionariaActual(){
        $ConcesionariaActual = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
        ->join('users','users.id','=','userconcesionaria.user_id')
        ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
        ->select('concesionaria.id','concesionaria.razonsocial')->get();
        $idConcAct=$ConcesionariaActual[0]->id;

        return $idConcAct;
    }


}
