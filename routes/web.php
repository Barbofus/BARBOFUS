<?php

use App\Http\Controllers\DofusDBApiController;
use App\Http\Controllers\EmailVerificationPromptController;
use App\Http\Controllers\MissSkinController;
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

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

Route::get('/skins', [SkinController::class, 'index'])->name('skins.index');
Route::get('/skin/{skin}', [SkinController::class, 'show'])->name('skins.show');

Route::middleware(['auth', 'throttle:uploads'])->group(function () {

    Route::post('/skins', [SkinController::class, 'store'])->name('skins.store');
    Route::put('/skins/{skin}', [SkinController::class, 'update'])->name('skins.update');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/mon-compte', [UserDashboardController::class, 'index'])->name('user-dashboard.index');

    Route::get('/skins/create', [SkinController::class, 'create'])->name('skins.create');
    Route::get('/skins/{skin}/edit', [SkinController::class, 'edit'])->name('skins.edit');
});

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('/email/verify/{id}', EmailVerificationPromptController::class)->name('verification.notice');
Route::post('/email/verification-notification/{id}', [EmailVerificationPromptController::class, 'store'])->name('verification.send');

Route::middleware(['can:admin-access', 'auth'])->group(function () {

    Route::get('/miss-skin', MissSkinController::class)->name('miss-skin');
    Route::get('/updateDofusDBApi', DofusDBApiController::class)->name('dofusDBApi');
});

Route::middleware(['can:validate-skin', 'auth'])->group(function () {

    Route::delete('/skin/{skin}/delete', [SkinController::class, 'delete'])->name('skins.delete');
});
