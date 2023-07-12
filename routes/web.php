<?php

use App\Http\Controllers\DofusDBApiController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\VerifyEmailController;
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

Route::get('/skins', [SkinController::class, 'index'])->name('skins.index');
Route::get('/skin/{skin}', [SkinController::class, 'show'])->name('skins.show');

Route::middleware(['auth'])->group(function () {

    Route::get('/mon-compte', [UserDashboardController::class, 'index'])->name('user-dashboard.index');
    Route::resource('skins', SkinController::class)->except(['show', 'index']);
});

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware(['can:admin-access'])->group(function () {

    Route::get('/updateDofusDBApi', DofusDBApiController::class)->name('dofusDBApi');
});
