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

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/words', [\App\Http\Controllers\WordController::class, 'index'])->name('words.index');
Route::get('/words/reverse', [\App\Http\Controllers\WordController::class, 'reverse'])->name('words.reverse');
Route::get('/statistic', [\App\Http\Controllers\WordController::class, 'statistic'])->name('statistic.index');
