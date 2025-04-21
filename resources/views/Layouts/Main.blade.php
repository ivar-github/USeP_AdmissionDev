<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartCard') }}</title>

        <!-- FONTS -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        {{-- CSS --}}
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"  />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" />

        @stack('styles')

        {{-- DATATABLES --}}
        <link   rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

        {{-- AXIOS CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- TAILWIND-VITE -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-300 dark:bg-gray-900">
            @include('Layouts.Components.Navigation')
            @include('Layouts.Components.Sidebar')
            @include('Layouts.Components.Content')

            {{-- <!-- HEADING -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- CONTENT -->
            <main>
                <div class="py-5"></div>
                {{ $slot }}
                <x-Footer/>
            </main> --}}
        </div>


        <!-- FLOWBITE JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        {{-- DATATABLES --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

        {{-- SCRIPTS --}}
        @stack('scripts')

        {{-- BACKEND JS --}}
        <script src="{{ asset('JS/Backend/Darkmode.js') }}"></script>
        <script src="{{ asset('JS/Backend/Secure.js') }}"></script>


    </body>
</html>
