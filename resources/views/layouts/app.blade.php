<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Task Manager') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/@heroicons/vue@2.0.18/outline" defer></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-white shadow h-16">
        @include('layouts.header')
    </div>

    <!-- Layout Utama -->
    <div class="flex pt-16 min-h-screen">

        <!-- Sidebar -->
        <aside class="w-[216px] h-screen fixed top-16 left-0 bg-white border-r border-gray-200 shadow-md z-30">
            @include('layouts.sidebar')
        </aside>

        <!-- Konten Utama -->
        <main class="ml-[216px] flex-1 p-6 overflow-y-auto bg-gray-50">
            @yield('content')
        </main>
    </div>

</body>
</html>
