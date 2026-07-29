<?php

use App\Http\Controllers\TwitchCounterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/run-update-items', function (Request $request) {
    // \Illuminate\Support\Facades\Log::info('Start /api/run-update-items');
    if (app()->environment('local')) {
        return Response::json(['error' => 'Not allowed in this environment'], 403);
    }

    $providedKey = $request->header('X-Secret-Key');
    $expectedKey = config('services.dofus_update_secret');

    // Log::info('Provide X-Secret-Key...', ['providedKey' => $providedKey, 'expectedKey' => $expectedKey]);
    if ($providedKey !== $expectedKey) {
        return Response::json(['error' => 'Unauthorized'], 401);
    }

    // Log::info('Calling artisan...');
    Artisan::call('update:dofus-items');
    // Log::info('Artisan output', ['output' => Artisan::output()]);

    return Response::json([
        'success' => true,
        'output' => Artisan::output(),
    ]);
});

Route::post('/twitch/counter', TwitchCounterController::class);

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $user = $request->user();

    // Révoquer le token courant
    $user->currentAccessToken()->delete();

    return response()->json(['success' => true]);
});

/*Route::post('/create-items-export', function (Request $request) {
    if (app()->environment('local')) {
        return Response::json(['error' => 'Not allowed in this environment'], 403);
    }

    $providedKey = $request->header('X-Secret-Key');

    if ($providedKey !== env('DOFUS_UPDATE_SECRET')) {
        return Response::json(['error' => 'Unauthorized'], 401);
    }

    (new \App\Actions\ItemsUpdate\createItemsExport)();

    return Response::json([
        'success' => true,
        'output' => Artisan::output(),
    ]);
});*/
