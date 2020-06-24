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
        // $resultado        = Repuesto::join('unidad', 'repuesto.unidad_id', '=', 'unidad.id')
        //                     ->where('codigo', strtoupper($filter))
        //                     ->select('repuesto.id', 'repuesto.codigo', 'repuesto.descripcion', 'unidad.descripcion as unidad_descripcion')
        //                     ->orWhere('repuesto.descripcion', 'LIKE', '%'.strtoupper($filter).'%')
        //                     ->orderBy('repuesto.codigo', 'ASC');
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
}
