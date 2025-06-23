@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="max-w-7xl mx-auto px-6 py-10 space-y-10">

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900">📊 Dashboard Tugas</h1>
        <p class="text-gray-500 mt-2">Pantau statistik tugasmu dengan ringkas dan efisien</p>
    </div>

    {{-- Ringkasan dan Grafik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Statistik Ringkasan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">📋 Ringkasan Tugas</h2>
            <ul class="text-gray-700 space-y-3">
                <li class="flex justify-between items-center">
                    <span class="text-sm">Total Tugas</span>
                    <span class="text-xl font-bold text-indigo-600">{{ $totalTasks }}</span>
                </li>
                <li class="flex justify-between items-center">
                    <span class="text-sm">Tugas Selesai</span>
                    <span class="text-xl font-bold text-green-500">{{ $completedTasks }}</span>
                </li>
                <li class="flex justify-between items-center">
                    <span class="text-sm">Belum Selesai</span>
                    <span class="text-xl font-bold text-red-500">{{ $pendingTasks }}</span>
                </li>
            </ul>
        </div>

        {{-- Grafik Chart.js --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">📈 Grafik Progres</h2>
            <canvas id="taskChart" class="h-64"></canvas>
        </div>
    </div>

    {{-- Tombol Navigasi --}}
    <div class="text-center pt-8">
        <a href="{{ route('tasks.index') }}"
           class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 text-sm font-semibold transition">
            📂 Lihat Daftar Tugas
        </a>
    </div>
</div>

<script>
    window.onload = function () {
        const ctx = document.getElementById('taskChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total', 'Selesai', 'Belum Selesai'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $totalTasks ?? 0 }}, {{ $completedTasks ?? 0 }}, {{ $pendingTasks ?? 0 }}],
                    backgroundColor: ['#6366F1', '#22C55E', '#EF4444'],
                    borderRadius: 8,
                    barThickness: 40,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    };
</script>
@endsection
