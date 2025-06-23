<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TaskJago') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
    <!-- Header Brand -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-orange-500">TaskJago</h1>
        <p class="mt-1 text-gray-500 text-sm">Monitoring Tugas Mahasiswa</p>
    </div>

    <!-- Form Container -->
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="mt-6 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} TaskJago. All rights reserved.
    </footer>
</body>
</html>
