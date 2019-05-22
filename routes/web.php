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

Route::GET('/', function () {
    return view('auth/login');
});

Auth::routes(['verify'=> true, "register"=>false]);


Route::middleware(['auth', 'verified', 'ativo'])->group(function () {
    Route::GET('/password','UserController@showPass')->name('password.showPass');
    Route::PATCH('/password','UserController@updatePass')->name('password.updatePass');

    Route::GET('/home', 'HomeController@index')->name('home');
    Route::GET('/socios', 'UserController@index')->name('socios');
    Route::GET('/socios/create', 'UserController@create')->name('socios.create');
    Route::POST('/socios', 'UserController@store')->name('socios.store');
    Route::GET('/socios/{user}/edit', 'UserController@edit')->name('socios.edit');
    Route::PUT('/socios/{user}', 'UserController@update')->name('socios.update');
    Route::DELETE('/socios/{user}', 'UserController@destroy')->name('socios.destroy');
    Route::GET('/pilotos/{user}/licenca', 'UserController@mostrarLicenca')->name('pilotos.licenca');
    Route::GET('/pilotos/{user}/certificado', 'UserController@mostrarCerificado')->name('pilotos.certificado');
    Route::PATCH('/socios/{user}/quota', 'UserController@definirQuotas')->name('socios.quotas');
    Route::PATCH('/socios/{user}/ativo', 'UserController@definirAtivo')->name('socios.ativo');
    Route::PATCH('/socios/reset_quotas', 'UserController@reset_quotas')->name('socios.reset_quotas');
    Route::PATCH('/socios/desativar_sem_quotas', 'UserController@desativar_sem_quotas')->name('socios.desativar_sem_quotas');

    Route::GET('/aeronaves', 'AeronavesController@index')->name('aeronaves');
    Route::GET('/aeronaves/create', 'AeronavesController@create')->name('aeronaves.create');
    Route::POST('/aeronaves', 'AeronavesController@store')->name('aeronaves.store');
    Route::GET('/aeronaves/{aeronave}/edit', 'AeronavesController@edit')->name('aeronaves.edit');
    Route::PUT('/aeronaves/{aeronave}', 'AeronavesController@update')->name('aeronaves.update');
    Route::DELETE('/aeronaves/{aeronave}', 'AeronavesController@destroy')->name('aeronaves.destroy');

    Route::GET('/movimentos', 'MovimentosController@index')->name('movimentos');
    Route::GET('/movimentos/create', 'MovimentosController@create')->name('movimentos.create');
    Route::POST('/movimentos', 'MovimentosController@store')->name('movimentos.store');
    Route::GET('/movimentos/{movimento}/edit', 'MovimentosController@edit')->name('movimentos.edit');
    Route::PUT('/movimentos/{movimento}', 'MovimentosController@update')->name('movimentos.update');
    Route::DELETE('/movimentos/{movimento}', 'MovimentosController@destroy')->name('movimentos.destroy');
});
