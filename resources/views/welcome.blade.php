<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    </head>
    <body class="bg-[#FFFFFF] text-[#000000] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="w-full lg:max-w-4xl max-w-[335px] flex flex-col items-center">
        
        <!-- Logo and Tagline -->
        <section class="hero mb-8 text-center mt-4">
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Fitness Journey" class="w-[300px] h-[300px] object-cover mb-4" style="">
                <h1 class="text-xl lg:text-3xl font-semibold font-poppins">Start logging your fitness journey!</h1>
            </div>
        </section>

        <!-- Auth Buttons -->
        @if (Route::has('login'))
            <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 mb-6">
                @auth
                    {{-- Authenticated user content can go here if needed --}}
                @else
                    <a
                        href="{{ route('login') }}"
                        class="text-black font-medium hover:color-yellow font-poppins py-2 px-6  transition duration-300"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="bg-black hover:bg-yellow-500 text-white font-medium font-poppins py-2 px-6 transition duration-300"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Footer -->
        <footer class="text-center text-gray-500 text-xs mt-10">
            &copy; {{ date('Y') }} Train Bolt
        </footer>
    </div>
</body>
</html>
