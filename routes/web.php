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

	// Route::post('grupomenu/buscar', 'GrupomenuController@buscar')->name('grupomenu.buscar');
    // Route::get('grupomenu/eliminar/{id}/{listarluego}', 'GrupomenuController@eliminar')->name('grupomenu.eliminar');
    // Route::resource('grupomenu', 'GrupomenuController', array('except' => array('show')));

	Route::post('opcionmenu/buscar', 'OpcionmenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionmenuController@eliminar')->name('opcionmenu.eliminar');
    Route::resource('opcionmenu', 'OpcionmenuController', array('except' => array('show')));

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	// Route::post('grupomenu/buscar', 'GrupomenuController@buscar')->name('grupomenu.buscar');

	// Route::get('grupomenu/eliminar/{id}/{listarluego}', 'GrupomenuController@eliminar')->name('grupomenu.eliminar');
	// Route::resource('grupomenu', 'GrupomenuController', array('except' => array('show')));

	Route::post('opcionmenu/buscar', 'OpcionmenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionmenuController@eliminar')->name('opcionmenu.eliminar');
		Route::resource('opcionmenu', 'OpcionmenuController', array('except' => array('show')));
		
	//Rutas para las marcas (brands)
	Route::post('marcas/buscar', 'BrandController@buscar')->name('marcas.buscar');
	Route::get('marcas/eliminar/{id}/{listarluego}', 'BrandController@eliminar')->name('marcas.eliminar');
	Route::resource('marcas', 'BrandController', array('except' => array('show')));
	//Rutas para los repuesto
	Route::post('repuestos/buscar', 'RepuestoController@buscar')->name('repuestos.buscar');
	Route::get('repuestos/eliminar/{id}/{listarluego}', 'RepuestoController@eliminar')->name('repuestos.eliminar');
	Route::resource('repuestos', 'RepuestoController', array('except' => array('show')));
	//Rutas para los conductores
	Route::post('conductores/buscar', 'ConductorController@buscar')->name('conductores.buscar');
	Route::get('conductores/eliminar/{id}/{listarluego}', 'ConductorController@eliminar')->name('conductores.eliminar');
	Route::resource('conductores', 'ConductorController', array('except' => array('show')));
});

