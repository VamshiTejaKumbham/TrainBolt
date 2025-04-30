<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProgressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can create/update progress entries
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tracked_at' => ['required', 'date'],
            'weight_kg' => ['nullable', 'numeric', 'min:0'],
            'height_cm' => ['nullable', 'numeric', 'min:0'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'gender' => ['required', 'in:male,female'],
            'body_fat_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'muscle_mass' => ['nullable', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB for the photo
            'remove_photo' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tracked_at.required' => __('The tracking date is required.'),
            'tracked_at.date' => __('The tracking date must be a valid date.'),
            'weight_kg.numeric' => __('The weight must be a number.'),
            'weight_kg.min' => __('The weight must be at least 0.'),
            'height_cm.numeric' => __('The height must be a number.'),
            'height_cm.min' => __('The height must be at least 0.'),
            'age.required' => __('The age is required.'),
            'age.integer' => __('The age must be an integer.'),
            'age.min' => __('The age must be at least 1.'),
            'age.max' => __('The age cannot be more than 120.'),
            'gender.required' => __('The gender is required.'),
            'gender.in' => __('Please select a valid gender.'),
            'body_fat_percentage.numeric' => __('The body fat percentage must be a number.'),
            'body_fat_percentage.min' => __('The body fat percentage must be at least 0.'),
            'body_fat_percentage.max' => __('The body fat percentage must be no more than 100.'),
            'muscle_mass.numeric' => __('The muscle mass must be a number.'),
            'muscle_mass.min' => __('The muscle mass must be at least 0.'),
            'photo.image' => __('The uploaded file must be an image.'),
            'photo.max' => __('The image size cannot exceed 2MB.'),
            'remove_photo.boolean' => __('The remove photo value must be a boolean.'),
        ];
    }
}