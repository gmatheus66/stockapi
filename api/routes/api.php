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
        Route::get('/{id}','CategoriaController@show')->name('show_categoria');
        Route::delete('/{id}', 'CategoriaController@delete')->name('delete_categoria');
        Route::put('/{id}', 'CategoriaController@update')->name('update_categoria');
    });

    Route::prefix('estoque')->group(function(){
        Route::get('/', 'EstoqueController@index')->name('index_estoque');
        Route::post('/', 'EstoqueController@store')->name('store_estoque');
        Route::get('/{id}','EstoqueController@show')->name('show_estoque');
        Route::put('/{id}', 'EstoqueController@update')->name('update_estoque');
        Route::delete('/{id}', 'EstoqueController@delete')->name('delete_estoque');

    });

    Route::prefix('secaoestoque')->group(function(){
        Route::get('/', 'SecaoEstoqueController@index')->name('index_secaoestoque');
        Route::post('/', 'SecaoEstoqueController@store')->name('store_secaoestoque');
        Route::get('/{id}','SecaoEstoqueController@show')->name('show_secaoestoque');
        Route::put('/{id}', 'SecaoEstoqueController@update')->name('update_secaoestoque');
        Route::delete('/{id}', 'SecaoEstoqueController@delete')->name('delete_secaoestoque');
    });
    
    Route::prefix('funcionario')->group(function(){
        Route::get('/', 'FuncionarioController@index')->name('index_funcionario');
        Route::post('/', 'FuncionarioController@store')->name('store_funcionario');
        Route::get('/{id}','FuncionarioController@show')->name('show_funcionario');
        Route::put('/{id}', 'FuncionarioController@update')->name('update_funcionario');
        Route::delete('/{id}', 'FuncionarioController@delete')->name('delete_funcionario');
    });

    Route::prefix('fornecedor')->group(function(){
        Route::get('/', 'FornecedorController@index')->name('index_fornecedor');
        Route::post('/', 'FornecedorController@store')->name('store_fornecedor');
        Route::get('/{id}','FornecedorController@show')->name('show_fornecedor');
        Route::put('/{id}', 'FornecedorController@update')->name('update_fornecedor');
        Route::delete('/{id}', 'FornecedorController@delete')->name('delete_fornecedor');
    });

    Route::prefix('produto')->group(function(){
        Route::get('/', 'ProdutoController@index')->name('index_produto');
        Route::post('/', 'ProdutoController@store')->name('store_produto');
        Route::get('/{id}','ProdutoController@show')->name('show_produto');
        Route::put('/{id}', 'ProdutoController@update')->name('update_produto');
        Route::delete('/{id}', 'ProdutoController@delete')->name('delete_produto');
    });


});