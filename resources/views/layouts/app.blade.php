<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="is-admin" content="{{ auth()->user()->is_admin ? 'true' : 'false' }}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('img/Icon.png') }}" type="image/x-icon" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--background);
        }

        @keyframes spin-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        .animate-fade-in {
            animation: fade-in 2s ease-in-out forwards;
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen bg-[#F0F0F0] flex flex-col">
        <livewire:layout.navigation />

        <!-- Enhanced Header -->
        @if (isset($header))
            <header class=" text-white shadow-lg"
                style="background: linear-gradient(to left, black, #2A3C4D 50%, black),
            linear-gradient(to right, black, black 50%, black);
background-blend-mode: screen;">
                <div class="max-w-7xl mx-auto py-5 px-6 sm:px-8 lg:px-8">
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-center">
                        {{ $header }}
                    </h1>
                </div>
            </header>
        @endif


        <!-- Enhanced Main Content -->
        <main class="flex-grow py-12"
            style="background: linear-gradient(to left, black, #2A3C4D 50%, black),
                  linear-gradient(to right, black, black 50%, black);
      background-blend-mode: screen;
">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-8 rounded-xl shadow-lg" style="background: radial-gradient(circle, #2C3E50, black);">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    @stack('scripts')
    @livewireScripts
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
</body>

</html>
