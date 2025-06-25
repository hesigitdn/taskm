@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📋 Daftar Tugas</h1>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('tasks.create') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-full transition">
                Tambah Tugas
            </a>
            <a href="{{ route('categories.create') }}"
                class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-5 py-2 rounded-full transition">
                Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('tasks.index') }}"
        class="bg-white rounded-xl shadow p-6 flex flex-wrap items-center gap-4 mb-8">
        <div class="flex items-center gap-2">
            <label for="category" class="text-gray-700 font-medium">Kategori:</label>
            <select name="category" id="category"
                class="px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-orange-400">
                <option value="">Semua</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-2">
            <label for="status" class="text-gray-700 font-medium">Status:</label>
            <select name="status" id="status"
                class="px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-orange-400">
                <option value="">Semua</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Selesai</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Belum Selesai</option>
            </select>
        </div>

        <button type="submit"
            class="ml-auto bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-full transition">
            Filter
        </button>
    </form>

    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if ($tasks->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            @foreach ($tasks as $task)
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transform hover:scale-[1.01] transition">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-start gap-3">
                            <!-- Checkbox Checklist -->
                            <input type="checkbox" id="checkbox-{{ $task->id }}"
                                onchange="toggleTaskStatus({{ $task->id }})"
                                class="mt-1 w-5 h-5 text-orange-500 border-gray-300 rounded"
                                {{ $task->completed ? 'checked' : '' }}>

                            <!-- Judul & Deskripsi -->
                            <div>
                                <a href="{{ route('tasks.show', $task->id) }}" class="block group">
                                    <h2 id="title-{{ $task->id }}"
                                        class="text-lg font-semibold group-hover:underline {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                                        {{ $task->title }}
                                    </h2>
                                </a>
                                @if ($task->description)
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ Str::limit($task->description, 100) }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Deadline -->
                        <div class="text-sm text-gray-500 text-right whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y H:i') }}
                            @if (!$task->completed && \Carbon\Carbon::now()->gt($task->deadline))
                                <span class="text-red-500 font-semibold block">(Terlambat)</span>
                            @endif
                        </div>
                    </div>

                    <!-- Kategori -->
                    @if ($task->category)
                        <div class="mb-4">
                            <span class="inline-block text-xs font-medium text-white px-3 py-1 rounded-full"
                                  style="background-color: {{ getCategoryColor($task->category->name) }};">
                                {{ $task->category->name }}
                            </span>
                        </div>
                    @endif

                    <!-- Aksi -->
                    <div class="flex gap-3">
                        <a href="{{ route('tasks.edit', $task->id) }}"
                            class="bg-sky-500 hover:bg-sky-600 text-white text-sm font-medium px-4 py-2 rounded-full transition">
                            Edit
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-full transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-500 text-lg mt-10">
            Tidak ada tugas ditemukan.
        </div>
    @endif
</div>

{{-- Script Toggle Status --}}
<script>
function toggleTaskStatus(taskId) {
    const checkbox = document.getElementById('checkbox-' + taskId);
    const title = document.getElementById('title-' + taskId);

    fetch(`/tasks/${taskId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (checkbox.checked) {
                title.classList.remove('text-gray-800');
                title.classList.add('line-through', 'text-gray-400');
            } else {
                title.classList.remove('line-through', 'text-gray-400');
                title.classList.add('text-gray-800');
            }
        }
    });
}
</script>

{{-- Warna kategori --}}
@php
function getCategoryColor($category) {
    $colors = ['#FF7000', '#00A3FF', '#12B76A', '#6366F1', '#EAB308'];
    return $colors[crc32($category) % count($colors)];
}
@endphp
@endsection
