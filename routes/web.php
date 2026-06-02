<?php

use App\Actions\Likes\SwitchLikes;
use App\Http\Controllers\ApiSkinController;
use App\Http\Controllers\DofusDBApiController;
use App\Http\Controllers\EmailVerificationPromptController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HavenBagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageEnVracController;
use App\Http\Controllers\MissSkinController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\RewardsController;
use App\Http\Controllers\SkinatorController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\TougliController;
use App\Http\Controllers\UnitySkinController;
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

/*Route::get('export-concours', function () {
    $skins = UnitySkin::query()
        ->when(true, function (EloquentBuilder $query) {
            $subQuery = \DB::table('unity_skins as us2')
                ->selectRaw('MAX(us2.id)')
                ->whereColumn('us2.name', 'unity_skins.name')
                ->groupBy('us2.name');

            $query->whereDate('unity_skins.created_at', '2025-07-01')
                ->where('unity_skins.name', 'LIKE', '%#%')
                ->whereIn('unity_skins.id', $subQuery);
        })
        ->get();


    $export = $skins->map(function ($skin) {
        return "=HYPERLINK(\"" . \route('unity-skins.show', $skin->id) . "\"; \"" . $skin->name . " - " . $skin->User->name . "\")";
    })->toArray();

    return response(implode("\n", $export))
        ->header('Content-Type', 'text/plain')
        ->header('Content-Disposition', 'attachment; filename="skins-concours.txt"');

});*/

/*Route::get('foo', function () {
    $skins = UnitySkin::all();

    foreach ($skins as $skin) {
        $skin->update([
            'color_guild_1' => '#241F1D',
            'color_guild_2' => '#FAB420'
        ]);
    }

    return "Couleurs mises à jour pour " . $skins->count() . " skins Unity";
});*/

/*oute::get('foo', function () {
    $allItems = json_decode(Storage::disk('local')->get('json/skinator/ItemsDataRoot.json'), true)['references']["RefIds"];

    //$item = collect($allItems)->firstWhere('data.nameId', 1177910);
    //$item = collect($allItems)->firstWhere('data.typeId', 250);
    $item = collect($allItems)->firstWhere('data.id', 34250);

    // Charger le fichier de langue français
    $langFile = storage_path('app/json/skinator/lang/fr.json');
    $translations = json_decode(file_get_contents($langFile), true);

    // Récupérer le nom de l'item grâce au nameId
    $itemName = $translations[$item['data']['nameId']] ?? 'Nom non trouvé';

    //dd($item['data'], $itemName);
    dd(collect($allItems)->firstWhere('data.id', 34248)["data"], collect($allItems)->firstWhere('data.id', 34249)["data"], collect($allItems)->firstWhere('data.id', 34250)["data"],);
});*/

Route::middleware(['cache.public'])->group(function () {

    Route::get('/', HomeController::class)->name('home');

    Route::view('/mentions-legales', 'mentions-legales')->name('mentions-legales');

    Route::view('/socials', 'socials')->name('socials');

    Route::get('/planning', [PlanningController::class, 'index'])->name('planning.index');

    Route::get('/recompenses', [RewardsController::class, 'index'])->name('rewards.index');

    Route::get('/havre-sacs', [HavenBagController::class, 'index'])->name('havre-sacs.index');

    Route::get('/outils', function () {
        return view('tools');
    })->name('tools');;

    Route::get('/skinator', [SkinatorController::class, 'create'])->name('skinator.create');
    Route::get('/testator', [SkinatorController::class, 'testator'])->name('testator.create');
    Route::get('/devator', [SkinatorController::class, 'devator'])->name('devator.create');

    Route::get('/skins', [SkinController::class, 'index'])->name('skins.index');
    Route::get('/skin/{skin}', [SkinController::class, 'show'])->name('skins.show');

    Route::get('/unity-skins', [UnitySkinController::class, 'index'])->name('unity-skins.index');
    Route::get('/unity-skin/{skin}', [UnitySkinController::class, 'show'])->name('unity-skins.show');
});

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

    Route::post('/recompenses/select', [RewardsController::class, 'selectReward'])->name('rewards.select');

    Route::get('/skins/create', [SkinController::class, 'create'])->name('skins.create');
    Route::get('/skins/{skin}/edit', [SkinController::class, 'edit'])->name('skins.edit');

    // Route::get('/unity-skins/create', [UnitySkinController::class, 'create'])->name('unity-skins.create');
    // Route::get('/unity-skins/{skin}/edit', [UnitySkinController::class, 'edit'])->name('unity-skins.edit');

    Route::get('/skinator/{skin}/edit', [SkinatorController::class, 'edit'])->name('skinator.edit');

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

    Route::put('/planning/update-all', [PlanningController::class, 'updateAll'])->name('planning.update-all');
    Route::post('/planning/update-image', [PlanningController::class, 'updateImage'])->name('planning.update-image');
    Route::post('/planning/change-week', [PlanningController::class, 'changeWeek'])->name('planning.change-week');

    Route::put('/recompenses/update-all', [RewardsController::class, 'updateAll'])->name('rewards.update-all');
    Route::post('/recompenses/update-image', [RewardsController::class, 'updateImage'])->name('rewards.update-image');
    Route::post('/recompenses/add', [RewardsController::class, 'add'])->name('rewards.add');
    Route::delete('/recompenses/delete', [RewardsController::class, 'delete'])->name('rewards.delete');
});

Route::middleware(['can:validate-skin', 'auth'])->group(function () {

    Route::delete('/skin/{skin}/delete', [SkinController::class, 'delete'])->name('skins.delete');
    Route::delete('/unity-skin/{skin}/delete', [UnitySkinController::class, 'delete'])->name('unity-skins.delete');
});

Route::get('/api/skin/{id}', [ApiSkinController::class, 'show']);

Route::get('/api/whoami', [TougliController::class, 'whoami']);

Route::get('/api/tougli/skins', [TougliController::class, 'getSkins']);
Route::get('/api/tougli/skins/global', [TougliController::class, 'getGlobalSkins']);
Route::get('/api/tougli/skin/{id}', [TougliController::class, 'getSkinById']);
Route::get('/api/tougli/skin/{id}/image', [TougliController::class, 'getSkinImage']);

Route::get('/logout', [TougliController::class, 'logout'])->name('logout.cross-site');

Route::put('/api/locale', [TougliController::class, 'updateLocale']);

Route::post('/favorites', [FavoriteController::class, 'store']);

Route::delete('/favorites', [FavoriteController::class, 'destroy']);
