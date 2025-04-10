<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartCard') }}</title>

        <!-- FONTS -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- FLOWBITE CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

        <!-- VITE SCRIPTS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex justify-center items-center bg-gray-200 dark:bg-gray-900">
            <div class="w-full max-w-5xl overflow-hidden">
                {{ $slot }}
            </div>
        </div>

        <!-- FLOWBITE JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

        {{-- BACKEND JS --}}
        <script src="{{ asset('JS/Backend/Darkmode.js') }}"></script>
        <script src="{{ asset('JS/Backend/Secure.js') }}"></script>

    </body>
</html>
