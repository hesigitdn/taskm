@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-2xl border border-gray-100 rounded-3xl p-8 space-y-8 transition-all duration-300">

        <!-- Header: Judul & Checklist -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $task->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Dibuat pada {{ $task->created_at->format('d M Y') }}
                </p>
            </div>

            <!-- Checklist -->
            <form action="{{ route('tasks.toggleStatus', $task->id) }}" method="POST" id="toggle-form">
                @csrf
                @method('PATCH')
                <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer select-none">
                    <input type="checkbox"
                           onchange="document.getElementById('toggle-form').submit()"
                           class="h-5 w-5 rounded-full text-green-500 border-gray-300 focus:ring-2 focus:ring-green-400 transition">
                    <span class="{{ $task->completed ? 'text-green-600 font-semibold' : '' }}">
                        {{ $task->completed ? '✓ Selesai' : 'Belum Selesai' }}
                    </span>
                </label>
            </form>
        </div>

        <!-- Kategori -->
        <div>
            <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Kategori</div>
            <span class="inline-block bg-orange-100 text-orange-700 text-sm font-medium px-4 py-1 rounded-full shadow-sm">
                {{ $task->category->name ?? '-' }}
            </span>
        </div>

        <!-- Deadline -->
        <div>
            <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Deadline</div>
            <div class="flex items-center gap-2 text-sm text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M6 2a1 1 0 000 2h8a1 1 0 100-2H6zM4 5a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2H4zm1 3a1 1 0 112 0 1 1 0 01-2 0zm3 0a1 1 0 112 0 1 1 0 01-2 0zm3 0a1 1 0 112 0 1 1 0 01-2 0z" />
                </svg>
                {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y H:i') }}

                @if (!$task->completed && \Carbon\Carbon::now()->gt($task->deadline))
                    <span class="ml-2 bg-red-100 text-red-600 text-xs font-semibold px-2 py-1 rounded-full">
                        ⏰ Terlambat
                    </span>
                @endif
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Deskripsi</div>
            <div class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm text-gray-700 leading-relaxed shadow-sm">
                {{ $task->description ?? '-' }}
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="pt-4 text-right">
            <a href="{{ route('tasks.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-white bg-gradient-to-r from-orange-400 to-pink-400 px-6 py-2 rounded-full shadow hover:scale-105 transition-transform">
                ← Kembali ke Daftar
            </a>
        </div>

    </div>
</div>
@endsection
