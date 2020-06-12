<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')
    ->post('/clients/delete/{id}', 'ClientsController@destroy');
Route::middleware('auth:sanctum')
    ->get('/clients', 'ClientsController@index');
Route::middleware('auth:sanctum')
    ->post('/clients', 'ClientsController@store');
Route::middleware('auth:sanctum')
    ->get('/client/{id}', 'ClientsController@edit');

Route::middleware('auth:sanctum')
    ->get('/loans', 'LoansController@index');
Route::middleware('auth:sanctum')
    ->post('/loan', 'LoansController@store');
Route::middleware('auth:sanctum')
    ->get('/loans/clients', 'LoansController@fillSelectClient');    
Route::middleware('auth:sanctum')
    ->post('/loan/delete/{id}', 'LoansController@destroy');