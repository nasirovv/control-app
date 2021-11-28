<?php

use App\Events\ControlEvent;
use App\Http\Controllers\MainController;
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

Route::get('/test', function () {
    event(new ControlEvent('Furqat'));
});

Route::get('/', [MainController::class, 'home']);
Route::get('/getHistories', [MainController::class, 'getHistoriesApi']);
Route::get('/users/search/{searchedUser}', [MainController::class, 'search']);
Route::get('excel', [MainController::class, 'excel']);
