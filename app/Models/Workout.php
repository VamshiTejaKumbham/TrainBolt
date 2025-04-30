<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workout_date',
        'name',
        'notes',
        'duration',
    ];

    protected $casts = [
        'workout_date' => 'date',
    ];

    /**
     * Get the user that owns the workout.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the exercises performed in this workout.
     */
    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercises','workout_id', 'exercise_id')
                    ->withPivot('id', 'sets', 'reps', 'weight', 'duration', 'notes', 'custom_exercise_name')
                    ->withTimestamps();
    }

    /**
     * Get the workout exercises associated with this workout.
     */
    public function workoutExercises(): HasMany
    {
        return $this->hasMany(WorkoutExercise::class);
    }
}