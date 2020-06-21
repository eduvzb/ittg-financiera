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
    ->post('/user-password', 'UsersController@update_password');
Route::middleware('auth:sanctum')
    ->post('/user/uploadFile', 'UsersController@uploadImage');
Route::middleware('auth:sanctum')
    ->post('/user-edit', 'UsersController@update');

Route::middleware('auth:sanctum')
    ->post('/clients/edit/{id}', 'ClientsController@update');    
Route::middleware('auth:sanctum')
    ->post('/clients-import', 'ClientsController@importClients');
Route::middleware('auth:sanctum')
    ->post('/clients/delete/{id}', 'ClientsController@destroy');
Route::middleware('auth:sanctum')
    ->get('/clients', 'ClientsController@index');
Route::middleware('auth:sanctum')
    ->post('/clients', 'ClientsController@store');
Route::middleware('auth:sanctum')
    ->get('/client/{id}', 'ClientsController@edit');

Route::middleware('auth:sanctum')
    ->get('/loans/find/{id}', 'LoansController@find');
Route::middleware('auth:sanctum')
    ->post('/loans/edit/{id}', 'LoansController@update');
Route::middleware('auth:sanctum')
    ->get('/loans', 'LoansController@index');
Route::middleware('auth:sanctum')
    ->post('/loan', 'LoansController@store');
Route::middleware('auth:sanctum')
    ->get('/loans/clients', 'LoansController@fillSelectClient');    
Route::middleware('auth:sanctum')
    ->post('/loan/delete/{id}', 'LoansController@destroy');

Route::middleware('auth:sanctum')
    ->get('/payments/index', 'LoansController@index');
Route::middleware('auth:sanctum')
    ->get('/payments/show/{id}', 'PaymentController@show');  
Route::middleware('auth:sanctum')
    ->post('/payments/store/{id}', 'PaymentController@store');   

Route::get('/payments/download', 'LoansController@exportExcel');
    