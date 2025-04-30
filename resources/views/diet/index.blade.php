<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10 leading-tight">
            {{ __('Diet Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-6">
    <a href="{{ route('diet.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-indigo-500 dark:hover:bg-indigo-700 focus:bg-indigo-500 dark:focus:bg-indigo-700 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-500 active:bg-indigo-700 dark:active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
        {{ __('Add New Meal') }}
    </a>
</div>

                    @if (session('success'))
                        <div class="bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-200 border border-green-400 dark:border-green-500 rounded-md p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-2 dark:text-gray-300">{{ __('Today\'s Summary') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-md p-4">
                            <span class="font-semibold dark:text-gray-300">{{ __('Calories:') }}</span>
                            <span class="dark:text-gray-400">{{ $dailySummary['calories'] }}</span>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-md p-4">
                            <span class="font-semibold dark:text-gray-300">{{ __('Protein:') }}</span>
                            <span class="dark:text-gray-400">{{ $dailySummary['protein'] }}g</span>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-md p-4">
                            <span class="font-semibold dark:text-gray-300">{{ __('Carbs:') }}</span>
                            <span class="dark:text-gray-400">{{ $dailySummary['carbs'] }}g</span>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-md p-4">
                            <span class="font-semibold dark:text-gray-300">{{ __('Fats:') }}</span>
                            <span class="dark:text-gray-400">{{ $dailySummary['fats'] }}g</span>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-2 dark:text-gray-300">{{ __('Today\'s Meals') }}</h3>
                    @if ($dailyMeals->isEmpty())
                        <p class="dark:text-gray-400">{{ __('No meals logged for today.') }}</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($dailyMeals as $meal)
                                <li class="bg-gray-100 dark:bg-gray-700 rounded-md p-4 flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold dark:text-gray-300">{{ $meal->food_description }}</h4>
                                        <p class="text-sm dark:text-gray-400">
                                            {{ __('Calories:') }} {{ $meal->calories }} |
                                            {{ __('Protein:') }} {{ $meal->protein ?? 0 }}g |
                                            {{ __('Carbs:') }} {{ $meal->carbs ?? 0 }}g |
                                            {{ __('Fats:') }} {{ $meal->fats ?? 0 }}g |
                                            {{ __('Time:') }} {{ $meal->meal_time->format('h:i A') }}
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                    <a href="{{ route('diet.edit', $meal) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-indigo-500 dark:hover:bg-indigo-700 focus:bg-indigo-500 dark:focus:bg-indigo-700 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-500 active:bg-indigo-700 dark:active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
    {{ __('Edit') }}
</a>
                                        <form method="POST" action="{{ route('diet.destroy', $meal) }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button onclick="return confirm('{{ __('Are you sure you want to delete this meal?') }}')">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <h3 class="text-lg font-semibold mt-6 mb-2 dark:text-gray-300">{{ __('Weekly Summary') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Date') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Calories') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Protein (g)') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Carbs (g)') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Fats (g)') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach ($weeklySummary as $date => $summary)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ \Carbon\Carbon::parse($date)->format('D, M j') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-400">{{ $summary['calories'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-400">{{ $summary['protein'] ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-400">{{ $summary['carbs'] ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-400">{{ $summary['fats'] ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h3 class="text-lg font-semibold mt-6 mb-2 dark:text-gray-300">{{ __('Weekly Nutrition Breakdown') }}</h3>
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-md p-4">
                        <canvas id="weeklyNutritionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const weeklyData = JSON.parse('{!! json_encode($weeklySummary) !!}');
            const labels = Object.keys(weeklyData).map(date => new Date(date).toLocaleDateString(undefined, { weekday: 'short', day: 'numeric' }));
            const caloriesData = Object.values(weeklyData).map(day => day.calories);
            const proteinData = Object.values(weeklyData).map(day => day.protein || 0);
            const carbsData = Object.values(weeklyData).map(day => day.carbs || 0);
            const fatsData = Object.values(weeklyData).map(day => day.fats || 0);

            const ctx = document.getElementById('weeklyNutritionChart').getContext('2d');
            const weeklyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Calories',
                        data: caloriesData,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Protein (g)',
                        data: proteinData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Carbs (g)',
                        data: carbsData,
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Fats (g)',
                        data: fatsData,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount'
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    @endpush
</x-app-layout>