<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'food_description',
        'calories',
        'protein',
        'carbs',
        'fats',
        'meal_time',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meal_time' => 'datetime',
    ];

    /**
     * Get the user that owns the meal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}