<?php

namespace App\Http\Controllers;

use App\User;
use App\Tipouser;
use Validator;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Librerias\Libreria;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $folderview      = 'app.usuarios';
    protected $tituloAdmin     = 'Usuarios';
    protected $tituloRegistrar = 'Registrar usuario';
    protected $tituloModificar = 'Modificar usuario';
    protected $tituloEliminar  = 'Eliminar usuario';
    protected $tituloActivar  = 'Activar usuario';
    protected $rutas           = array('create' => 'user.create', 
            'edit'   => 'user.edit', 
            'delete' => 'user.eliminar',
            'activar' => 'user.activar',
            'search' => 'user.buscar',
            'index'  => 'user.index',
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
        $entidad          = 'User';
        $filter           = Libreria::getParam($request->input('filter'));
        $estado           = $request->input('estado');
        $tipouser_id      = $request->input('tipouser_id');
        $resultado        = User::getFilter($estado, $filter, $tipouser_id);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Persona', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo de usuario', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Username', 'numero' => '1');
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'titulo_activar','ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index()
    {
        $entidad          = 'User';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $arrTipousers      = Tipouser::getAll();
        $cboTipousers = array('all' => 'TODOS');
        foreach($arrTipousers as $k=>$v){
            $cboTipousers += array($v->id=>$v->descripcion);
        }
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'cboTipousers', 'ruta'));

    }

    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'User';
        $user = null;
        $formData = array('user.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        $arrTipousers      = Tipouser::getAll();
        $cboTipousers = array('' => 'Seleccione');
        foreach($arrTipousers as $k=>$v){
            $cboTipousers += array($v->id=>$v->descripcion);
        }
        return view($this->folderview.'.mant')->with(compact('user', 'formData', 'entidad', 'cboTipousers', 'boton', 'listar'));
    }

    public function store(Request $request) {

        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array(
            'tipouser_id' => 'required',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required'
        );
        $mensajes = array(
            'tipouser_id.required' => 'Debe seleccionar un tipo de usuario',
            'name.required' => 'Debe ingresar el nombre de la persona',
            'username.required' => 'Debe ingresar el usuario',
            'password.required' => 'Debe ingresar la contraseña',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $user = new User();
            $user->tipouser_id= $request->input('tipouser_id');
            $user->name= mb_strtoupper($request->input('name'), 'utf-8');
            $user->username= $request->input('username');
            $user->password= Hash::make($request->input('password'));
            $user->save();
        });
        return is_null($error) ? "OK" : $error;

    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'users');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $user = User::find($id);
        $entidad  = 'User';
        $formData = array('user.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $arrTipousers      = Tipouser::getAll();
        $cboTipousers = array('' => 'Seleccione');
        foreach($arrTipousers as $k=>$v){
            $cboTipousers += array($v->id=>$v->descripcion);
        }
        return view($this->folderview.'.mant')->with(compact('user', 'formData', 'entidad', 'boton', 'cboTipousers', 'listar'));
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'repuesto');
        if ($existe !== true) {
            return $existe;
        }
        $reglas = array(
            'tipouser_id' => 'required',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required'
        );
        $mensajes = array(
            'tipouser_id.required' => 'Debe seleccionar un tipo de usuario',
            'name.required' => 'Debe ingresar el nombre de la persona',
            'username.required' => 'Debe ingresar el usuario',
            'password.required' => 'Debe ingresar la contraseña',
        );

        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $error = DB::transaction(function() use($request, $id){
            $user = User::find($id);
            $user->tipouser_id= $request->input('tipouser_id');
            $user->name= mb_strtoupper($request->input('name'), 'utf-8');
            $user->username= $request->input('username');
            $user->password= Hash::make($request->input('password'));
            $user->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'users');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $mensaje=true;
        $modelo   = User::find($id);
        $entidad  = 'User';
        $formData = array('route' => array('user.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'users');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $user = User::find($id);
            $user->delete();
        });
        return is_null($error) ? "OK" : $error;
    }
    
    public function activar($id, $listarLuego){
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = User::find($id);
        $entidad  = 'User';
        $formData = array('route' => array('user.reactivar', $id), 'method' => 'GET', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Activar';
        return view('app.confirmar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function reactivar($id){
        $error = DB::transaction(function() use($id){
            User::onlyTrashed()->where('id', $id)->restore();
        });
        return is_null($error) ? "OK" : $error;
    }
    
    // public function index(User $model)
    // {
    //     return view('users.index', ['users' => $model->paginate(15)]);
    // }
}
