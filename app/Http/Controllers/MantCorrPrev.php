<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Repuesto;
use App\Unidad;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Concesionaria;

class MantCorrPrev extends Controller
{
    protected $folderview      = 'app.mantcorrprev';
    protected $tituloAdmin     = 'Mantenimiento Correctivo Preventivo';
    protected $tituloCheckListVehicular = 'Nuevo Check List Vehicular';
    protected $tituloRegistrar = 'Registro de Repuesto Vehicular';
    protected $tituloModificar = 'Modificar repuesto';
    protected $tituloEliminar  = 'Eliminar repuesto';
    protected $tituloActivar  = 'Activar repuesto';
    protected $rutas           = array(
        'checklistvehicular' => 'mantcorrprev.checklistvehicular', 
        'create' => 'repuestos.create',
        'createrepuesto' => 'mantcorrprev.createrepuesto',
        'edit'   => 'repuestos.edit', 
        'delete' => 'repuestos.eliminar',
        'activar' => 'repuestos.activar',
        'search' => 'mantcorrprev.buscar',
        'index'  => 'mantcorrprev.index',
    );

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
        $estado           = $request->input('estado');
        $unidad           = $request->input('unidad');
        $resultado        = Repuesto::getFilter($estado, $filter, $unidad);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Unidad', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $titulo_registrar = $this->tituloRegistrar;
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar','titulo_registrar', 'titulo_activar','ruta'));
        }
        // return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index()
    {
        $entidad          = 'Repuesto';
        $title            = $this->tituloAdmin;
        $tituloCheckListVehicular = $this->tituloCheckListVehicular;
        $tituloRegistrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'tituloCheckListVehicular','tituloRegistrar', 'ruta'));
    }


    public function createrepuesto(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'Repuesto';
        $repuesto = null;
        $arrConcesionarias = Concesionaria::getAll();
        $oConcesionarias = array('' => 'Seleccione Concesionaria');
        foreach($arrConcesionarias as $k=>$v){
            $oConcesionarias += array($v->id=>$v->razonsocial);
        }
        $oTipos=array('' => 'Seleccione Tipo');
        $oTipos+=array('1' => 'Preventivo');
        $oTipos+=array('2' => 'Correctivo');
        $formData = array('mantcorrprev.createrepuesto');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant2')->with(compact('repuesto', 'oTipos','formData', 'entidad','oConcesionarias', 'boton', 'listar'));
    }
}
