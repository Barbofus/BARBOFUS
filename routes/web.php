<?php

use App\Actions\Api\GetApiBody;
use App\Actions\Likes\SwitchLikes;
use App\Http\Controllers\DofusDBApiController;
use App\Http\Controllers\EmailVerificationPromptController;
use App\Http\Controllers\HavenBagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageEnVracController;
use App\Http\Controllers\MissSkinController;
use App\Http\Controllers\ProxyController;
use App\Http\Controllers\SkinatorController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\UnitySkinController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\VerifyEmailController;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

/*Route::get('/foo', function () {
    $breeds = (new GetApiBody)('https://api.dofusdb.fr/breeds?$limit=50')->data;
    foreach ($breeds as $breed) {
        foreach (\App\Enums\LocaleEnum::values() as $locale) {
            \App\Models\LocalizedRace::create([
                'dofus_id' => $breed->id,
                'locale' => $locale,
                'name' => $breed->shortName->$locale,
            ]);
        }
    }
});*/

/*Route::get('/foo', function () {
    (new \App\Actions\Utils\PopulateNewSkinItems)();
});*/

/*Route::get('/foo', function () {
    (new \App\Actions\Utils\PopulateBreedsInfo)();
});*/

/*Route::get('/foo', function () {

    $toExport = \Illuminate\Support\Facades\DB::table('items')
        ->select('dofus_id as id', 'asset_id', 'female_asset_id')
        ->whereNotIn('pet_type', ['volkorne', 'dragodinde', 'muldo'])
        ->orWhereNull('pet_type')
        ->addSelect([
            DB::raw("CASE WHEN subcategory = 'livingObject' THEN TRUE ELSE FALSE END AS is_living_object")
        ])
        ->addSelect([
            'name' => \Illuminate\Support\Facades\DB::table('localized_items')
            ->select('localized_items.name')
            ->where('locale', 'fr')
            ->whereColumn('dofus_id', 'items.dofus_id')
            ->take(1)
        ])->get()->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    Storage::disk('local')->put('json/assetId.json', $toExport);


});*/

/*Route::get('/foo', function () {
    $assetIds = \App\Models\Item::where('folder', 'skins')->get()->pluck('asset_id')->toArray();
    $femaleAssetIds = \App\Models\Item::where('folder', 'skins')->get()->pluck('female_asset_id')->toArray();

    $allIds = array_unique(array_merge($assetIds, $femaleAssetIds));

    $files = Storage::disk('local')->files('json/skinator/skins');

    foreach ($files as $file) {
        $filename = pathinfo($file, PATHINFO_FILENAME);

        if (!in_array($filename, $allIds)) {
            Storage::disk('local')->delete($file);
        }
    }

    dd('FINI');
});*/

/*Route::get('/foo', function () {

    $allIds = [];

    $files = Storage::disk('local')->files('json/skinator/bones');

    foreach ($files as $file) {
        $filename = pathinfo($file, PATHINFO_FILENAME);

        if(str_contains($filename, 'SkinAsset')) {
            continue;
        }

        $jsonContent = Storage::disk('local')->get($file);
        $decodedContent = json_decode($jsonContent, true);

        if (is_array($decodedContent)) {
            $allIds[] = $decodedContent['boneAsset']['m_PathID'];
        }
    }

    foreach ($files as $file) {
        $filename = pathinfo($file, PATHINFO_FILENAME);

        if(!str_contains($filename, 'SkinAsset')) {
            continue;
        }

        $filenameWithoutSkinAsset = str_replace('SkinAsset-', '', $filename);

        if (!in_array($filenameWithoutSkinAsset, $allIds)) {
            Storage::disk('local')->delete($file);
        }
    }

    dd('FINI');
});*/

/*Route::get('/foo', function () {

    foreach (Item::all() as $item) {
        $item->update([
            'folder' => (($item->category === 'pet' &! str_contains($item->name, 'Harnachement')) ? 'bones' : 'skins')
        ]);
    }
});*/

/*Route::get('/foo', function () {

    DB::transaction(function () {
        Item::where('icon_path', 'like', '%.png')
            ->each(function ($item) {
                $newPath = preg_replace('/\.png$/', '.webp', $item->icon_path);
                $item->update(['icon_path' => $newPath]);
            });
    });

    dd('DONE');
});*/

/*Route::get('/foo', function () {

    $skins = [];

    // 1. TABLE 'items'
    $items = DB::table('items')->select('asset_id', 'female_asset_id', 'folder')->get();
    foreach ($items as $item) {
        if ($item->asset_id) {
            $skins[$item->folder][] = (int) $item->asset_id;
        }
        if ($item->female_asset_id) {
            $skins[$item->folder][] = (int) $item->female_asset_id;
        }
    }

    // 2. TABLE 'races'
    $races = DB::table('races')->select('heads')->get();
    foreach ($races as $race) {
        $heads = json_decode($race->heads, true);
        foreach (['male', 'female'] as $gender) {
            if (!isset($heads[$gender])) continue;
            foreach ($heads[$gender] as $entry) {
                if (isset($entry['skins'])) {
                    $skins['skins'][] = (int) $entry['skins'];
                }
            }
        }
    }

    // 3. FICHIER JSON
    $jsonPath = storage_path('app/json/skinator/BreedsRoot.json');
    if (file_exists($jsonPath)) {
        $data = json_decode(file_get_contents($jsonPath), true);
        $references = $data['references'] ?? [];

        foreach ($references['RefIds'] as $ref) {
            foreach (['maleLook', 'femaleLook'] as $lookKey) {
                if (!isset($ref['data'][$lookKey])) continue;

                $lookString = $ref['data'][$lookKey];
                preg_match('/\{[^|]*\|(\d+)/', $lookString, $matches);
                if (!empty($matches[1])) {
                    $skins['skins'][] = (int) $matches[1];
                }
            }
        }
    }

    // Nettoyage des doublons et tri
    foreach ($skins as $key => &$group) {
        $group = array_values(array_unique($group));
        sort($group);
    }

    // Enregistrement du fichier
    Storage::disk('local')->put('json/skinator/export.json', json_encode($skins, JSON_PRETTY_PRINT));

    dd('DONE', json_encode($skins, JSON_PRETTY_PRINT));
});*/

Route::get('/', HomeController::class)->name('home');

Route::view('/mentions-legales', 'mentions-legales')->name('mentions-legales');

Route::get('/havre-sacs', [HavenBagController::class, 'index'])->name('havre-sacs.index');

Route::get('/outils', function () {
    return view('tools');
})->name('tools');

Route::get('/skinator', [SkinatorController::class, 'index'])->name('skinator.index');

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
