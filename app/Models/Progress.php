<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tracked_at',
        'weight_kg',
        'height_cm',
        'bmi',
        'body_fat_percentage',
        'muscle_mass',
        'photo_path',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tracked_at' => 'datetime',
    ];

    /**
     * Get the user that owns the progress entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}