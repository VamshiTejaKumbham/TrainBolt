<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WorkoutGuideController extends Controller
{
    /**
     * Display the workout guide.
     */
    public function index(): View
    {
        $filePath = storage_path('app/workout_guide.json');
    $jsonData = file_get_contents($filePath);
        // dd($jsonData);
        $workouts = json_decode($jsonData, true);
        // dd($workouts);

        $categorizedWorkouts = [];
        if ($workouts) {
            foreach ($workouts as $workout) {
                $primaryMuscle = $workout['primaryMuscle'] ?? 'Uncategorized';
                if (!isset($categorizedWorkouts[$primaryMuscle])) {
                    $categorizedWorkouts[$primaryMuscle] = [];
                }
                $categorizedWorkouts[$primaryMuscle][] = $workout;
            }
        }
        // dd($categorizedWorkouts);
        return view('workout-guide.index', ['categorizedWorkouts' => $categorizedWorkouts]);
    }
}