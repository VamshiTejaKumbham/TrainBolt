<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10 leading-tight">
            {{ __('Workout Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <a href="{{ route('workouts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-indigo-500 dark:hover:bg-indigo-700 focus:bg-indigo-500 dark:focus:bg-indigo-700 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-500 active:bg-indigo-700 dark:active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Log New Workout') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-200 border border-green-400 dark:border-green-500 rounded-md p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4 dark:text-gray-300">{{ __('Workout History') }}</h3>

                    @if ($workouts->isEmpty())
                        <p class="dark:text-gray-400">{{ __('No workouts logged yet.') }}</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($workouts as $workout)
                                <li class="bg-gray-100 dark:bg-gray-700 rounded-md p-4 flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold dark:text-gray-300">{{ $workout->name ?? __('Workout on') }} {{ $workout->workout_date->format('D, M j, Y') }}</h4>
                                        <p class="text-sm dark:text-gray-400">
                                            {{ __('Date:') }} {{ $workout->workout_date->format('Y-m-d') }}
                                            @if ($workout->duration)
                                                | {{ __('Duration:') }} {{ $workout->duration }} {{ __('minutes') }}
                                            @endif
                                            @if ($workout->notes)
                                                | {{ __('Notes:') }} {{ Str::limit($workout->notes, 50) }}
                                            @endif
                                        </p>
                                        @if ($workout->exercises->isNotEmpty() || $workout->workoutExercises()->where('exercise_id', null)->count() > 0)
                                            <div class="mt-2">
                                                <span class="font-semibold dark:text-gray-300">{{ __('Exercises:') }}</span>
                                                <ul class="list-disc list-inside text-sm dark:text-gray-400">
                                                    @foreach ($workout->exercises as $exercise)
                                                        <li>{{ $exercise->name }}
                                                            @if ($exercise->pivot->sets || $exercise->pivot->reps || $exercise->pivot->weight || $exercise->pivot->duration)
                                                                ({{ $exercise->pivot->sets ?? '-' }} sets, {{ $exercise->pivot->reps ?? '-' }} reps, {{ $exercise->pivot->weight ?? '-' }} kg, {{ $exercise->pivot->duration ? $exercise->pivot->duration . 's' : '-' }})
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                    @foreach ($workout->workoutExercises()->where('exercise_id', null)->get() as $customExercise)
                                                        <li>{{ $customExercise->custom_exercise_name }}
                                                            @if ($customExercise->sets || $customExercise->reps || $customExercise->weight || $customExercise->duration)
                                                                ({{ $customExercise->sets ?? '-' }} sets, {{ $customExercise->reps ?? '-' }} reps, {{ $customExercise->weight ?? '-' }} kg, {{ $customExercise->duration ? $customExercise->duration . 's' : '-' }})
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @else
                                            <p class="text-sm dark:text-gray-400">{{ __('No exercises logged for this workout.') }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('workouts.edit', $workout) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-indigo-500 dark:hover:bg-indigo-700 focus:bg-indigo-500 dark:focus:bg-indigo-700 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-500 active:bg-indigo-700 dark:active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('workouts.destroy', $workout) }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button onclick="return confirm('{{ __('Are you sure you want to delete this workout?') }}')">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-6">
                            {{ $workouts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>