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
    return view('auth/login');
});

Auth::routes(['verify'=> true, "register"=>false]);

Route::middleware(['auth', 'verified', 'ativo'])->group(function () {
    Route::GET('/password','UserController@showPass')->name('password.showPass');
    Route::PATCH('/password','UserController@updatePass')->name('password.updatePass');

    Route::GET('/home', 'HomeController@index')->name('home');
    Route::GET('/socios', 'UserController@index')->name('socios');
    Route::get('/socios/create', 'UserController@create')->name('socios.create');
    Route::post('/socios', 'UserController@store')->name('socios.store');
    Route::get('/socios/{user}/edit', 'UserController@edit')->name('socios.edit');
    Route::put('/socios/{user}', 'UserController@update')->name('socios.update');
    Route::delete('/socios/{user}', 'UserController@destroy')->name('socios.destroy');

    Route::GET('/aeronaves', 'AeronavesController@index')->name('aeronaves');
    Route::get('/aeronaves/create', 'AeronavesController@create')->name('aeronaves.create');
    Route::post('/aeronaves', 'AeronavesController@store')->name('aeronaves.store');
    Route::get('/aeronaves/{aeronave}/edit', 'AeronavesController@edit')->name('aeronaves.edit');
    Route::put('/aeronaves/{aeronave}', 'AeronavesController@update')->name('aeronaves.update');
    Route::delete('/aeronaves/{aeronave}', 'AeronavesController@destroy')->name('aeronaves.destroy');

    Route::GET('/movimentos', 'MovimentosController@index')->name('movimentos');
    Route::get('/movimentos/create', 'MovimentosController@create')->name('movimentos.create');
    Route::post('/movimentos', 'MovimentosController@store')->name('movimentos.store');
    Route::get('/movimentos/{movimentos}/edit', 'MovimentosController@edit')->name('movimentos.edit');
    Route::put('/movimentos/{movimentos}', 'MovimentosController@update')->name('movimentos.update');
    Route::delete('/movimentos/{movimentos}', 'MovimentosController@destroy')->name('movimentos.destroy');
});
