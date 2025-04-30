<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10 leading-tight">
            {{ __('Log New Workout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('workouts.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="workout_date" :value="__('Workout Date')" />
                            <x-text-input id="workout_date" class="block mt-1 w-full" type="date" name="workout_date" :value="old('workout_date', now()->toDateString())" required autofocus />
                            <x-input-error :messages="$errors->get('workout_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Workout Name (Optional)')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duration (minutes, Optional)')" />
                            <x-text-input id="duration" class="block mt-1 w-full" type="number" name="duration" :value="old('duration')" min="0" />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="notes" :value="__('Workout Notes (Optional)')" />
                            <textarea id="notes" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" name="notes">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <h3 class="font-semibold dark:text-gray-300 mb-2">{{ __('Exercises') }}</h3>
                            <div id="exercises-container">
                                <div class="mb-4 exercise-row">
                                    <div class="grid grid-cols-6 gap-4">
                                        <div>
                                            <x-input-label for="exercises.0.exercise_id" :value="__('Exercise')" />
                                            <select id="exercises.0.exercise_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 exercise-select" name="exercises[0][exercise_id]">
                                                <option value="">{{ __('Custom Exercise') }}</option>
                                                @foreach ($exercises as $exercise)
                                                    <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('exercises.0.exercise_id')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="exercises.0.custom_exercise_name" :value="__('Custom Name')" />
                                            <x-text-input type="text" name="exercises[0][custom_exercise_name]" class="block mt-1 w-full custom-exercise-name" />
                                            <x-input-error :messages="$errors->get('exercises.0.custom_exercise_name')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="exercises.0.sets" :value="__('Sets')" />
                                            <x-text-input type="number" name="exercises[0][sets]" class="block mt-1 w-full" min="1" />
                                            <x-input-error :messages="$errors->get('exercises.0.sets')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="exercises.0.reps" :value="__('Reps')" />
                                            <x-text-input type="number" name="exercises[0][reps]" class="block mt-1 w-full" min="1" />
                                            <x-input-error :messages="$errors->get('exercises.0.reps')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="exercises.0.weight" :value="__('Weight (kg)')" />
                                            <x-text-input type="number" step="0.01" name="exercises[0][weight]" class="block mt-1 w-full" min="0" />
                                            <x-input-error :messages="$errors->get('exercises.0.weight')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="exercises.0.duration" :value="__('Duration (seconds)')" />
                                            <x-text-input type="number" name="exercises[0][duration]" class="block mt-1 w-full" min="1" />
                                            <x-input-error :messages="$errors->get('exercises.0.duration')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="exercises.0.notes" :value="__('Notes')" />
                                            <x-text-input type="text" name="exercises[0][notes]" class="block mt-1 w-full" />
                                            <x-input-error :messages="$errors->get('exercises.0.notes')" class="mt-2" />
                                        </div>
                                        <button type="button" class="remove-exercise-row text-red-500 hover:text-red-700 self-end">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12-3v8m-13-3h12a9 9 0 0 1-9 9H4a9 9 0 0 1 9-9z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-exercise-row" class="mt-2 text-indigo-600 hover:text-indigo-800">
                                {{ __('Add Exercise') }}
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Log Workout') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const exercisesContainer = document.getElementById('exercises-container');
                const addExerciseRowButton = document.getElementById('add-exercise-row');
                let exerciseRowCount = 1;

                addExerciseRowButton.addEventListener('click', function () {
                    const newRow = document.createElement('div');
                    newRow.classList.add('mb-4', 'exercise-row');
                    newRow.innerHTML = `
                        <div class="grid grid-cols-6 gap-4">
                            <div>
                                <x-input-label for="exercises.${exerciseRowCount}.exercise_id" :value="__('Exercise')" />
                                <select id="exercises.${exerciseRowCount}.exercise_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 exercise-select" name="exercises[${exerciseRowCount}][exercise_id]">
                                    <option value="">{{ __('Custom Exercise') }}</option>
                                    @foreach ($exercises as $exercise)
                                        <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('exercises.${exerciseRowCount}.exercise_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="exercises.${exerciseRowCount}.custom_exercise_name" :value="__('Custom Name')" />
                                <x-text-input type="text" name="exercises[${exerciseRowCount}][custom_exercise_name]" class="block mt-1 w-full custom-exercise-name" />
                                <x-input-error :messages="$errors->get('exercises.${exerciseRowCount}.custom_exercise_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="exercises.${exerciseRowCount}.sets" :value="__('Sets')" />
                                <x-text-input type="number" name="exercises[${exerciseRowCount}][sets]" class="block mt-1 w-full" min="1" />
                                <x-input-error :messages="$errors->get('exercises.${exerciseRowCount}.sets')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="exercises.${exerciseRowCount}.reps" :value="__('Reps')" />
                                <x-text-input type="number" name="exercises[${exerciseRowCount}][reps]" class="block mt-1 w-full" min="1" />
                                <x-input-error :messages="$errors->get('exercises.${exerciseRowCount}.reps')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="exercises.${exerciseRowCount}.weight" :value="__('Weight (kg)')" />
                                <x-text-input type="number" step="0.01" name="exercises[${exerciseRowCount}][weight]" class="block mt-1 w-full" min="0" />
                                <x-input-error :messages="$errors->get('exercises.${exerciseRowCount}.weight')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="exercises.${exerciseRowCount}.duration" :value="__('Duration (seconds)')" />
                                <x-text-input type="number" name="exercises[${exerciseRowCount}][duration]" class="block mt-1 w-full" min="1" />
                                <x-input-error :messages="$errors->get('exercises.${exerciseRowCount}.duration')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="exercises.${exerciseRowCount}.notes" :value="__('Notes')" />
                                <x-text-input type="text" name="exercises[${exerciseRowCount}][notes]" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('exercises.${exerciseRowCount}.notes')" class="mt-2" />
                            </div>
                            <button type="button" class="remove-exercise-row text-red-500 hover:text-red-700 self-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12-3v8m-13-3h12a9 9 0 0 1-9 9H4a9 9 0 0 1 9-9z" />
                                </svg>
                            </button>
                        </div>
                    `;
                    exercisesContainer.appendChild(newRow);
                    exerciseRowCount++;
                });

                exercisesContainer.addEventListener('click', function (event) {
                    if (event.target.classList.contains('remove-exercise-row') || event.target.closest('.remove-exercise-row')) {
                        if (exercisesContainer.children.length > 1) {
                            event.target.closest('.exercise-row').remove();
                        } else {
                            alert('{{ __('You must have at least one exercise.') }}');
                        }
                    }
                });

                exercisesContainer.addEventListener('change', function (event) {
                    if (event.target.classList.contains('exercise-select')) {
                        const row = event.target.closest('.exercise-row');
                        const customNameInput = row.querySelector('.custom-exercise-name');
                        if (event.target.value) {
                            customNameInput.value = '';
                            customNameInput.disabled = true;
                            customNameInput.setAttribute('readonly', 'readonly');
                            row.querySelectorAll('input[name$="[sets]"], input[name$="[reps]"], input[name$="[weight]"], input[name$="[duration]"], input[name$="[notes]"]').forEach(input => input.removeAttribute('readonly'));
                        } else {
                            customNameInput.disabled = false;
                            customNameInput.removeAttribute('readonly');
                            row.querySelectorAll('input[name$="[sets]"], input[name$="[reps]"], input[name$="[weight]"], input[name$="[duration]"], input[name$="[notes]"]').forEach(input => input.setAttribute('readonly', 'readonly'));
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>