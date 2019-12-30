<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/empresa','EmpresaController@index')->name('empresa');


Route::namespace('Api')->name('api.')->group(function(){
	Route::prefix('empresa')->group(function(){
        Route::get('/','EmpresaController@index')->name('index_empresa');
        Route::post('/','EmpresaController@store')->name('store_empresa');
        Route::get('/{id}', 'EmpresaController@show')->name('show_empresa');
        Route::put('/{id}' , 'EmpresaController@update')->name('update_empresa');
        Route::delete('/{id}', 'EmpresaController@delete')->name('delete_empresa');
		
    });

    Route::prefix('marca')->group(function(){
        Route::get('/', 'MarcaController@index')->name('index_marca');
        Route::post('/', 'MarcaController@store')->name('store_marca');
        Route::get('/{id}','MarcaController@show')->name('show_marca');
        Route::put('/{id}', 'MarcaController@update')->name('update_marca');
        Route::delete('/{id}', 'MarcaController@delete')->name('delete_marca');

    });

    Route::prefix('categoria')->group(function(){
        Route::get('/', 'CategoriaController@index')->name('index_categoria');
        Route::post('/', 'CategoriaController@store')->name('store_categoria');
        Route::get('/{id}','CategoriaController@show')->name('show_marca');
        Route::delete('/{id}', 'CategoriaController@delete')->name('delete_marca');
        Route::put('/{id}', 'CategoriaController@update')->name('update_marca');
    });
    
});