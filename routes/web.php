<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\DashboardUserDetailsController;
use App\Http\Controllers\DofusDBApiController;
use App\Http\Controllers\SkinController;
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

Route::get('/skins', [SkinController::class, 'index'] )->name('skins.index');

Route::middleware(['auth'])->group(function () {

    Route::get('/mon-compte/details', [DashboardUserDetailsController::class, 'index'])->name('dashboarduserdetails.index');
    Route::resource('skins', SkinController::class )->except(['show', 'index']);
});

Route::middleware(['can:admin-access'])->group(function () {

    Route::get('/mon-compte/admin', AdminPanelController::class)->name('adminpanel');
    Route::get('/updateDofusDBApi', DofusDBApiController::class)->name('dofusDBApi');
});
