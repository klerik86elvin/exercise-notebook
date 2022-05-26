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

Route::prefix('v1/notebook')->group(function () {
    Route::get('/', [\App\Http\Controllers\NotebookController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\NotebookController::class, 'create']);
    Route::get('/{id}', [\App\Http\Controllers\NotebookController::class, 'show']);
    Route::post('/{id}', [\App\Http\Controllers\NotebookController::class, 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\NotebookController::class, 'delete']);
});
