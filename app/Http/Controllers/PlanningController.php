<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanningController extends Controller
{
    /**
     * Lit le JSON du planning depuis le stockage
     */
    private function readPlanning(): array
    {
        $json = Storage::disk('local')->get('json/planning.json');
        return json_decode($json, true)['planning'] ?? [];
    }

    /**
     * Lit le weekOffset du JSON
     */
    private function readWeekData(): array
    {
        $json = Storage::disk('local')->get('json/planning.json');
        $data = json_decode($json, true);

        // Si pas de données de semaine, utiliser la semaine actuelle
        $currentWeek = $data['currentWeek'] ?? Carbon::now()->week;
        $currentYear = $data['currentYear'] ?? Carbon::now()->year;

        return [
            'week' => $currentWeek,
            'year' => $currentYear
        ];
    }

    /**
     * Sauvegarde le planning dans le JSON
     */
    private function savePlanning(array $planning, ?int $week = null, ?int $year = null): void
    {
        // Lire le JSON existant
        $json = Storage::disk('local')->get('json/planning.json');
        $data = json_decode($json, true) ?? [];

        // Mettre à jour les clés
        $data['planning'] = $planning;
        if ($week !== null) {
            $data['currentWeek'] = $week;
        }
        if ($year !== null) {
            $data['currentYear'] = $year;
        }

        // Réécrire tout le JSON
        Storage::disk('local')->put('json/planning.json', json_encode($data, JSON_PRETTY_PRINT));
    }


    /**
     * Calcule totalHours et sessions
     */
    private function calculateStats(array $planning): array
    {
        $totalHours = 0;
        $sessions = 0;

        foreach ($planning as $dayIndex => $day) {
            foreach ($day['activities'] as $activityIndex => $activity) {
                // Debug : afficher les informations de chaque activité
                \Log::info("Activité [{$dayIndex}][{$activityIndex}]:", [
                    'name' => $activity['Name'] ?? $activity['name'] ?? 'Unknown',
                    'visible' => $activity['visible'] ?? 'not set',
                    'visible_type' => gettype($activity['visible'] ?? null),
                    'start' => $activity['StartTime'] ?? 'no start',
                    'end' => $activity['EndTime'] ?? 'no end',
                ]);

                // Ignorer les activités masquées
                if (isset($activity['visible']) && $activity['visible'] === false) {
                    \Log::info("Activité masquée ignorée: " . ($activity['Name'] ?? 'Unknown'));
                    continue;
                }

                $sessions++;

                $start = Carbon::createFromFormat('H:i', $activity['StartTime']);
                $end = Carbon::createFromFormat('H:i', $activity['EndTime']);

                // Si début et fin sont identiques (ex: 00:00 → 00:00), durée = 0
                if ($start->equalTo($end)) {
                    $duration = 0;
                }
                // Si l'heure de fin est avant l'heure de début, durée = 0
                else if ($end->lessThan($start)) {
                    $duration = 0;
                } else {
                    $duration = $end->diffInMinutes($start) / 60;
                }

                $totalHours += $duration;

                \Log::info("Activité comptée:", [
                    'name' => $activity['Name'] ?? 'Unknown',
                    'start' => $activity['StartTime'],
                    'end' => $activity['EndTime'],
                    'duration' => $duration,
                    'total_so_far' => $totalHours
                ]);
            }
        }

        // Arrondi à 1 décimale
        $totalHours = round($totalHours, 1);

        \Log::info("Stats finales:", compact('totalHours', 'sessions'));

        return compact('totalHours', 'sessions');
    }

    /**
     * Page du planning
     */
    public function index(Request $request)
    {
        $planning = $this->readPlanning();
        $weekData = $this->readWeekData();
        $stats = $this->calculateStats($planning);

        // Calculer les dates de début et fin avec Carbon
        $startOfWeek = Carbon::now()->setISODate($weekData['year'], $weekData['week'])->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        return view('planning', [
            'planning' => $planning,
            'currentWeek' => $weekData['week'],
            'currentYear' => $weekData['year'],
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'totalHours' => $stats['totalHours'],
            'sessions' => $stats['sessions'],
        ]);
    }

    /**
     * Met à jour tout le planning
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

        $planning = $request->get('planning', []);

        // Debug : afficher ce qui est reçu du frontend
        \Log::info("Planning reçu du frontend:", $planning);

        foreach ($planning as &$day) {
            if (!isset($day['activities']) || !is_array($day['activities'])) {
                $day['activities'] = [];
            }
        }

        $this->savePlanning($planning);

        $stats = $this->calculateStats($planning);

        return response()->json([
            'success' => true,
            'planning' => $planning,
            'totalHours' => $stats['totalHours'],
            'sessions' => $stats['sessions']
        ], 200);
    }

    /**
     * Met à jour l'image d'une activité spécifique
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

        $dayIndex = $request->input('dayIndex');
        $activityIndex = $request->input('activityIndex');
        $file = $request->file('image');

        if ($dayIndex === null || $activityIndex === null || !$file) {
            return response()->json(['success' => false, 'message' => 'Données manquantes'], 400);
        }

        // Lire le planning actuel
        $planning = $this->readPlanning();

        // Vérifier que les indices sont valides
        if (!isset($planning[$dayIndex]['activities'][$activityIndex])) {
            return response()->json(['success' => false, 'message' => 'Activité non trouvée'], 404);
        }

        // Récupérer l'ancienne image pour la supprimer
        $oldImagePath = $planning[$dayIndex]['activities'][$activityIndex]['Image'] ?? null;

        // Supprimer l'ancienne image si elle existe et n'est pas l'image par défaut
        if ($oldImagePath && !str_contains($oldImagePath, 'base_dofus.png')) {
            $oldPath = str_replace('/storage/', '', $oldImagePath);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Stocker la nouvelle image
        $newPath = $file->store('images/planning', 'public');
        $newImageUrl = '/storage/' . $newPath;

        // Mettre à jour l'image dans le planning
        $planning[$dayIndex]['activities'][$activityIndex]['Image'] = $newImageUrl;

        // Sauvegarder le planning
        $this->savePlanning($planning);

        return response()->json([
            'success' => true,
            'imageUrl' => $newImageUrl,
            'planning' => $planning
        ]);
    }

    /**
     * Change la semaine affichée (navigation temporelle)
     */
    public function changeWeek(Request $request)
    {
        // Vérifier que l'utilisateur est admin
        if (!auth()->check() || !auth()->user()->can('admin-access')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        $direction = $request->input('direction'); // 'next' ou 'prev'

        if (!in_array($direction, ['next', 'prev'])) {
            return response()->json([
                'success' => false,
                'message' => 'Direction invalide'
            ], 400);
        }

        $weekData = $this->readWeekData();

        // Créer un objet Carbon pour la semaine actuelle
        $currentWeek = Carbon::now()->setISODate($weekData['year'], $weekData['week']);

        // Naviguer d'une semaine
        if ($direction === 'next') {
            $newWeek = $currentWeek->addWeek();
        } else {
            $newWeek = $currentWeek->subWeek();
        }

        $planning = $this->readPlanning();
        $this->savePlanning($planning, $newWeek->week, $newWeek->year);

        // Calculer les nouvelles dates pour la réponse
        $startOfWeek = $newWeek->copy()->startOfWeek();
        $endOfWeek = $newWeek->copy()->endOfWeek();

        return response()->json([
            'success' => true,
            'week' => $newWeek->week,
            'year' => $newWeek->year,
            'startOfWeek' => $startOfWeek->format('Y-m-d'),
            'endOfWeek' => $endOfWeek->format('Y-m-d')
        ]);
    }
}
