<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
        style="background: linear-gradient(to left, black, #2A3C4D 50%, black),
    linear-gradient(to right, black, black 50%, black);
    background-blend-mode: screen;">
        <div class="justify-center ">
            <div class="flex justify-between m-5 items-center">
                <img src="{{ asset('img/Logo6.png') }}" alt="Logo" class="w-30 h-20">
                <span class="text-white text-4xl max-md:text-2xl font-bold h-10 ">Gatot AC Mobil</span>
            </div>
        </div>

        <div
            class="w-full sm:max-w-md mb-20 mt-6 px-6 py-4 bg-white dark:bg-gray-900 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
