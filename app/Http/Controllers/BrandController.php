<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Brand;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    protected $folderview      = 'app.brands';
    protected $tituloAdmin     = 'Marcas';
    protected $tituloRegistrar = 'Registrar marca';
    protected $tituloModificar = 'Modificar marca';
    protected $tituloEliminar  = 'Eliminar marca';
    protected $rutas           = array('create' => 'marcas.create', 
            'edit'   => 'marcas.edit', 
            'delete' => 'marcas.eliminar',
            'search' => 'marcas.buscar',
            'index'  => 'marcas.index',
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
        $entidad          = 'Brand';
        $nombre             = Libreria::getParam($request->input('descripcion'));
        $resultado        = Brand::where('descripcion', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
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
        $entidad          = 'Brand';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }
    
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'Brand';
        // $grupomenu = Grupomenu::orderBy('descripcion','asc')->get();
        // $cboGrupo = array();
        // foreach($grupomenu as $k=>$v){
        //     $cboGrupo += array($v->id=>$v->descripcion);
        // }
        $brand = null;
        $formData = array('marcas.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('brand', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array('descripcion' => 'required|max:50');
        $mensajes = array(
            'descripcion.required' => 'Debe ingresar una descripcion'
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $brand = new Brand();
            $brand->descripcion= strtoupper($request->input('descripcion'));
            $brand->save();
        });
        return is_null($error) ? "OK" : $error;
    }
}
