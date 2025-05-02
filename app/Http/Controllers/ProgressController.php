<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgressRequest;
use App\Models\Progress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgressController extends Controller
{
    /**
     * Display a listing of the user's progress entries.
     */
    public function index(): View
    {
        $progressEntries = Auth::user()->progress()->orderBy('tracked_at', 'desc')->paginate(10);
        return view('progress.index', compact('progressEntries'));
    }

    /**
     * Show the form for creating a new progress entry.
     */
    public function create(): View
    {
        return view('progress.create');
    }

    /**
     * Store a newly created progress entry in storage.
     */
    /**
     * Store a newly created progress entry in storage.
     */
    public function store(StoreProgressRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();

        // Calculate BMI
        if (isset($validatedData['weight_kg']) && isset($validatedData['height_cm']) && $validatedData['height_cm'] > 0) {
            $heightInMeters = $validatedData['height_cm'] / 100;
            $validatedData['bmi'] = round($validatedData['weight_kg'] / ($heightInMeters * $heightInMeters), 2);

            // Estimate Body Fat Percentage (using user input)
            if (isset($validatedData['age']) && isset($validatedData['gender'])) {
                if ($validatedData['gender'] === 'male') {
                    $validatedData['body_fat_percentage'] = round((1.20 * $validatedData['bmi']) + (0.23 * $validatedData['age']) - 16.2, 2);
                } elseif ($validatedData['gender'] === 'female') {
                    $validatedData['body_fat_percentage'] = round((1.20 * $validatedData['bmi']) + (0.23 * $validatedData['age']) - 5.4, 2);
                }

                // Rough estimate of Muscle Mass
                if (isset($validatedData['body_fat_percentage'])) {
                    $fatMass = $validatedData['weight_kg'] * ($validatedData['body_fat_percentage'] / 100);
                    $fatFreeMass = $validatedData['weight_kg'] - $fatMass;
                    $validatedData['muscle_mass'] = round($fatFreeMass * 0.45, 2);
                }
            }
        }

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('progress_photos', 'public');
            $validatedData['photo_path'] = $photoPath;
        }

        Progress::create($validatedData);

        return redirect()->route('progress.index')->with('success', __('Progress entry created successfully.'));
    }

    /**
     * Update the specified progress entry in storage.
     */
    public function update(StoreProgressRequest $request, Progress $progress): RedirectResponse
    {
        if ($progress->user_id !== Auth::id()) {
            abort(403, __('Unauthorized action.'));
        }

        $validatedData = $request->validated();

        // Recalculate BMI if weight or height is updated
        if (isset($validatedData['weight_kg']) && isset($validatedData['height_cm']) && $validatedData['height_cm'] > 0) {
            $heightInMeters = $validatedData['height_cm'] / 100;
            $validatedData['bmi'] = round($validatedData['weight_kg'] / ($heightInMeters * $heightInMeters), 2);

            // Estimate Body Fat Percentage (using a BMI, Age, Gender based formula)
            if (isset($validatedData['age']) && isset($validatedData['gender'])) {
                if ($validatedData['gender'] === 'male') {
                    $validatedData['body_fat_percentage'] = round((1.20 * $validatedData['bmi']) + (0.23 * $validatedData['age']) - 16.2, 2);
                } elseif ($validatedData['gender'] === 'female') {
                    $validatedData['body_fat_percentage'] = round((1.20 * $validatedData['bmi']) + (0.23 * $validatedData['age']) - 5.4, 2);
                }

                // Rough estimate of Muscle Mass (as a percentage of Fat-Free Mass)
                if (isset($validatedData['body_fat_percentage'])) {
                    $fatMass = $validatedData['weight_kg'] * ($validatedData['body_fat_percentage'] / 100);
                    $fatFreeMass = $validatedData['weight_kg'] - $fatMass;
                    // Assuming a rough 45% of FFM is muscle mass (this is a very general assumption)
                    $validatedData['muscle_mass'] = round($fatFreeMass * 0.45, 2);
                }
            }
        } else {
            $validatedData['bmi'] = null; // Reset BMI if weight or height is missing
            $validatedData['body_fat_percentage'] = null;
            $validatedData['muscle_mass'] = null;
        }

        // Handle photo update if a new photo is provided
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists (optional - you might want to keep it)
            if ($progress->photo_path) {
                \Storage::disk('public')->delete($progress->photo_path);
            }
            $photoPath = $request->file('photo')->store('progress_photos', 'public');
            $validatedData['photo_path'] = $photoPath;
        } elseif ($request->input('remove_photo')) {
            // Handle removing the photo
            if ($progress->photo_path) {
                \Storage::disk('public')->delete($progress->photo_path);
                $validatedData['photo_path'] = null;
            }
        }

        $progress->update($validatedData);

        return redirect()->route('progress.index')->with('success', __('Progress entry updated successfully.'));
    }
    /**
     * Display the specified progress entry.
     */
    public function show(Progress $progress): View
    {
        if ($progress->user_id !== Auth::id()) {
            abort(403, __('Unauthorized action.'));
        }
        return view('progress.show', compact('progress'));
    }

    /**
     * Show the form for editing the specified progress entry.
     */
    public function edit(Progress $progress): View
    {
        if ($progress->user_id !== Auth::id()) {
            abort(403, __('Unauthorized action.'));
        }
        return view('progress.edit', compact('progress'));
    }

    /**
     * Update the specified progress entry in storage.
     */

    /**
     * Remove the specified progress entry from storage.
     */
    public function destroy(Progress $progress): RedirectResponse
    {
        if ($progress->user_id !== Auth::id()) {
            abort(403, __('Unauthorized action.'));
        }

        // Delete the associated photo if it exists (optional)
        if ($progress->photo_path) {
            \Storage::disk('public')->delete($progress->photo_path);
        }

        $progress->delete();

        return redirect()->route('progress.index')->with('success', __('Progress entry deleted successfully.'));
    }
}