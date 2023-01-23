<?php

use App\Http\Controllers\DataController;
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
});
Route::get('/load-data', [DataController::class, 'loaddata']);
Route::get('/delete/{id}', [DataController::class, 'destroy'])->name('destroy');
Route::get('/refresh-data', [DataController::class, 'refreshdata']);
