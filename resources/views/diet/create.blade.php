<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10 leading-tight">
            {{ __('Add New Meal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-400 overflow-hidden shadow-xl ">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('diet.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="food_description" :value="__('Food Description')" />
                            <x-text-input id="food_description" class="block mt-1 w-full" type="text" name="food_description" :value="old('food_description')" required autofocus />
                            <x-input-error :messages="$errors->get('food_description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="calories" :value="__('Calories')" />
                            <x-text-input id="calories" class="block mt-1 w-full" type="number" name="calories" :value="old('calories')" required />
                            <x-input-error :messages="$errors->get('calories')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="protein" :value="__('Protein (g)')" />
                            <x-text-input id="protein" class="block mt-1 w-full" type="number" step="0.01" name="protein" :value="old('protein')" />
                            <x-input-error :messages="$errors->get('protein')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="carbs" :value="__('Carbs (g)')" />
                            <x-text-input id="carbs" class="block mt-1 w-full" type="number" step="0.01" name="carbs" :value="old('carbs')" />
                            <x-input-error :messages="$errors->get('carbs')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="fats" :value="__('Fats (g)')" />
                            <x-text-input id="fats" class="block mt-1 w-full" type="number" step="0.01" name="fats" :value="old('fats')" />
                            <x-input-error :messages="$errors->get('fats')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="meal_time" :value="__('Meal Time (optional)')" />
                            <x-text-input id="meal_time" class="block mt-1 w-full" type="datetime-local" name="meal_time" :value="old('meal_time')" />
                            <x-input-error :messages="$errors->get('meal_time')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-black">{{ __('Leave blank to use the current time.') }}</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Add Meal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>