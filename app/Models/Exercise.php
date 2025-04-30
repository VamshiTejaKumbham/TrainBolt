<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the workouts that include this exercise.
     */
    public function workouts(): BelongsToMany
    {
        return $this->belongsToMany(Workout::class, 'workout_exercises','workout_id', 'exercise_id')
                    ->withPivot('id', 'sets', 'reps', 'weight', 'duration', 'notes', 'custom_exercise_name')
                    ->withTimestamps();
    }
}