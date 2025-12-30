<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RewardsController extends Controller
{
    /**
     * Lit le JSON des récompenses depuis le stockage
     */
    private function readRewards(): array
    {
        if (!Storage::disk('local')->exists('json/rewards.json')) {
            return [];
        }

        $json = Storage::disk('local')->get('json/rewards.json');
        return json_decode($json, true)['rewards'] ?? [];
    }

    /**
     * Sauvegarde les récompenses dans le JSON
     */
    private function saveRewards(array $rewards): void
    {
        $data = [
            'rewards' => $rewards,
            'updated_at' => now()->toISOString()
        ];

        Storage::disk('local')->put('json/rewards.json', json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Page de la boutique de récompenses
     */
    public function index(Request $request)
    {
        $rewards = $this->readRewards();

        return view('rewards', [
            'rewards' => $rewards,
        ]);
    }

    /**
     * Met à jour toutes les récompenses
     */
    public function updateAll(Request $request)
    {
        // Vérifier que l'utilisateur est admin
        if (!auth()->check() || !auth()->user()->can('admin-access')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        $rewards = $request->get('rewards', []);

        // Normaliser les données
        foreach ($rewards as &$reward) {
            if (!isset($reward['image'])) {
                $reward['image'] = '/storage/images/rewards/default.png';
            }
        }

        $this->saveRewards($rewards);

        return response()->json([
            'success' => true,
            'rewards' => $rewards
        ], 200);
    }

    /**
     * Met à jour l'image d'une récompense spécifique
     */
    public function updateImage(Request $request)
    {
        // Vérifier que l'utilisateur est admin
        if (!auth()->check() || !auth()->user()->can('admin-access')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        $rewardIndex = $request->input('rewardIndex');
        $file = $request->file('image');

        if ($rewardIndex === null || !$file) {
            return response()->json(['success' => false, 'message' => 'Données manquantes'], 400);
        }

        // Lire les récompenses actuelles
        $rewards = $this->readRewards();

        // Vérifier que l'index est valide
        if (!isset($rewards[$rewardIndex])) {
            return response()->json(['success' => false, 'message' => 'Récompense non trouvée'], 404);
        }

        // Récupérer l'ancienne image pour la supprimer
        $oldImagePath = $rewards[$rewardIndex]['image'] ?? null;

        // Supprimer l'ancienne image si elle existe et n'est pas l'image par défaut
        if ($oldImagePath && !str_contains($oldImagePath, 'default.png')) {
            $oldPath = str_replace('/storage/', '', $oldImagePath);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Stocker la nouvelle image
        $newPath = $file->store('images/rewards', 'public');
        $newImageUrl = '/storage/' . $newPath;

        // Mettre à jour l'image dans les récompenses
        $rewards[$rewardIndex]['image'] = $newImageUrl;

        // Sauvegarder les récompenses
        $this->saveRewards($rewards);

        return response()->json([
            'success' => true,
            'imageUrl' => $newImageUrl,
            'rewards' => $rewards
        ]);
    }

    /**
     * Ajouter une nouvelle récompense
     */
    public function add(Request $request)
    {
        // Vérifier que l'utilisateur est admin
        if (!auth()->check() || !auth()->user()->can('admin-access')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        $rewards = $this->readRewards();

        // Ajouter une nouvelle récompense
        $rewards[] = [
            'image' => '/storage/images/rewards/default.png'
        ];

        $this->saveRewards($rewards);

        return response()->json([
            'success' => true,
            'rewards' => $rewards
        ]);
    }

    /**
     * Supprimer une récompense
     */
    public function delete(Request $request)
    {
        // Vérifier que l'utilisateur est admin
        if (!auth()->check() || !auth()->user()->can('admin-access')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        $rewardIndex = $request->input('rewardIndex');

        if ($rewardIndex === null) {
            return response()->json(['success' => false, 'message' => 'Index manquant'], 400);
        }

        $rewards = $this->readRewards();

        if (!isset($rewards[$rewardIndex])) {
            return response()->json(['success' => false, 'message' => 'Récompense non trouvée'], 404);
        }

        // Supprimer l'image associée si elle n'est pas l'image par défaut
        $imagePath = $rewards[$rewardIndex]['image'] ?? null;
        if ($imagePath && !str_contains($imagePath, 'default.png')) {
            $path = str_replace('/storage/', '', $imagePath);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        // Supprimer la récompense du tableau
        array_splice($rewards, $rewardIndex, 1);

        $this->saveRewards($rewards);

        return response()->json([
            'success' => true,
            'rewards' => $rewards
        ]);
    }
}
