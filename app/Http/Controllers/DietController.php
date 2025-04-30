<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMealRequest;
use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DietController extends Controller
{
    /**
     * Display the diet tracker dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $dailyMeals = $user->meals()->whereDate('meal_time', $today)->orderBy('meal_time')->get();
        $weeklyMeals = $user->meals()->whereBetween('meal_time', [$startOfWeek, $endOfWeek])->get();

        $dailySummary = $this->calculateNutritionSummary($dailyMeals);
        $weeklySummary = $this->calculateWeeklySummary($weeklyMeals);

        return view('diet.index', compact('dailyMeals', 'dailySummary', 'weeklySummary'));
    }

    /**
     * Show the form for adding a new meal.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('diet.create');
    }

    /**
     * Store a newly created meal in storage.
     *
     * @param  \App\Http\Requests\StoreMealRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMealRequest $request)
    {
        $request->user()->meals()->create($request->validated() + ['meal_time' => now()]);

        return redirect()->route('diet.index')->with('success', 'Meal added successfully!');
    }

    /**
     * Show the form for editing an existing meal.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\View\View
     */
    public function edit(Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('diet.edit', compact('meal'));
    }

    /**
     * Update the specified meal in storage.
     *
     * @param  \App\Http\Requests\StoreMealRequest  $request
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreMealRequest $request, Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $meal->update($request->validated());

        return redirect()->route('diet.index')->with('success', 'Meal updated successfully!');
    }

    /**
     * Remove the specified meal from storage.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Meal $meal)
    {
        if ($meal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $meal->delete();

        return redirect()->route('diet.index')->with('success', 'Meal deleted successfully!');
    }

    /**
     * Calculate the nutrition summary for a collection of meals.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $meals
     * @return array
     */
    protected function calculateNutritionSummary($meals)
    {
        $totalCalories = $meals->sum('calories');
        $totalProtein = $meals->sum('protein');
        $totalCarbs = $meals->sum('carbs');
        $totalFats = $meals->sum('fats');

        return [
            'calories' => $totalCalories,
            'protein' => $totalProtein,
            'carbs' => $totalCarbs,
            'fats' => $totalFats,
        ];
    }

    /**
     * Calculate the weekly nutrition summary.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $meals
     * @return array
     */
    protected function calculateWeeklySummary($meals)
    {
        $dailyData = [];
        $startDate = Carbon::now()->startOfWeek();

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->clone()->addDays($i)->toDateString();
            $dailyMeals = $meals->where('meal_time', '>=', $date . ' 00:00:00')->where('meal_time', '<=', $date . ' 23:59:59');
            $dailyData[$date] = $this->calculateNutritionSummary($dailyMeals);
        }

        return $dailyData;
    }
}