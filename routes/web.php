<?php

use App\Http\Controllers\BuildController;
use App\Http\Controllers\UserPageController;
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
    return view('home');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::resource('builds', BuildController::class )
    ->except('show', 'index');

    Route::get('/mon-compte', [UserPageController::class, 'index'])->name('userpage.index');
});

Route::get('/builds', [BuildController::class, 'index'])->name('builds.index');