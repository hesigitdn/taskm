@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-10">

    <!-- Heading -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    </div>

    <!-- Statistik & Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow col-span-1">
            <h2 class="text-sm text-gray-500 mb-1">Total Tugas</h2>
            <p class="text-3xl font-bold text-orange-600">{{ $totalTasks }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow col-span-1">
            <h2 class="text-sm text-gray-500 mb-1">Selesai</h2>
            <p class="text-3xl font-bold text-green-600">{{ $completedTasks }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow col-span-1">
            <h2 class="text-sm text-gray-500 mb-1">Belum Selesai</h2>
            <p class="text-3xl font-bold text-red-600">{{ $incompleteTasks }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow col-span-1 flex items-center justify-center">
            <canvas id="taskChart" width="100" height="100"></canvas>
        </div>
    </div>

    <!-- Tugas Terdekat -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">📅 Tugas Terdekat</h2>
        <div class="divide-y">
            @forelse($upcomingTasks as $task)
                <div class="flex justify-between py-3 items-center hover:bg-gray-50 px-2 rounded-md">
                    <div>
                        <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 font-medium hover:underline">{{ $task->title }}</a>
                        <div class="text-sm text-gray-500">Deadline: {{ $task->deadline->format('d M Y H:i') }}</div>
                    </div>
                    <span class="text-xs font-medium px-2 py-1 rounded-full
                        {{ $task->status === 'completed' ? 'bg-green-100 text-green-600' : ($task->deadline->isPast() ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600') }}">
                        {{ $task->status === 'completed' ? 'Selesai' : ($task->deadline->isPast() ? 'Terlambat' : 'Belum Selesai') }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-500">Tidak ada tugas mendekati deadline.</p>
            @endforelse
        </div>
    </div>

    <!-- Forum & Kategori -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Forum -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">🗨️ Forum Terbaru</h2>
            <div class="divide-y">
                @forelse($recentForums as $forum)
                    <div class="py-2 hover:bg-gray-50 rounded-md px-2">
                        <a href="{{ route('forums.show', $forum->id) }}" class="text-blue-600 font-medium hover:underline">{{ $forum->title }}</a>
                        <div class="text-xs text-gray-500">{{ $forum->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum bergabung ke forum manapun.</p>
                @endforelse
            </div>
        </div>

        <!-- Kategori -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">🏷️ Kategori Populer</h2>
            <div class="divide-y">
                @forelse($popularCategories as $cat)
                    <div class="flex justify-between py-2 text-sm">
                        <span>{{ $cat->name }}</span>
                        <span class="text-gray-500">{{ $cat->tasks_count }} tugas</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Notifikasi Terbaru -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">🔔 Notifikasi Terbaru</h2>
        <div class="divide-y">
            @forelse($recentNotifications as $notif)
                <div class="py-2 hover:bg-gray-50 px-2">
                    <a href="{{ $notif->data['url'] ?? '#' }}" class="text-blue-600 font-medium hover:underline">
                        {{ $notif->data['title'] ?? 'Notifikasi' }}
                    </a>
                    <div class="text-gray-500 text-xs">{{ $notif->data['body'] ?? '' }}</div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Tidak ada notifikasi terbaru.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('taskChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Belum Selesai'],
            datasets: [{
                data: [{{ $completedTasks }}, {{ $incompleteTasks }}],
                backgroundColor: ['#10b981', '#f97316'],
                borderWidth: 1,
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom' }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection
