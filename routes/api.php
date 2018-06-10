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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {
    Route::get('veiculos', 'API\VeiculoController@index');
    Route::get('veiculos/find', 'API\VeiculoController@find');
    Route::get('veiculos/{id}', 'API\VeiculoController@show');
    Route::post('veiculos', 'API\VeiculoController@store');
    Route::put('veiculos/{id}', 'API\VeiculoController@update');
    Route::patch('veiculos/{id}', 'API\VeiculoController@update');
    Route::delete('veiculos/{id}', 'API\VeiculoController@destroy');
});
