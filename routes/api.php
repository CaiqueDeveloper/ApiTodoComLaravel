<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function(){
    return ['pong' => true];
}); 


Route::post('/users', [AuthController::class, 'create']);
Route::post('/auth', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/auth/logout', [AuthController::class, 'logout']);

// SANCTUM
// Route::middleware('auth:sanctum')->get('/auth/logout', [AuthController::class, 'logout']);

Route::get('unauthenticated', function(){
    return ['error' => 'Usuario não autorizado !'];
})->name('login');

// CRUD TODO

//======== VERBOS HTTP ============\\

// POST /todo = INSERIR UMA TAREFA NO SISTEMA
// GET /todos = LER TODAS AS TAREFAS DO SISTEMA
// GET /todo/{id} = LER UMA TAREFA EM ESPECÍFICA DO SISTEMA
// PUT /todo/{id} = ATUALIZAR UMA TAREFA DO SISTEMA
// DELETE /todo/{id} = DELETER UMA TAREFA DO SISTEMA

Route::get('/todos', [ApiController::class, 'readAllTodos']);
Route::get('/todo/{id}', [ApiController::class, 'readTodo']);
Route::middleware('auth:api')->post('/todo', [ApiController::class, 'createTodo']);
Route::middleware('auth:api')->put('/todo/{id}', [ApiController::class, 'updateTodo']);
Route::middleware('auth:api')->delete('/todo/{id}', [ApiController::class, 'deleteTodo']);

// auth sanctum
// Route::middleware('auth:sanctum')->post('/todo', [ApiController::class, 'createTodo']);
// Route::middleware('auth:sanctum')->put('/todo/{id}', [ApiController::class, 'updateTodo']);
// Route::middleware('auth:sanctum')->delete('/todo/{id}', [ApiController::class, 'deleteTodo']);


