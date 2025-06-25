@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center sm:text-left">✏️ Edit Tugas</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST"
          class="bg-white shadow-2xl border border-gray-100 rounded-3xl p-8 space-y-8 transition-all">
        @csrf
        @method('PUT')

        <!-- Judul & Kategori -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Tugas</label>
                <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                       class="w-full px-5 py-3 rounded-full border border-gray-300 shadow-sm focus:ring-2 focus:ring-orange-400 focus:outline-none"
                       placeholder="Masukkan judul tugas" required>
            </div>

            <div>
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                <select id="category_id" name="category_id"
                        class="w-full px-5 py-3 rounded-full border border-gray-300 bg-white shadow-sm focus:ring-2 focus:ring-orange-400 focus:outline-none"
                        required>
                    <option value="" disabled>Pilih kategori</option>
                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ $category->id == old('category_id', $task->category_id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
            <textarea id="description" name="description"
                      class="w-full px-5 py-3 rounded-2xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-orange-400 focus:outline-none"
                      rows="4" placeholder="Tulis deskripsi tugas...">{{ old('description', $task->description) }}</textarea>
        </div>

        <!-- Deadline -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-1">Deadline</label>
                <input type="datetime-local" id="deadline" name="deadline"
                       value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i')) }}"
                       class="w-full px-5 py-3 rounded-full border border-gray-300 shadow-sm focus:ring-2 focus:ring-orange-400 focus:outline-none"
                       required>
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-4">
            <a href="{{ route('tasks.index') }}"
               class="w-full sm:w-auto text-center px-6 py-3 text-sm font-medium bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">
                ← Batal
            </a>
            <button type="submit"
                    class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-orange-400 to-pink-500 rounded-full shadow-md hover:scale-105 transition-transform">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
