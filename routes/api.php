<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [LoginController::class, 'loginUser']);

Route::get('/prueba-conexion', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['status' => 'success']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/auth/logout', [LogoutController::class, 'logout']);

    Route::get('/clientes', [CustomerController::class, 'clientes']);
    Route::get('clientes/{id}', [CustomerController::class, 'show']);


    Route::post('/clientes/agregar', [CustomerController::class, 'agregarCliente']);
    Route::put('/clientes/{id}/editar', [CustomerController::class, 'editarCliente']);
    Route::delete('/clientes/{id}/borrar', [CustomerController::class, 'borrarCliente']);

    Route::get('/tareas', [TaskController::class, 'tareas']);
    Route::post('/tareas/agregar', [TaskController::class, 'agregarTarea']);
    Route::put('/tareas/{id}/editar', [TaskController::class, 'editarTarea']);
    Route::delete('/tareas/{id}/borrar', [TaskController::class, 'borrarTarea']);

    Route::get('/files', [FileController::class, 'listFiles']);
    Route::post('/files/upload', [FileController::class, 'upload']);
    Route::delete('/files/{fileName}/delete', [FileController::class, 'delete']);
    Route::get('/files/{fileName}/download', [FileController::class, 'download']);

    Route::get('/files/{fileName}/content',  [FileController::class, 'getFileContent']);

    Route::get('/users', [UserController::class, 'users']);
    Route::put('users/{id}/online', [UserController::class, 'setOnline']);
    Route::put('users/{id}/offline', [UserController::class, 'setOffline']);
    
    Route::get('/roles', [RoleController::class, 'roles']);
    Route::put('/users/{id}/editar', [UserController::class, 'update']);
    Route::post('/users/agregar', [UserController::class, 'store']);
    Route::delete('/users/{id}/borrar', [UserController::class, 'destroy']);

    Route::get('/webmessages', [WebMessageController::class, 'webMessages']);
    Route::delete('/webmessages/{id}/borrar', [WebMessageController::class, 'borrarWebMessage']);




});



