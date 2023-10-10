<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TelefoneController;

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

Route::get('/emails', [EmailController::class, 'index']);
Route::get('/emails/{email}', [EmailController::class, 'show']);
Route::post('/emails', [EmailController::class, 'store']);
Route::put('/emails/{email}', [EmailController::class, 'update']);
Route::delete('/emails/{email}', [EmailController::class, 'destroy']);
Route::get('/telefones', [TelefoneController::class, 'index']);
Route::get('/telefones/{telefone}', [TelefoneController::class, 'show']);
Route::post('/telefones', [TelefoneController::class, 'store']);
Route::put('/telefones/{telefone}', [TelefoneController::class, 'update']);
Route::delete('/telefones/{telefone}', [TelefoneController::class, 'destroy']);
