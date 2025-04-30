@vite(['resources/css/app.css', 'resources/js/app.js'])
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight mt-10 leading-tight">
            {{ __('Workout Guide') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="" style=" display:flex;">
                <div class="p-6 text-black dark:text-black leading-tight">
                    <h1 class="text-2xl font-semibold mb-4">{{ __('Browse Exercises') }}</h1>

                    @forelse ($categorizedWorkouts as $muscleGroup => $workouts)
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold mb-2 cursor-pointer" onclick="toggleSection('{{ Str::slug($muscleGroup) }}')">
                                {{ __($muscleGroup) }}
                                <svg id="arrow-{{ Str::slug($muscleGroup) }}" class="inline w-4 h-4 ml-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h2>
                            <div id="section-{{ Str::slug($muscleGroup) }}" class="hidden mt-2">
                                <ul class="list-disc ml-6">
                                    @foreach ($workouts as $workout)
                                        <li class="mb-2">
                                            <span class="font-medium cursor-pointer" onclick="toggleDetails('{{ Str::slug($workout['name']) }}')">
                                                {{ $workout['name'] }}
                                                <svg id="details-arrow-{{ Str::slug($workout['name']) }}" class="inline w-4 h-4 ml-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </span>
                                            <div id="details-{{ Str::slug($workout['name']) }}" class="hidden mt-2 ml-6">
                                                <p class="mb-1"><span class="font-semibold">{{ __('Primary Muscle:') }}</span> {{ __($workout['primaryMuscle'] ?? '-') }}</p>
                                                <p class="mb-1"><span class="font-semibold">{{ __('Secondary Muscle:') }}</span> {{ __($workout['secondaryMuscle'] ?? '-') }}</p>
                                                <p class="mb-1"><span class="font-semibold">{{ __('Description:') }}</span> {!! nl2br(e($workout['description'] ?? '-')) !!}</p>
                                                <div class="mb-1"><span class="font-semibold">{{ __('How to Perform:') }}</span> <div class="mt-1 ml-2">{!! $workout['howToPerform'] ?? '-' !!}</div></div>
                                                <p class="mb-1"><span class="font-semibold">{{ __('Equipment Needed:') }}</span> {{ __($workout['equipmentNeeded'] ?? __('None')) }}</p>
                                                @if (isset($workout['image']) || isset($workout['video']))
                                                    <div class="mt-2">
                                                        @isset($workout['image'])
                                                            <img src="{{ asset('storage/' . $workout['image']) }}" alt="{{ $workout['name'] }}" class="max-w-full h-auto rounded-md">
                                                        @endisset
                                                        @isset($workout['video'])
                                                            <video src="{{ asset('storage/' . $workout['video']) }}" controls class="max-w-full h-auto rounded-md"></video>
                                                        @endisset
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <p>{{ __('No exercises found in the guide.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleSection(id) {
                const section = document.getElementById('section-' + id);
                const arrow = document.getElementById('arrow-' + id);
                section.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            }

            function toggleDetails(id) {
                const details = document.getElementById('details-' + id);
                const arrow = document.getElementById('details-arrow-' + id);
                details.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            }
        </script>
    @endpush
</x-app-layout>