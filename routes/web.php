<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResidentsController;
use App\Http\Controllers\AffairesController;
use App\Http\Controllers\AuthController;
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

Route::get('/dashboard', function () {
    return view('dashboard', [
        'role' => auth()->user()->role->name ]);
})->middleware('auth')->name('dashboard');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/affaires', [AffairesController::class, 'index'])
    ->middleware('auth', 'role:Préposé aux clients d’affaire,Administrateur')
    ->name('affaires');

Route::get('/residents', [ResidentsController::class, 'index'])
    ->middleware('auth', 'role:Préposé aux clients résidentiels,Administrateur')
    ->name('residents');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth', 'role:Administrateur')
    ->name('admin');

Route::resource('client', ClientController::class);
Route::get('client/{id}/edit', 'ClientController@edit')->name('client.edit');
Route::put('client/{id}', 'ClientController@update')->name('client.update');
Route::delete('client/{id}', 'ClientController@destroy')->name('client.destroy');