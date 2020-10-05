<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConductordocumentController extends Controller
{
    protected $folderview      = 'app.conductordocument';
    protected $tituloAdmin     = 'Documentos de vehículo';
    protected $tituloRegistrar = 'Registrar documento';
    protected $tituloModificar = 'Modificar documento';
    protected $tituloEliminar  = 'Eliminar documento';
    protected $rutas           = array('create' => 'conductordocument.create', 
            'edit'   => 'conductordocument.edit', 
            'delete' => 'conductordocument.eliminar',
            'search' => 'conductordocument.buscar',
            'index'  => 'conductordocument.index',
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
}
