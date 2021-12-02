<?php

use App\Events\ControlEvent;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Models\User;
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


Route::get('/', [MainController::class, 'home'])->name('home');
Route::get('/getHistories', [MainController::class, 'getHistoriesApi']);
Route::get('/users/search/{searchedUser}', [MainController::class, 'search'])->name('search');
Route::get('excel', [MainController::class, 'excel'])->name('excel');
Route::post('mail-send', [MainController::class, 'mailSend'])->name('mail');

Route::resource('users', UserController::class)->except('update');
Route::post('users/update/{user}', [UserController::class, 'update'])->name('users.update');
