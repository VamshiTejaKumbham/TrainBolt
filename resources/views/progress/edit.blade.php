<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10 leading-tight">
            {{ __('Edit Progress Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('progress.update', $progress) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="tracked_at" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Tracking Date') }}</label>
                            <input id="tracked_at" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" type="datetime-local" name="tracked_at" value="{{ old('tracked_at', $progress->tracked_at->format('Y-m-d\TH:i')) }}" required autofocus />
                            @error('tracked_at')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="weight_kg" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Weight (kg)') }}</label>
                            <input id="weight_kg" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" type="number" step="0.01" name="weight_kg" value="{{ old('weight_kg', $progress->weight_kg) }}" />
                            @error('weight_kg')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="height_cm" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Height (cm)') }}</label>
                            <input id="height_cm" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" type="number" step="0.01" name="height_cm" value="{{ old('height_cm', $progress->height_cm) }}" />
                            @error('height_cm')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="age" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Age') }}</label>
                            <input id="age" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" type="number" name="age" value="{{ old('age', $progress->age) }}" required min="1" max="120" />
                            @error('age')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="gender" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Gender') }}</label>
                            <select id="gender" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" name="gender" required>
                                <option value="">{{ __('Select Gender') }}</option>
                                <option value="male" {{ old('gender', $progress->gender) === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                <option value="female" {{ old('gender', $progress->gender) === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                            </select>
                            @error('gender')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="body_fat_percentage" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Body Fat (%) (Optional)') }}</label>
                            <input id="body_fat_percentage" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" type="number" step="0.01" name="body_fat_percentage" value="{{ old('body_fat_percentage', $progress->body_fat_percentage) }}" />
                            @error('body_fat_percentage')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="muscle_mass" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Muscle Mass (Optional)') }}</label>
                            <input id="muscle_mass" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" type="number" step="0.01" name="muscle_mass" value="{{ old('muscle_mass', $progress->muscle_mass) }}" />
                            @error('muscle_mass')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="photo" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Progress Photo (Optional)') }}</label>
                            <input id="photo" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" type="file" name="photo" accept="image/*" />
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror

                            @if ($progress->photo_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $progress->photo_path) }}" alt="Progress Photo" class="max-h-40 rounded-md">
                                    <label for="remove_photo" class="inline-flex items-center mt-2">
                                        <input type="checkbox" id="remove_photo" name="remove_photo" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-indigo-500 dark:focus:ring-indigo-600">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remove Photo') }}</span>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2  dark:bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-yellow-500 dark:hover:bg-yellow-600 focus:bg-yellow-500 dark:focus:bg-yellow-700 focus:ring dark:focus:ring-yellow-500 active:bg-indigo-700 dark:active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" style=" text-shadow: 1px 1px 2px black;">
                                {{ __('Update Entry') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>