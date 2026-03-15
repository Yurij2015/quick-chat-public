<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">


        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        <script>
            // Initial dark mode check to prevent FOUC (Flash of Unstyled Content)
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900 transition-colors duration-200">
        <div class="min-h-screen">
            @include('layouts.navigation')


            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow dark:shadow-none transition-colors duration-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset


            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
            // Listen for the custom toggle event from the navigation button
            document.documentElement.addEventListener('toggle-theme', function () {
                var htmlClasses = document.documentElement.classList;
                var currentTheme = localStorage.getItem('color-theme');
                var isDark = false;

                if (currentTheme === 'dark' || (!currentTheme && htmlClasses.contains('dark'))) {
                    htmlClasses.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                    isDark = false;
                } else {
                    htmlClasses.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                    isDark = true;
                }
                
                // Dispatch a follow-up event so Alpine components can react visually if needed
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: isDark } }));
            });
        </script>
        @stack('scripts')
    </body>
</html>
