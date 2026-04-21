<?php

namespace App\Http\Livewire\UserPanel;

use App\Models\UnitySkin;
use App\Models\UnityReward;
use App\Models\RewardPrice;
use App\Models\SkinWinner;
use App\Http\Controllers\SkinatorController;
use App\Actions\Discord\SendDiscordMissSkinWebhook;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class MissSkinContest extends Component
{

    public string $currentTheme = '';
    public array $selectedTop3 = ['top1' => null, 'top2' => null, 'top3' => null];
    public bool $showConfirmFinalize = false;
    public bool $contestFinalized = false;
    public array $finalizedWinners = [];
    public array $skinOrder = [];

    public function mount(): void
    {
        $this->loadCurrentTheme();
        $this->loadContestState();
        $ids = UnitySkin::where('status', 'MissSkin')->pluck('id')->toArray();
        shuffle($ids);
        $this->skinOrder = $ids;
    }

    public function render(): View
    {
        $contestSkins = UnitySkin::where('status', 'MissSkin')
            ->with(['user'])
            ->get()
            ->sortBy(fn($skin) => ($pos = array_search($skin->id, $this->skinOrder)) !== false ? $pos : PHP_INT_MAX)
            ->values();

        return view('livewire.user-panel.miss-skin-contest', [
            'contestSkins' => $contestSkins
        ]);
    }

    public function updateTheme(): void
    {
        $missSkinData = ['theme' => $this->currentTheme];
        Storage::disk('local')->put('json/missskin.json', json_encode($missSkinData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $this->dispatchBrowserEvent('theme-updated');
    }

    public function deleteSkin(int $skinId): void
    {
        $skin = UnitySkin::findOrFail($skinId);
        $skin->update(['status' => 'Posted']);

        // Remove from top3 if selected
        foreach ($this->selectedTop3 as $position => $selectedId) {
            if ($selectedId == $skinId) {
                $this->selectedTop3[$position] = null;
            }
        }

        $this->dispatchBrowserEvent('skin-deleted');
    }

    public function syncTops(array $selectedTops): void
    {
        // Synchroniser les tops sélectionnés depuis le frontend
        $this->selectedTop3 = [
            'top1' => $selectedTops['top1'] ?? null,
            'top2' => $selectedTops['top2'] ?? null,
            'top3' => $selectedTops['top3'] ?? null,
        ];
    }

    public function setTop(int $skinId, string $position): void
    {
        dd('setTop called', ['skinId' => $skinId, 'position' => $position, 'current_selectedTop3' => $this->selectedTop3]);

        if (!in_array($position, ['top1', 'top2', 'top3'])) {
            \Log::warning('Invalid position', ['position' => $position]);
            return;
        }

        // Toggle logic: if already selected at this position, remove it
        if ($this->selectedTop3[$position] == $skinId) {
            \Log::info('Removing from position (toggle)', ['position' => $position, 'skinId' => $skinId]);
            $this->selectedTop3[$position] = null;
            $this->checkCanFinalize();
            return;
        }

        // Remove from other positions if already selected
        foreach ($this->selectedTop3 as $pos => $selectedId) {
            if ($selectedId == $skinId && $pos !== $position) {
                \Log::info('Removing from other position', ['old_position' => $pos, 'new_position' => $position, 'skinId' => $skinId]);
                $this->selectedTop3[$pos] = null;
            }
        }

        \Log::info('Setting new top', ['position' => $position, 'skinId' => $skinId]);
        $this->selectedTop3[$position] = $skinId;
        $this->checkCanFinalize();

        \Log::info('Final selectedTop3 state', ['selectedTop3' => $this->selectedTop3]);
    }

    public function removeFromTop(string $position): void
    {
        if (array_key_exists($position, $this->selectedTop3)) {
            $this->selectedTop3[$position] = null;
            $this->showConfirmFinalize = false;
        }
    }

    public function finalizeContest(): void
    {
        if (!$this->canFinalize()) {
            return;
        }

        $winners = [];
        $rankMapping = ['top1' => 1, 'top2' => 2, 'top3' => 3];

        // Récupérer les skins gagnants avec les données des utilisateurs
        foreach ($this->selectedTop3 as $position => $skinId) {
            if ($skinId) {
                $skin = UnitySkin::with('user')->find($skinId);
                if ($skin) {
                    $winnerData = [
                        'skin' => $skin,
                        'rank' => $rankMapping[$position],
                        'position' => $position
                    ];

                    // Pour le gagnant top1, récupérer sa récompense sélectionnée
                    if ($position === 'top1' && $skin->user) {
                        $winnerData['selected_reward'] = $skin->user->getSelectedRewardData();
                    }

                    $winners[] = $winnerData;
                }
            }
        }

        // Stocker les données des vainqueurs pour l'affichage
        $this->finalizedWinners = $winners;
        $this->contestFinalized = true;

        // Nettoyer les 3 derniers SkinWinner pour les unity skins
        $previousUnityWinners = SkinWinner::orderByDesc('id')->limit(3)->get();
        foreach ($previousUnityWinners as $previousWinner) {
            if (Storage::exists($previousWinner->image_path)) {
                Storage::delete($previousWinner->image_path);
            }
            $previousWinner->delete();
        }

        // Créer les SkinWinner (pour l'affichage)
        foreach ($winners as $index => $winner) {
            $skin = $winner['skin'];
            $newPath = 'images/winners/winner_' . ($index + 3) . '_' . time() . '.png';

            if (Storage::exists($skin->image_path)) {
                Storage::copy($skin->image_path, $newPath);
            }

            SkinWinner::create([
                'skin_id' => $skin->id,
                'reward_id' => $winner['rank'],
                'user_name' => $skin->user->name,
                'image_path' => $newPath,
                'weekly_likes' => 0,
                'skin_name' => $skin->name,
            ]);

            // Créer les UnityReward
            UnityReward::create([
                'unity_skin_id' => $skin->id,
                'rank' => $winner['rank'],
                'points' => RewardPrice::find($winner['rank'])->points,
            ]);
        }

        // Changer le statut de TOUS les skins MissSkin en Posted (y compris les vainqueurs)
        UnitySkin::where('status', 'MissSkin')->update(['status' => 'Posted']);

        // Reset contest data but keep finalized state for display
        $this->resetContest();

        // Sauvegarder l'état finalisé du concours
        $this->saveContestState();

        // Send Discord webhook
        (new SendDiscordMissSkinWebhook)(config('app.miss_skin_webhook_url'), true);

        $this->dispatchBrowserEvent('contest-finalized');
    }

    private function loadCurrentTheme(): void
    {
        $controller = new SkinatorController();
        $this->currentTheme = $controller->GetMissSkinTheme();
    }

    private function checkCanFinalize(): void
    {
        $this->showConfirmFinalize = $this->canFinalize();
    }

    private function canFinalize(): bool
    {
        return !empty($this->selectedTop3['top1']) &&
            !empty($this->selectedTop3['top2']) &&
            !empty($this->selectedTop3['top3']);
    }

    private function resetContest(): void
    {
        $missSkinData = ['theme' => 'A définir'];
        Storage::disk('local')->put('json/missskin.json', json_encode($missSkinData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $this->currentTheme = 'A définir';
        $this->selectedTop3 = ['top1' => null, 'top2' => null, 'top3' => null];
        $this->showConfirmFinalize = false;
        // Ne pas réinitialiser $contestFinalized et $finalizedWinners pour l'affichage
    }

    /**
     * Recommencer un nouveau concours (remet tout à zéro)
     */
    public function startNewContest(): void
    {
        $this->contestFinalized = false;
        $this->finalizedWinners = [];
        $this->resetContest();
        $this->saveContestState();
        $this->dispatchBrowserEvent('new-contest-started');
    }

    /**
     * Charger l'état du concours depuis le JSON
     */
    private function loadContestState(): void
    {
        $missSkinPath = storage_path('app/json/missskin.json');

        if (File::exists($missSkinPath)) {
            $data = json_decode(File::get($missSkinPath), true);
            $this->contestFinalized = $data['contest_finalized'] ?? false;
            $this->finalizedWinners = $data['finalized_winners'] ?? [];
        }
    }

    /**
     * Sauvegarder l'état du concours dans le JSON
     */
    private function saveContestState(): void
    {
        $missSkinPath = storage_path('app/json/missskin.json');
        $currentData = File::exists($missSkinPath) ? json_decode(File::get($missSkinPath), true) : [];

        $missSkinData = array_merge($currentData, [
            'contest_finalized' => $this->contestFinalized,
            'finalized_winners' => $this->finalizedWinners,
            'updated_at' => now()->toISOString()
        ]);

        File::put($missSkinPath, json_encode($missSkinData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
