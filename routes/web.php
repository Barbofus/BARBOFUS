<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\BuildController;
use App\Http\Controllers\DashboardUserDetailsController;
use App\Http\Controllers\DofusDBApiController;
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
    // Route::resource('builds', BuildController::class )
    // ->except('show', 'index');

    //Route::get('/mon-compte', [UserPageController::class, 'index'])->name('userpage.index');
    Route::get('/mon-compte/details', [DashboardUserDetailsController::class, 'index'])->name('dashboarduserdetails.index');
});

Route::middleware(['can:admin-access'])->group(function () {

    Route::get('/mon-compte/admin', [AdminPanelController::class, 'index'])->name('adminpanel.index');
    Route::put('/updateDofusDBApi', [DofusDBApiController::class, 'update'])->name('dofusDBApi.update');
});

Route::resource('builds', BuildController::class )->middleware('can:admin-access');
//Route::get('/builds', [BuildController::class, 'index'])->name('builds.index');
