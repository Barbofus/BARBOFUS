<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpenPlanningController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Lire le JSON
        $json = Storage::disk('local')->get('json/planning.json');
        $planningData = json_decode($json, true)['planning'] ?? [];

        $totalHours = 0; // total d'heures
        $sessions = 0;   // nombre total de sessions (chaque activité = 1 session)

        foreach ($planningData as $day) {
            foreach ($day['activities'] as $activity) {
                $sessions++;

                // Convertir StartTime et EndTime en objets Carbon
                $start = Carbon::createFromFormat('H:i', $activity['StartTime']);
                $end = Carbon::createFromFormat('H:i', $activity['EndTime']);

                // Calculer la durée en heures (y compris les minutes en fraction)
                $duration = $end->diffInMinutes($start) / 60;

                $totalHours += $duration;
            }
        }

        // Envoyer tout à la vue
        return view('planning', [
            'planning' => $planningData,
            'totalHours' => $totalHours,
            'sessions' => $sessions
        ]);
    }
}
