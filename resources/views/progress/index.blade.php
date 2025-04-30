<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10">
            {{ __('Progress Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-xl ">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('progress.create') }}" class="inline-flex items-center px-4 py-2  dark:bg-white border border-transparent rounded-md font-Cal font-bold text-l text-black dark:text-black uppercase tracking-widest hover:bg-white dark:hover:bg-gray-100 dark:focus:bg-white-700 focus:ring dark:focus:ring-white active:bg-indigo-700 dark:active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Add New Entry') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 dark:bg-green-700 border-l-4 border-green-500 dark:border-green-300 text-green-700 dark:text-green-300 p-4" role="alert">
                            <p class="font-bold">{{ __('Success') }}</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if ($progressEntries->isEmpty())
                        <p>{{ __('No progress entries yet. Click "Add New Entry" to get started.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-black-900">
                                <thead class="bg-gray-50 dark:bg-gray-200 text-black">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                            {{ __('Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                            {{ __('Weight (kg)') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                            {{ __('Height (cm)') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                            {{ __('BMI') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                            {{ __('Body Fat (%)') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                            {{ __('Muscle Mass') }}
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">{{ __('Actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-900">
                                    @foreach ($progressEntries as $entry)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $entry->tracked_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $entry->weight_kg ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $entry->height_cm ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $entry->bmi ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $entry->body_fat_percentage ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $entry->muscle_mass ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                                                <a href="{{ route('progress.edit', $entry) }}" class="inline-flex items-center px-4 py-2  dark:bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-yellow-500 dark:hover:bg-yellow-600 focus:bg-yellow-500 dark:focus:bg-yellow-700 focus:ring dark:focus:ring-yellow-500 active:bg-indigo-700 dark:active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" style=" text-shadow: 1px 1px 2px black;">
                                                    {{ __('Edit') }}
                                                </a>
                                                <form method="POST" action="{{ route('progress.destroy', $entry) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-4 py-2  dark:bg-black border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest  dark:hover:bg-gray-600  dark:focus:bg-gray-700 focus:ring dark:focus:ring-gray-500 dark:active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" style=" text-shadow: 1px 1px 2px black;" onclick="return confirm('{{ __('Are you sure you want to delete this entry?') }}')">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8 mb-6">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-black leading-tight mb-4">{{ __('Weight Progress') }}</h3>
                        <canvas id="weightChart"></canvas>
                    </div>
                <hr style="color: black; font-weight:bolder">
                    <div class="mt-6">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-black leading-tight mb-4">{{ __('BMI Progress') }}</h3>
                        <canvas id="bmiChart"></canvas>
                    </div>
                        <div class="mt-4">
                            {{ $progressEntries->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
            const weightData = {
                labels: @json($progressEntries->pluck('tracked_at')->map(function ($date) {
                    return $date->format('Y-m-d');
                })->reverse()->values()),
                datasets: [{
                    label: '{{ __("Weight (kg)") }}',
                    data: @json($progressEntries->pluck('weight_kg')->reverse()->values()),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            };

            const bmiData = {
                labels: @json($progressEntries->pluck('tracked_at')->map(function ($date) {
                    return $date->format('Y-m-d');
                })->reverse()->values()),
                datasets: [{
                    label: '{{ __("BMI") }}',
                    data: @json($progressEntries->pluck('bmi')->reverse()->values()),
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                }]
            };

            const weightConfig = {
                type: 'line',
                data: weightData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            };

            const bmiConfig = {
                type: 'line',
                data: bmiData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            };

            const weightChart = new Chart(
                document.getElementById('weightChart'),
                weightConfig
            );

            const bmiChart = new Chart(
                document.getElementById('bmiChart'),
                bmiConfig
            );
        </script>
        @endpush
</x-app-layout>