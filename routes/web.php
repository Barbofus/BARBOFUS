<?php

use App\Actions\Likes\SwitchLikes;
use App\Http\Controllers\DofusDBApiController;
use App\Http\Controllers\EmailVerificationPromptController;
use App\Http\Controllers\HavenBagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageEnVracController;
use App\Http\Controllers\MissSkinController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\UnitySkinController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\VerifyEmailController;
use Carbon\Carbon;
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

/*Route::get('/foo', function () {
    $newUser = \DB::table('users')->select('name')->whereDate('created_at', '>', Carbon::parse('last Tuesday 09:00:00')->subDay())->pluck('name')->toArray();
    $newLikes = \App\Models\Like::select('id')->whereDate('created_at', '>', Carbon::parse('last Tuesday 09:00:00')->subDay())->count();
    $newSkins = \App\Models\Skin::select('id')->whereDate('created_at', '>', Carbon::parse('last Tuesday 09:00:00')->subDay())->count();
    dd('Nouveaux Comptes = ', $newUser, 'Nouveaux Likes = '.$newLikes, 'Nouveaux Skins = '.$newSkins);
});*/

Route::get('/', HomeController::class)->name('home');

Route::view('/mentions-legales', 'mentions-legales')->name('mentions-legales');

Route::get('/havre-sacs', [HavenBagController::class, 'index'])->name('havre-sacs.index');

Route::get('/skins', [SkinController::class, 'index'])->name('skins.index');
Route::get('/skin/{skin}', [SkinController::class, 'show'])->name('skins.show');

Route::get('/unity-skins', [UnitySkinController::class, 'index'])->name('unity-skins.index');
Route::get('/unity-skin/{skin}', [UnitySkinController::class, 'show'])->name('unity-skins.show');

Route::middleware(['auth', 'throttle:skins-upload'])->group(function () {

    Route::post('/skins', [SkinController::class, 'store'])->name('skins.store');
    Route::put('/skins/{skin}', [SkinController::class, 'update'])->name('skins.update');

    Route::post('/unity-skins', [UnitySkinController::class, 'store'])->name('unity-skins.store');
    Route::put('/unity-skins/{skin}', [UnitySkinController::class, 'update'])->name('unity-skins.update');

    Route::post('/havre-sacs', [HavenBagController::class, 'store'])->name('havre-sacs.store');
    Route::put('/havre-sacs/{havenBag}', [HavenBagController::class, 'update'])->name('havre-sacs.update');
});

Route::post('/skin/{id}/like', function (int $id) {
    (new SwitchLikes)($id, false);

    return redirect()->back();
})->name('skins.like');

Route::post('/unity-skin/{id}/like', function (int $id) {
    (new SwitchLikes)($id, true);

    return redirect()->back();
})->name('unity-skins.like');

Route::middleware(['auth'])->group(function () {

    Route::get('/mon-compte', [UserDashboardController::class, 'index'])->name('user-dashboard.index');

    Route::get('/skins/create', [SkinController::class, 'create'])->name('skins.create');
    Route::get('/skins/{skin}/edit', [SkinController::class, 'edit'])->name('skins.edit');

    Route::get('/unity-skins/create', [UnitySkinController::class, 'create'])->name('unity-skins.create');
    Route::get('/unity-skins/{skin}/edit', [UnitySkinController::class, 'edit'])->name('unity-skins.edit');

    Route::get('/havre-sacs/create', [HavenBagController::class, 'create'])->name('havre-sacs.create');
    Route::get('/havre-sacs/{havenBag}/edit', [HavenBagController::class, 'edit'])->name('havre-sacs.edit');
});

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('/email/verify/{id}', EmailVerificationPromptController::class)->name('verification.notice');
Route::post('/email/verification-notification/{id}', [EmailVerificationPromptController::class, 'store'])->name('verification.send');

Route::middleware(['can:admin-access', 'auth'])->group(function () {

    Route::get('/miss-skin', MissSkinController::class)->name('miss-skin');
    Route::get('/updateDofusDBApi', DofusDBApiController::class)->name('dofusDBApi');

    Route::get('/image-en-vrac', [ImageEnVracController::class, 'index'])->name('image-en-vrac.index');
    Route::post('/image-en-vrac/upload', [ImageEnVracController::class, 'upload'])->name('image-en-vrac.upload');
});

Route::middleware(['can:validate-skin', 'auth'])->group(function () {

    Route::delete('/skin/{skin}/delete', [SkinController::class, 'delete'])->name('skins.delete');
    Route::delete('/unity-skin/{skin}/delete', [UnitySkinController::class, 'delete'])->name('unity-skins.delete');
});
