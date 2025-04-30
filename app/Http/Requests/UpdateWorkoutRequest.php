<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateWorkoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'workout_date' => 'required|date',
            'name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'duration' => 'nullable|integer|min:0',
            'exercises.*.exercise_id' => 'nullable|exists:exercises,id',
            'exercises.*.custom_exercise_name' => 'nullable|string|max:255',
            'exercises.*.sets' => 'nullable|integer|min:1',
            'exercises.*.reps' => 'nullable|integer|min:1',
            'exercises.*.weight' => 'nullable|numeric|min:0',
            'exercises.*.duration' => 'nullable|integer|min:1',
            'exercises.*.notes' => 'nullable|string',
        ];
    }
}