<?php

namespace App\Http\Controllers;

use App\Actions\Discord\SendDiscordHavenBagPendingWebhook;
use App\Actions\Images\ResizeImages;
use App\Http\Middleware\HavenBagsOwnerShip;
use App\Http\Requests\StoreUpdateHavenBagRequest;
use App\Models\HavenBag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class HavenBagController extends Controller
{
    public function __construct()
    {
        $this->middleware(HavenBagsOwnerShip::class)->only(['edit', 'update', 'destroy']);
    }

    public function index(): View
    {
        return view('haven-bags.index');
    }

    public function create(): View
    {
        $hbThemes = DB::table('haven_bag_themes')
            ->select('*')
            ->get()->toArray();

        foreach ($hbThemes as $hbTheme) {
            $hbTheme->popocket_icon_path = asset('storage\/'.$hbTheme->popocket_icon_path);
        }

        return view('haven-bags.create', [
            'hbThemes' => $hbThemes,
        ]);
    }

    public function store(StoreUpdateHavenBagRequest $request): RedirectResponse
    {
        // Resize de l'image
        $imagePath = (new ResizeImages)($request->image_path, 'images/haven-bags', [
            'width' => 1920,
            'height' => 1080]);

        $havenBag = HavenBag::create([
            'image_path' => $imagePath,
            'user_id' => $request->user()->id,
            'haven_bag_theme_id' => $request->haven_bag_theme_id,
            'status' => (Gate::check('validate-skin')) ? 'Posted' : 'Pending',
            'name' => $request->name,
        ]);

        session()->flash('alert-message', 'Ton havre-sac a été créé. Il est en attente de validation par un Modérateur');

        if (! Gate::check('validate-skin')) {
            (new SendDiscordHavenBagPendingWebhook)(config('app.pending_webhook_url'), $havenBag);
        }

        return redirect()->route('user-dashboard.index', 'section=my-havenbags');
    }

    public function edit(HavenBag $havenBag): View
    {
        $hbThemes = DB::table('haven_bag_themes')
            ->select('*')
            ->get()->toArray();

        foreach ($hbThemes as $hbTheme) {
            $hbTheme->popocket_icon_path = asset('storage\/'.$hbTheme->popocket_icon_path);
        }

        return view('haven-bags.edit', [
            'hbThemes' => $hbThemes,
            'havenBag' => $havenBag,
        ]);
    }

    public function update(StoreUpdateHavenBagRequest $request, HavenBag $havenBag): RedirectResponse
    {
        $imagePath = $havenBag->image_path;

        // Si on change l'image, supprime l'ancienne et s'occupe de la nouvelle
        if ($request->image_path) {
            \Storage::delete($havenBag->image_path);

            // Resize de l'image
            $imagePath = (new ResizeImages)($request->image_path, 'images/haven-bags', [
                'width' => 1920,
                'height' => 1080]);
        }

        $havenBag->image_path = $imagePath;
        $havenBag->haven_bag_theme_id = $request->haven_bag_theme_id;
        $havenBag->status = (Gate::check('validate-skin')) ? 'Posted' : 'Pending';
        $havenBag->name = $request->name;

        $havenBag->save();

        session()->flash('alert-message', 'Ton havre-sac a été modifié. Il est en attente de validation par un Modérateur');

        if (! Gate::check('validate-skin')) {
            (new SendDiscordHavenBagPendingWebhook)(config('app.pending_webhook_url'), $havenBag);
        }

        return redirect()->route('user-dashboard.index', 'section=my-havenbags');
    }
}
