<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');
});
Route::get('/asd', function () {
    //return view('welcome');
    return view('auth.login');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');

	Route::post('opcionmenu/buscar', 'OpcionmenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionmenuController@eliminar')->name('opcionmenu.eliminar');
    Route::resource('opcionmenu', 'OpcionmenuController', array('except' => array('show')));

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::post('user/buscar', 'UserController@buscar')->name('user.buscar');

	Route::get('user/eliminar/{id}/{listarluego}', 'UserController@eliminar')->name('user.eliminar');
	Route::get('user/activar/{id}/{listarluego}', 'UserController@activar')->name('user.activar');
	Route::get('user/reactivar/{id}', 'UserController@reactivar')->name('user.reactivar');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::post('profile/update', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::post('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	Route::post('opcionmenu/buscar', 'OpcionmenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionmenuController@eliminar')->name('opcionmenu.eliminar');
	Route::resource('opcionmenu', 'OpcionmenuController', array('except' => array('show')));

	//Rutas propietario - ua - unidad
	Route::post('ua/buscar', 'UaController@buscar')->name('ua.buscar');
	Route::get('ua/eliminar/{id}/{listarluego}', 'UaController@eliminar')->name('ua.eliminar');
	Route::get('ua/search/{query}', 'UaController@searchAutocomplete')->name('ua.search');
	Route::post('ua/importar', 'UaController@importExcel')->name('ua.excel.import');
	Route::get('ua/exportar', 'UaController@exportExcel')->name('ua.excel.export');
	Route::get('ua/exportar2', 'UaController@exportExcel2')->name('ua.excel.export2');
	Route::post('ua/deletelist', 'UaController@destroyList')->name('ua.deletelist');
	Route::post('ua/deleteall', 'UaController@destroyAll')->name('ua.deleteall');
	Route::resource('ua', 'UaController');

	Route::post('unidad/buscar', 'UnidadController@buscar')->name('unidad.buscar');
	Route::get('unidad/eliminar/{id}/{listarluego}', 'UnidadController@eliminar')->name('unidad.eliminar');
	Route::resource('unidad', 'UnidadController');
	
	//Rutas abastecimiento de combustible
	Route::post('abastecimiento/buscar', 'AbastecimientoCombustibleController@buscar')->name('abastecimiento.buscar');
	Route::get('abastecimiento/eliminar/{id}/{listarluego}', 'AbastecimientoCombustibleController@eliminar')->name('abastecimiento.eliminar');
	Route::get('abastecimiento/search/grifo/{query}', 'AbastecimientoCombustibleController@searchAutocompleteGrifo')->name('abastecimiento.search.grifo');
	Route::get('abastecimiento/search/conductor/{query}', 'AbastecimientoCombustibleController@searchAutocompleteConductor')->name('abastecimiento.search.conductor');
	Route::get('abastecimiento/search/equipo/{query}', 'AbastecimientoCombustibleController@searchAutocompleteEquipo')->name('abastecimiento.search.equipo');
	Route::get('abastecimiento/exportar', 'AbastecimientoCombustibleController@exportExcel')->name('abastecimiento.excel.export');
	Route::resource('abastecimiento', 'AbastecimientoCombustibleController');
	Route::post('abastecimiento/controldiario', 'AbastecimientoCombustibleController@exportControlDiario')->name('abastecimiento.controldiario');

    //Rutas Tipohora
	Route::post('tipohora/buscar', 'TipohoraController@buscar')->name('tipohora.buscar');
	Route::get('tipohora/eliminar/{id}/{listarluego}', 'TipohoraController@eliminar')->name('tipohora.eliminar');
	Route::resource('tipohora', 'TipohoraController', array('except' => array('show')));

	//Rutas controldiario
	Route::post('controldiario/buscar', 'ControlDiarioController@buscar')->name('controldiario.buscar');
	Route::get('controldiario/hequipoxua', 'ControlDiarioController@HEquipoxUa')->name('controldiario.hequipoxua');
	Route::get('controldiario/eliminar/{id}/{listarluego}', 'ControlDiarioController@eliminar')->name('controldiario.eliminar');
	Route::resource('controldiario', 'ControlDiarioController', array('except' => array('show')));

	//Rutas Grifo
	Route::post('grifo/buscar', 'GrifoController@buscar')->name('grifo.buscar');
	Route::get('grifo/eliminar/{id}/{listarluego}', 'GrifoController@eliminar')->name('grifo.eliminar');
	Route::resource('grifo', 'GrifoController', array('except' => array('show')));

	//Rutas tipocombustible
	Route::post('tipocombustible/buscar', 'TipocombustibleController@buscar')->name('tipocombustible.buscar');
	Route::get('tipocombustible/eliminar/{id}/{listarluego}', 'TipocombustibleController@eliminar')->name('tipocombustible.eliminar');
	Route::resource('tipocombustible', 'TipocombustibleController', array('except' => array('show')));

	//Rutas Carroceria
	Route::post('carroceria/buscar', 'CarroceriaController@buscar')->name('carroceria.buscar');
	Route::get('carroceria/eliminar/{id}/{listarluego}', 'CarroceriaController@eliminar')->name('carroceria.eliminar');
	Route::resource('carroceria', 'CarroceriaController', array('except' => array('show')));

	//Rutas Equipo
	Route::post('equipo/buscar', 'EquipoController@buscar')->name('equipo.buscar');
	Route::get('equipo/eliminar/{id}/{listarluego}', 'EquipoController@eliminar')->name('equipo.eliminar');
	Route::get('equipo/search/{query}', 'EquipoController@searchAutocomplete')->name('equipo.search');
	Route::resource('equipo', 'EquipoController', array('except' => array('show')));
	
	//Rutas Vehiculo
	Route::post('vehiculo/buscar', 'VehiculoController@buscar')->name('vehiculo.buscar');
	Route::get('vehiculo/eliminar/{id}/{listarluego}', 'VehiculoController@eliminar')->name('vehiculo.eliminar');
	Route::resource('vehiculo', 'VehiculoController', array('except' => array('show')));

	//Rutas Abastecimiento
	Route::post('abastecimientolugar/buscar', 'AbastecimientolugarController@buscar')->name('abastecimientolugar.buscar');
	Route::get('abastecimientolugar/eliminar/{id}/{listarluego}', 'AbastecimientolugarController@eliminar')->name('abastecimientolugar.eliminar');
	Route::resource('abastecimientolugar', 'AbastecimientolugarController', array('except' => array('show')));

	//Rutas VehiculoDocument
	Route::post('vehiculodocument/buscar', 'VehiculoDocumentController@buscar')->name('vehiculodocument.buscar');
	Route::get('vehiculodocument/eliminar/{id}/{listarluego}', 'VehiculoDocumentController@eliminar')->name('vehiculodocument.eliminar');
	Route::post('vehiculodocument/{id}', 'VehiculoDocumentController@update')->name('vehiculodocument.update');
	Route::get('vehiculodocument/notifiacion', 'VehiculoDocumentController@notifiacionCount');
	Route::get('vehiculodocument/notifiaciones', 'VehiculoDocumentController@notifiacionList');
	Route::get('vehiculodocument/exel/{id}', 'VehiculoDocumentController@notificacionExel');
	Route::resource('vehiculodocument', 'VehiculoDocumentController', array('except' => array('show')));

	//Rutas kilometraje
	Route::post('reportkilometraje/buscar', 'ReportKilometrajeController@buscar')->name('reportkilometraje.buscar');
	Route::resource('reportkilometraje', 'ReportKilometrajeController', array('except' => array('show','store','delete')));


	//tipo user
	Route::post('tipouser/buscar', 'TipoUserController@buscar')->name('tipouser.buscar');
	Route::get('tipouser/eliminar/{id}/{listarluego}', 'TipoUserController@eliminar')->name('tipouser.eliminar');
	Route::resource('tipouser', 'TipoUserController', array('except' => array('show')));
	
		
	//Rutas para las marcas (brands)
	Route::post('marcas/buscar', 'BrandController@buscar')->name('marcas.buscar');
	Route::get('marcas/eliminar/{id}/{listarluego}', 'BrandController@eliminar')->name('marcas.eliminar');
	Route::resource('marcas', 'BrandController', array('except' => array('show')));
	Route::get('marcas/activar/{id}/{listarluego}', 'BrandController@activar')->name('marcas.activar');
	Route::get('marcas/reactivar/{id}', 'BrandController@reactivar')->name('marcas.reactivar');
	//Rutas para los repuesto
	Route::post('repuestos/buscar', 'RepuestoController@buscar')->name('repuestos.buscar');
	Route::get('repuestos/eliminar/{id}/{listarluego}', 'RepuestoController@eliminar')->name('repuestos.eliminar');
	Route::resource('repuestos', 'RepuestoController', array('except' => array('show')));
	Route::get('repuestos/activar/{id}/{listarluego}', 'RepuestoController@activar')->name('repuestos.activar');
	Route::get('repuestos/reactivar/{id}', 'RepuestoController@reactivar')->name('repuestos.reactivar');
	//Rutas para los conductores
	Route::post('conductores/buscar', 'ConductorController@buscar')->name('conductores.buscar');
	Route::get('conductores/eliminar/{id}/{listarluego}', 'ConductorController@eliminar')->name('conductores.eliminar');
	Route::resource('conductores', 'ConductorController', array('except' => array('show')));
	Route::get('existeconductor', 'ConductorController@existeConductor')->name('conductores.existeconductor');
	Route::get('conductores/activar/{id}/{listarluego}', 'ConductorController@activar')->name('conductores.activar');
	Route::get('conductores/reactivar/{id}', 'ConductorController@reactivar')->name('conductores.reactivar');

	//Rutas para Conductordocumentos
	Route::resource('conductordocument', 'ConductordocumentController', array('except' => array('show')));
	Route::post('conductordocument/buscar', 'ConductordocumentController@buscar')->name('conductordocument.buscar');
	Route::get('conductordocument/eliminar/{id}/{listarluego}', 'ConductordocumentController@eliminar')->name('conductordocument.eliminar');
	
	
	//Rutas para las kilometrajes (Kilometrajes)
	Route::post('kilometrajes/buscar', 'KilometrajeController@buscar')->name('kilometrajes.buscar');
	Route::get('kilometrajes/eliminar/{id}/{listarluego}', 'KilometrajeController@eliminar')->name('kilometrajes.eliminar');
	Route::resource('kilometrajes', 'KilometrajeController', array('except' => array('show')));
	Route::get('kilometrajes/activar/{id}/{listarluego}', 'KilometrajeController@activar')->name('kilometrajes.activar');
	Route::get('kilometrajes/reactivar/{id}', 'KilometrajeController@reactivar')->name('kilometrajes.reactivar');

	//Rutas para las areas
	Route::post('areas/buscar', 'AreaController@buscar')->name('areas.buscar');
	Route::get('areas/eliminar/{id}/{listarluego}', 'AreaController@eliminar')->name('areas.eliminar');
	Route::resource('areas', 'AreaController', array('except' => array('show')));
	//Rutas para las contratistas
	Route::post('contratistas/buscar', 'ContratistaController@buscar')->name('contratistas.buscar');
	Route::get('contratistas/eliminar/{id}/{listarluego}', 'ContratistaController@eliminar')->name('contratistas.eliminar');
	Route::resource('contratistas', 'ContratistaController', array('except' => array('show')));
	//Rutas para las trabajos
	Route::post('trabajos/buscar', 'TrabajoController@buscar')->name('trabajos.buscar');
	Route::get('trabajos/eliminar/{id}/{listarluego}', 'TrabajoController@eliminar')->name('trabajos.eliminar');
	Route::resource('trabajos', 'TrabajoController', array('except' => array('show')));
	//Rutas para las concesionarias
	Route::post('concesionarias/buscar', 'ConcesionariaController@buscar')->name('concesionarias.buscar');
	Route::get('concesionarias/eliminar/{id}/{listarluego}', 'ConcesionariaController@eliminar')->name('concesionarias.eliminar');
	Route::resource('concesionarias', 'ConcesionariaController', array('except' => array('show')));
	//Rutas para mantenimiento correctivo y preventivo
	Route::resource('mantcorrprev', 'MantCorrPrev', array('except' => array('show')));
	Route::post('mantcorrprev/buscar', 'MantCorrPrev@buscar')->name('mantcorrprev.buscar');
	Route::get('mantcorrprev/eliminar/{id}/{listarluego}', 'MantCorrPrev@eliminar')->name('mantcorrprev.eliminar');
	Route::get('mantcorrprev/createrepuesto', 'MantCorrPrev@createrepuesto')->name('mantcorrprev.createrepuesto');
	Route::get('mantcorrprev/buscarporua', 'MantCorrPrev@buscarporua')->name('mantcorrprev.buscarporua');
	Route::get('existeunidad', 'MantCorrPrev@existeUnidad')->name('mantcorrprev.existeunidad');
	Route::get('mantcorrprev/pdf/generar','MantCorrPrev@generatePDF')->name('mantcorrprev.pdf.export');
	Route::get('mantcorrprev/searchConductor', 'MantCorrPrev@searchConductor');
	Route::get('mantcorrprev/searchUnidad', 'MantCorrPrev@searchUnidad');

//Rutas para Registro Repuesto Vehicular
	Route::resource('regrepveh', 'RegRepVehController', array('except' => array('show')));
	Route::post('regrepveh/buscar', 'RegRepVehController@buscar')->name('regrepveh.buscar');
	Route::get('regrepveh/eliminar/{id}/{listarluego}', 'RegRepVehController@eliminar')->name('regrepveh.eliminar');
	Route::get('regrepveh/createrepuesto', 'RegRepVehController@createrepuesto')->name('regrepveh.createrepuesto');
	Route::get('regrepveh/buscarporua', 'RegRepVehController@buscarporua')->name('regrepveh.buscarporua');
	Route::post('regrepveh/store', 'RegRepVehController@store')->name('regrepveh.createregrepveh');
	Route::get('userconcesionaria/concesionaria/{id}', 'UserConcesionariaController@concesionaria')->name('userconcesionaria.concesionaria');
	Route::get('regrepveh/search/repuesto/{query}', 'RegRepVehController@searchAutocompleteRepuesto')->name('regrepveh.search.repuesto');
	Route::get('regrepveh/search/vehiculo/{query}', 'RegRepVehController@searchAutocompleteVehiculo')->name('regrepveh.search.vehiculo');
	Route::get('regrepveh/pdf/generar','RegRepVehController@generatePDF')->name('regrepveh.pdf.export');
	Route::resource('regrepveh', 'RegRepVehController');

//Rutas para Registro Trabajo Vehicular
	Route::resource('regmanveh', 'RegManVehController', array('except' => array('show')));
	Route::post('regmanveh/buscar', 'RegManVehController@buscar')->name('regmanveh.buscar');
	Route::get('regmanveh/eliminar/{id}/{listarluego}', 'RegManVehController@eliminar')->name('regmanveh.eliminar');
	Route::get('regmanveh/createtrabajo', 'RegManVehController@createtrabajo')->name('regmanveh.createtrabajo');
	Route::get('regmanveh/buscarporua', 'RegManVehController@buscarporua')->name('regmanveh.buscarporua');
	Route::post('regmanveh/store', 'RegManVehController@store')->name('regmanveh.createregmanveh');
	Route::get('userconcesionaria/concesionaria/{id}', 'UserConcesionariaController@concesionaria')->name('userconcesionaria.concesionaria');
	Route::get('regmanveh/search/trabajo/{query}', 'RegManVehController@searchAutocompleteTrabajo')->name('regmanveh.search.trabajo');
	Route::get('regmanveh/pdf/generar','RegManVehController@generatePDF')->name('regmanveh.pdf.export');
	Route::resource('regmanveh', 'RegManVehController');


	Route::post('grupomenu/buscar', 'GrupomenuController@buscar')->name('grupomenu.buscar');
    Route::get('grupomenu/eliminar/{id}/{listarluego}', 'GrupomenuController@eliminar')->name('grupomenu.eliminar');
	Route::resource('grupomenu', 'GrupomenuController', array('except' => array('show')));

	Route::get('controldiario/generateReport', 'ControlDiarioController@generateReport')->name('controldiario.generateReport');
	Route::get('controldiario/generateReportMedicionEquipos', 'ControlDiarioController@generateReportMedicionEquipos')->name('controldiario.generateReportMedicionEquipos');
	Route::get('controldiario/exportExcelReport', 'ControlDiarioController@exportExcelReport')->name('controldiario.exportExcelReport');
	Route::post('controldiario/exportExcelReportMedicionEquipos', 'ControlDiarioController@exportExcelReportMedicionEquipos')->name('controldiario.exportExcelReportMedicionEquipos');
	
	Route::get('controldiario/getEquipos', 'ControlDiarioController@getEquipos')->name('controldiario.getEquipos');
});


Route::get('/clear', function() {
    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    return "Cleared!";

});