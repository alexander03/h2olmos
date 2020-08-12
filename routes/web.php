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
    return view('welcome');
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
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	Route::post('opcionmenu/buscar', 'OpcionmenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionmenuController@eliminar')->name('opcionmenu.eliminar');
	Route::resource('opcionmenu', 'OpcionmenuController', array('except' => array('show')));

	//Propietario - ua - unidad
	Route::post('propietario/buscar', 'PropietarioController@buscar')->name('propietario.buscar');
	Route::get('propietario/eliminar/{id}/{listarluego}', 'PropietarioController@eliminar')->name('propietario.eliminar');
	Route::resource('propietario', 'PropietarioController');

	Route::post('ua/buscar', 'UaController@buscar')->name('ua.buscar');
	Route::get('ua/eliminar/{id}/{listarluego}', 'UaController@eliminar')->name('ua.eliminar');
	Route::get('ua/search/{query}', 'UaController@searchAutocomplete')->name('ua.search');
	Route::resource('ua', 'UaController');

	Route::post('unidad/buscar', 'UnidadController@buscar')->name('unidad.buscar');
	Route::get('unidad/eliminar/{id}/{listarluego}', 'UnidadController@eliminar')->name('unidad.eliminar');
	Route::resource('unidad', 'UnidadController');

    //Rutas Tipohora
	Route::post('tipohora/buscar', 'TipohoraController@buscar')->name('tipohora.buscar');
	Route::get('tipohora/eliminar/{id}/{listarluego}', 'TipohoraController@eliminar')->name('tipohora.eliminar');
	Route::resource('tipohora', 'TipohoraController', array('except' => array('show')));

	//Rutas Grifo
	Route::post('grifo/buscar', 'GrifoController@buscar')->name('grifo.buscar');
	Route::get('grifo/eliminar/{id}/{listarluego}', 'GrifoController@eliminar')->name('grifo.eliminar');
	Route::resource('grifo', 'GrifoController', array('except' => array('show')));

	//Rutas Equipo
	Route::post('equipo/buscar', 'EquipoController@buscar')->name('equipo.buscar');
	Route::get('equipo/eliminar/{id}/{listarluego}', 'EquipoController@eliminar')->name('equipo.eliminar');
	Route::resource('equipo', 'EquipoController', array('except' => array('show')));
	
		
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
	//Rutas para mantenimiento correctivo y preventivo
	Route::resource('mantcorrprev', 'MantCorrPrev', array('except' => array('show')));
	Route::post('mantcorrprev/buscar', 'MantCorrPrev@buscar')->name('mantcorrprev.buscar');
	Route::get('mantcorrprev/createchecklistvehicular', 'MantCorrPrev@createchecklistvehicular')->name('mantcorrprev.createchecklistvehicular');

	Route::post('grupomenu/buscar', 'GrupomenuController@buscar')->name('grupomenu.buscar');
    Route::get('grupomenu/eliminar/{id}/{listarluego}', 'GrupomenuController@eliminar')->name('grupomenu.eliminar');
	Route::resource('grupomenu', 'GrupomenuController', array('except' => array('show')));

});

