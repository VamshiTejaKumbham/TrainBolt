<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10 leading-tight">
            {{ __('Edit Meal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('diet.update', $meal) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="food_description" :value="__('Food Description')" />
                            <x-text-input id="food_description" class="block mt-1 w-full" type="text" name="food_description" :value="old('food_description', $meal->food_description)" required autofocus />
                            <x-input-error :messages="$errors->get('food_description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="calories" :value="__('Calories')" />
                            <x-text-input id="calories" class="block mt-1 w-full" type="number" name="calories" :value="old('calories', $meal->calories)" required />
                            <x-input-error :messages="$errors->get('calories')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="protein" :value="__('Protein (g)')" />
                            <x-text-input id="protein" class="block mt-1 w-full" type="number" step="0.01" name="protein" :value="old('protein', $meal->protein)" />
                            <x-input-error :messages="$errors->get('protein')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="carbs" :value="__('Carbs (g)')" />
                            <x-text-input id="carbs" class="block mt-1 w-full" type="number" step="0.01" name="carbs" :value="old('carbs', $meal->carbs)" />
                            <x-input-error :messages="$errors->get('carbs')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="fats" :value="__('Fats (g)')" />
                            <x-text-input id="fats" class="block mt-1 w-full" type="number" step="0.01" name="fats" :value="old('fats', $meal->fats)" />
                            <x-input-error :messages="$errors->get('fats')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="meal_time" :value="__('Meal Time')" />
                            <x-text-input id="meal_time" class="block mt-1 w-full" type="datetime-local" name="meal_time" :value="old('meal_time', $meal->meal_time ? $meal->meal_time->format('Y-m-d\TH:i') : '')" />
                            <x-input-error :messages="$errors->get('meal_time')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Meal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>