@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Tugas</h1>
        <div class="flex gap-3">
            <a href="{{ route('tasks.create') }}"
               class="px-4 py-2 bg-[#FF7000] text-white font-semibold rounded-full hover:bg-[#e66000] transition">
                Tambah Tugas
            </a>
            <a href="{{ route('categories.create') }}"
               class="px-4 py-2 bg-[#00A3FF] text-white font-semibold rounded-full hover:bg-[#008AD1] transition">
                Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-8 bg-white rounded-xl shadow p-6 flex flex-wrap gap-4 items-center">
        <div class="flex items-center gap-2">
            <label for="category" class="text-gray-700 font-medium">Kategori:</label>
            <select name="category" id="category" class="px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-orange-400">
                <option value="">Semua</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-2">
            <label for="status" class="text-gray-700 font-medium">Status:</label>
            <select name="status" id="status" class="px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-orange-400">
                <option value="">Semua</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Selesai</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Belum Selesai</option>
            </select>
        </div>
        <button type="submit"
            class="ml-auto px-5 py-2 bg-[#FF7000] text-white font-semibold rounded-full hover:bg-[#e66000] transition">
            Filter
        </button>
    </form>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Tugas --}}
    @if ($tasks->count())
        <div class="space-y-6">
            @foreach ($tasks as $task)
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <input id="checkbox-{{ $task->id }}" type="checkbox" onchange="toggleTaskStatus({{ $task->id }})"
                                class="w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-400"
                                {{ $task->completed ? 'checked' : '' }}>
                            <h2 id="title-{{ $task->id }}" class="text-lg font-semibold {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                                {{ $task->title }}
                            </h2>
                        </div>
                        <div class="text-sm text-gray-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y H:i') }}
                            @if (\Carbon\Carbon::now()->gt($task->deadline))
                                <span class="text-red-500 font-bold">(Overdue)</span>
                            @endif
                        </div>
                    </div>

                    @if ($task->description)
                        <p class="text-gray-600 text-sm">{{ $task->description }}</p>
                    @endif

                    <div class="flex justify-between items-center">
                        <div class="flex flex-wrap gap-2">
                            @foreach (explode(',', $task->category) as $category)
                                <span class="text-xs font-semibold text-white px-3 py-1 rounded-full"
                                    style="background-color: {{ getCategoryColor($category) }}">
                                    {{ $category }}
                                </span>
                            @endforeach
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('tasks.edit', $task->id) }}"
                               class="px-4 py-2 rounded-full text-sm font-semibold text-white bg-[#00A3FF] hover:bg-[#008AD1] transition">
                                Edit
                            </a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 rounded-full text-sm font-semibold text-white bg-[#FF7000] hover:bg-[#e66000] transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
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

{{-- Script untuk toggle status --}}
<script>
function toggleTaskStatus(taskId) {
    const checkbox = document.getElementById('checkbox-' + taskId);
    const title = document.getElementById('title-' + taskId);

    fetch(`/tasks/${taskId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Ubah tampilan langsung
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

@php
    function getCategoryColor($category) {
        $hash = md5($category);
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));
        return "rgb($r, $g, $b)";
    }
@endphp
@endsection
