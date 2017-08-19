<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name("home");
Route::post('/dados', 'PerfilController@dados')->name("dados");

Route::group(['prefix' => 'poupanca'], function () {
    Route::get('/', 'PoupancaController@index')->name("poupanca");
    Route::get('/create', 'PoupancaController@create')->name("novaPoupanca");
    Route::post('/insert', 'PoupancaController@insert')->name("inserirPoupanca");
    Route::get('/editar/{id?}', 'PoupancaController@editar')->name("editarPoupanca");
    Route::delete('/delete/{id?}', 'PoupancaController@delete')->name("deletePoupanca");
    Route::post('/atualizar', 'PoupancaController@atualizar')->name("atualizarPoupanca");
    Route::get('/visualizar/{id?}', 'PoupancaController@visualizar')->name("visualizarPoupanca");
    Route::get('/listarMovimento/{id?}', 'PoupancaController@listarMovimento')->name("listarMovimento");
    Route::get('/createMovimento/{id?}', 'PoupancaController@createMovimento')->name("novoMovimento");
    Route::post('/insertMovimento', 'PoupancaController@insertMovimento')->name("inserirMovimento");
    Route::delete('/deleteMovimento/{id?}', 'PoupancaController@deleteMovimento')->name("deleteMovimento");
    Route::get('/editarMovimento/{id?}', 'PoupancaController@editarMovimento')->name("editarMovimento");
    Route::post('/atualizarMovimento', 'PoupancaController@atualizarMovimento')->name("atualizarMovimento");
    Route::get('/visualizarMovimento/{id?}', 'PoupancaController@visualizarMovimento')->name("visualizarMovimento");
});

Route::group(['prefix' => 'entradaSaida'], function () {
    Route::get('/listar', 'EntradaSaidaController@listar')->name("listarEntradaSaida");
    Route::get('/cadastrar', 'EntradaSaidaController@cadastrar')->name("novaEntradaSaida");
    Route::post('/insertEntradaSaida', 'EntradaSaidaController@inserir')->name("inserirEntradaSaida");
    Route::get('/editar/{id?}', 'EntradaSaidaController@editar')->name("editarEntradaSaida");
    Route::post('/atualizar', 'EntradaSaidaController@atualizar')->name("atualizarEntradaSaida");
    Route::delete('/delete/{id?}', 'EntradaSaidaController@delete')->name("deleteEntradaSaida");
});

Route::group(['prefix' => 'perfil'], function () {
    Route::get('/listar', 'PerfilController@listar')->name("listarPerfil");
    Route::get('/editar/{id?}', 'PerfilController@editar')->name("editarPerfil");
    Route::post('/atualizar', 'PerfilController@atualizar')->name("atualizarPerfil");
});

