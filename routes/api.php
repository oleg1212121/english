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
Route::patch('/learning/{word}', [\App\Http\Controllers\Api\WordController::class, 'learning']);
Route::delete('/removing/{word}', [\App\Http\Controllers\Api\WordController::class, 'removing']);
Route::delete('/translation-excluding/{word}/{id}', [\App\Http\Controllers\Api\WordController::class, 'translationExcluding']);
