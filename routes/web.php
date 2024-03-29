<?php

use Illuminate\Support\Facades\Route;

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


// venda  
Route::get('/','App\Http\Controllers\VendaController@index')->name('view.venda');
Route::get('/venda','App\Http\Controllers\VendaController@salva')->name('salvar.venda');
Route::post('/criarVenda','App\Http\Controllers\VendaController@criarVenda');
Route::post('/pagamento', 'App\Http\Controllers\VendaController@pagamento');
Route::get('/remove/{id}','App\Http\Controllers\VendaController@remove');
Route::get('/detalhes/{id}','App\Http\Controllers\VendaController@detalhes');
Route::get('/resumoVenda/{id}','App\Http\Controllers\VendaController@resumoVenda');
Route::get('/consulta','App\Http\Controllers\VendaController@consulta');
Route::get('/edit/{id}','App\Http\Controllers\VendaController@edit');
Route::post('/editSalvar','App\Http\Controllers\VendaController@editSalvar');
Route::get('/editParcelas','App\Http\Controllers\VendaController@editParcelas');



//produto

Route::prefix('/produto')->group(function (){

    Route::get('/', 'App\Http\Controllers\ProdutoController@index');
    Route::get('/cadastrar', 'App\Http\Controllers\ProdutoController@cadastrar');
    Route::post('/salvarProduto', 'App\Http\Controllers\ProdutoController@salvarProduto');
    Route::get('/remove/{id}','App\Http\Controllers\ProdutoController@remove');
    Route::get('/edit/{id}','App\Http\Controllers\ProdutoController@edit');
    Route::post('/editSalvar','App\Http\Controllers\ProdutoController@editSalvar');

});






//pessoa

Route::prefix('/pessoa')->group(function (){

    Route::get('/', 'App\Http\Controllers\PessoaController@index');
    Route::get('/cadastrar', 'App\Http\Controllers\PessoaController@cadastrar');
    Route::post('/salvarPessoa', 'App\Http\Controllers\PessoaController@salvarPessoa');
    Route::get('/remove/{id}','App\Http\Controllers\PessoaController@remove');
    Route::get('/edit/{id}','App\Http\Controllers\PessoaController@edit');
    Route::post('/editSalvar','App\Http\Controllers\PessoaController@editSalvar');
});




// Route::get('/', function () {
//     return view('welcome');
// });
