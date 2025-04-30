<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;
use App\Models\Exercise;
use App\Models\Workout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    /**
     * Display the workout tracker dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $workouts = $user->workouts()->orderByDesc('workout_date')->paginate(10);

        return view('workouts.index', compact('workouts'));
    }

    /**
     * Show the form for creating a new workout.
     */
    public function create(): View
    {
        $exercises = Exercise::orderBy('name')->get();
        return view('workouts.create', compact('exercises'));
    }

    /**
     * Store a newly created workout in storage.
     */
    public function store(StoreWorkoutRequest $request): RedirectResponse
    {
        $workout = $request->user()->workouts()->create($request->validated());

        foreach ($request->input('exercises', []) as $exerciseData) {
            if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id']) {
                $workout->exercises()->attach($exerciseData['exercise_id'], [
                    'sets' => $exerciseData['sets'] ?? null,
                    'reps' => $exerciseData['reps'] ?? null,
                    'weight' => $exerciseData['weight'] ?? null,
                    'duration' => $exerciseData['duration'] ?? null,
                    'notes' => $exerciseData['notes'] ?? null,
                ]);
            } elseif (isset($exerciseData['custom_exercise_name']) && $exerciseData['custom_exercise_name']) {
                $workout->workoutExercises()->create([
                    'custom_exercise_name' => $exerciseData['custom_exercise_name'],
                    'sets' => $exerciseData['sets'] ?? null,
                    'reps' => $exerciseData['reps'] ?? null,
                    'weight' => $exerciseData['weight'] ?? null,
                    'duration' => $exerciseData['duration'] ?? null,
                    'notes' => $exerciseData['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('workouts.index')->with('success', 'Workout logged successfully!');
    }

    /**
     * Display the specified workout.
     */
    public function show(Workout $workout): View
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('workouts.show', compact('workout'));
    }

    /**
     * Show the form for editing the specified workout.
     */
   public function edit(Workout $workout)
{
    $exercises = Exercise::all(); // all available exercises

    // Fetch workout's logged exercises
    $workoutExercises = $workout->exercises; // if using a many-to-many or hasMany relation

    // Convert to an array suitable for form prefill
    $workoutExercisesData = DB::table('workout_exercises') // or your pivot table
    ->where('workout_id', $workout->id)
    ->get()
    ->map(function ($pivot) {
        return [
            'exercise_id' => $pivot->exercise_id, // will be null for custom
            'custom_exercise_name' => $pivot->custom_exercise_name ?? '',
            'sets' => $pivot->sets ?? '',
            'reps' => $pivot->reps ?? '',
            'weight' => $pivot->weight ?? '',
            'duration' => $pivot->duration ?? '',
            'notes' => $pivot->notes ?? '',
        ];
    })->toArray();


    return view('workouts.edit', compact('workout', 'exercises', 'workoutExercisesData'));
}

    /**
     * Update the specified workout in storage.
     */
    public function update(UpdateWorkoutRequest $request, Workout $workout): RedirectResponse
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $workout->update($request->validated());

        // Sync the exercises - remove existing and add new/updated
        $workout->exercises()->detach();
        $workout->workoutExercises()->where('exercise_id', null)->delete(); // Remove previous custom exercises

        foreach ($request->input('exercises', []) as $exerciseData) {
            if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id']) {
                dd($exerciseData['exercise_id']);
                $workout->exercises()->attach($exerciseData['exercise_id'], [
                    'sets' => $exerciseData['sets'] ?? null,
                    'reps' => $exerciseData['reps'] ?? null,
                    'weight' => $exerciseData['weight'] ?? null,
                    'duration' => $exerciseData['duration'] ?? null,
                    'notes' => $exerciseData['notes'] ?? null,
                ]);
            } elseif (isset($exerciseData['custom_exercise_name']) && $exerciseData['custom_exercise_name']) {
                $workout->workoutExercises()->create([
                    'custom_exercise_name' => $exerciseData['custom_exercise_name'],
                    'sets' => $exerciseData['sets'] ?? null,
                    'reps' => $exerciseData['reps'] ?? null,
                    'weight' => $exerciseData['weight'] ?? null,
                    'duration' => $exerciseData['duration'] ?? null,
                    'notes' => $exerciseData['notes'] ?? null,
                    'workout_id' => $workout->id, // Ensure workout_id is set
                ]);
            }
        }

        return redirect()->route('workouts.index')->with('success', 'Workout updated successfully!');
    }

    /**
     * Remove the specified workout from storage.
     */
    public function destroy(Workout $workout): RedirectResponse
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $workout->delete();

        return redirect()->route('workouts.index')->with('success', 'Workout deleted successfully!');
    }
}