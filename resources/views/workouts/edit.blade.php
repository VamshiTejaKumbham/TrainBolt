<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10 leading-tight">
            {{ __('Edit Workout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('workouts.update', $workout) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="workout_date" :value="__('Workout Date')" />
                            <x-text-input id="workout_date" class="block mt-1 w-full" type="date" name="workout_date" :value="old('workout_date', $workout->workout_date->format('Y-m-d'))" required autofocus />
                            <x-input-error :messages="$errors->get('workout_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Workout Name (Optional)')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $workout->name)" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duration (minutes, Optional)')" />
                            <x-text-input id="duration" class="block mt-1 w-full" type="number" name="duration" :value="old('duration', $workout->duration)" min="0" />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="notes" :value="__('Workout Notes (Optional)')" />
                            <textarea id="notes" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" name="notes">{{ old('notes', $workout->notes ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <h3 class="font-semibold dark:text-gray-300 mb-2">{{ __('Exercises') }}</h3>
                            <div id="exercises-container">
    @foreach (old('exercises', $workoutExercisesData ?? []) as $index => $exerciseData)
        <div class="mb-4 exercise-row">
            <div class="grid grid-cols-7 gap-4">
                <div>
                    <x-input-label for="exercises.{{ $index }}.exercise_id" :value="__('Exercise')" />
                    <select id="exercises.{{ $index }}.exercise_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 exercise-select" name="exercises[{{ $index }}][exercise_id]">
                        <option value="">{{ __('Custom Exercise') }}</option>
                        @foreach ($exercises as $allExercise)
                            <option value="{{ $allExercise->id }}" @if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id'] == $allExercise->id) selected @endif>{{ $allExercise->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('exercises.' . $index . '.exercise_id')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="exercises.{{ $index }}.custom_exercise_name" :value="__('Custom Name')" />
                    <input type="text" name="exercises[{{ $index }}][custom_exercise_name]" class="block mt-1 w-full custom-exercise-name dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" value="{{ $exerciseData['custom_exercise_name'] ?? '' }}" @if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id']) readonly @endif />
                    <x-input-error :messages="$errors->get('exercises.' . $index . '.custom_exercise_name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="exercises.{{ $index }}.sets" :value="__('Sets')" />
                    <input type="number" name="exercises[{{ $index }}][sets]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" min="1" value="{{ $exerciseData['sets'] ?? '' }}" @if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id']) readonly @endif />
                    <x-input-error :messages="$errors->get('exercises.' . $index . '.sets')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="exercises.{{ $index }}.reps" :value="__('Reps')" />
                    <input type="number" name="exercises[{{ $index }}][reps]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" min="1" value="{{ $exerciseData['reps'] ?? '' }}" @if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id']) readonly @endif />
                    <x-input-error :messages="$errors->get('exercises.' . $index . '.reps')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="exercises.{{ $index }}.weight" :value="__('Weight (kg)')" />
                    <input type="number" step="0.01" name="exercises[{{ $index }}][weight]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" min="0" value="{{ $exerciseData['weight'] ?? '' }}" @if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id']) readonly @endif />
                    <x-input-error :messages="$errors->get('exercises.' . $index . '.weight')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="exercises.{{ $index }}.duration" :value="__('Duration (seconds)')" />
                    <input type="number" name="exercises[{{ $index }}][duration]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" min="1" value="{{ $exerciseData['duration'] ?? '' }}" @if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id']) readonly @endif />
                    <x-input-error :messages="$errors->get('exercises.' . $index . '.duration')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="exercises.{{ $index }}.notes" :value="__('Notes')" />
                    <input type="text" name="exercises[{{ $index }}][notes]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" value="{{ $exerciseData['notes'] ?? '' }}" @if (isset($exerciseData['exercise_id']) && $exerciseData['exercise_id']) readonly @endif />
                    <x-input-error :messages="$errors->get('exercises.' . $index . '.notes')" class="mt-2" />
                </div>
                <button type="button" class="remove-exercise-row text-red-500 hover:text-red-700 self-end">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12-3v8m-13-3h12a9 9 0 0 1-9 9H4a9 9 0 0 1 9-9z" />
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
</div>
                            <button type="button" id="add-exercise-row" class="mt-2 text-indigo-600 hover:text-indigo-800">
                                {{ __('Add Exercise') }}
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Workout') }}
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
    let exerciseRowCount = exercisesContainer.children.length;

    addExerciseRowButton.addEventListener('click', function () {
        const newRow = document.createElement('div');
        newRow.classList.add('mb-4', 'exercise-row');
        newRow.innerHTML = `
            <div class="grid grid-cols-7 gap-4">
                <div>
                    <label for="exercises.${exerciseRowCount}.exercise_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Exercise') }}</label>
                    <select id="exercises.${exerciseRowCount}.exercise_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 exercise-select" name="exercises[${exerciseRowCount}][exercise_id]">
                        <option value="">{{ __('Custom Exercise') }}</option>
                        @foreach ($exercises as $exercise)
                            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                        @endforeach
                    </select>
                    <span class="mt-2 text-red-500 error-exercises.${exerciseRowCount}.exercise_id"></span>
                </div>
                <div>
                    <label for="exercises.${exerciseRowCount}.custom_exercise_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Custom Name') }}</label>
                    <input type="text" name="exercises[${exerciseRowCount}][custom_exercise_name]" class="block mt-1 w-full custom-exercise-name dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" />
                    <span class="mt-2 text-red-500 error-exercises.${exerciseRowCount}.custom_exercise_name"></span>
                </div>
                <div>
                    <label for="exercises.${exerciseRowCount}.sets" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Sets') }}</label>
                    <input type="number" name="exercises[${exerciseRowCount}][sets]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" min="1" />
                    <span class="mt-2 text-red-500 error-exercises.${exerciseRowCount}.sets"></span>
                </div>
                <div>
                    <label for="exercises.${exerciseRowCount}.reps" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Reps') }}</label>
                    <input type="number" name="exercises[${exerciseRowCount}][reps]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" min="1" />
                    <span class="mt-2 text-red-500 error-exercises.${exerciseRowCount}.reps"></span>
                </div>
                <div>
                    <label for="exercises.${exerciseRowCount}.weight" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Weight (kg)') }}</label>
                    <input type="number" step="0.01" name="exercises[${exerciseRowCount}][weight]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" min="0" />
                    <span class="mt-2 text-red-500 error-exercises.${exerciseRowCount}.weight"></span>
                </div>
                <div>
                    <label for="exercises.${exerciseRowCount}.duration" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Duration (seconds)') }}</label>
                    <input type="number" name="exercises[${exerciseRowCount}][duration]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" min="1" />
                    <span class="mt-2 text-red-500 error-exercises.${exerciseRowCount}.duration"></span>
                </div>
                <div>
                    <label for="exercises.${exerciseRowCount}.notes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Notes') }}</label>
                    <input type="text" name="exercises[${exerciseRowCount}][notes]" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" />
                    <span class="mt-2 text-red-500 error-exercises.${exerciseRowCount}.notes"></span>
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
            const setsInput = row.querySelector('input[name$="[sets]"]');
            const repsInput = row.querySelector('input[name$="[reps]"]');
            const weightInput = row.querySelector('input[name$="[weight]"]');
            const durationInput = row.querySelector('input[name$="[duration]"]');
            const notesInput = row.querySelector('input[name$="[notes]"]');

            if (event.target.value) {
                customNameInput.value = '';
                customNameInput.disabled = true;
                customNameInput.setAttribute('readonly', 'readonly');
                setsInput.removeAttribute('readonly');
                repsInput.removeAttribute('readonly');
                weightInput.removeAttribute('readonly');
                durationInput.removeAttribute('readonly');
                notesInput.removeAttribute('readonly');
                setsInput.value = "{{ $exerciseData['sets'] ?? '' }}"; // Consider how to handle default values for new rows
                repsInput.value = "{{ $exerciseData['reps'] ?? '' }}";
                weightInput.value = "{{ $exerciseData['weight'] ?? '' }}";
                durationInput.value = "{{ $exerciseData['duration'] ?? '' }}";
                notesInput.value = "{{ $exerciseData['notes'] ?? '' }}";
            } else {
                customNameInput.disabled = false;
                customNameInput.removeAttribute('readonly');
                setsInput.setAttribute('readonly', 'readonly');
                repsInput.setAttribute('readonly', 'readonly');
                weightInput.setAttribute('readonly', 'readonly');
                durationInput.setAttribute('readonly', 'readonly');
                notesInput.setAttribute('readonly', 'readonly');
                setsInput.value = '';
                repsInput.value = '';
                weightInput.value = '';
                durationInput.value = '';
                notesInput.value = '';
            }
        }
    });
});
        </script>
    @endpush
</x-app-layout>