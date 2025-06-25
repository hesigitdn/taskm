@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl py-10 px-6">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Tambah Tugas Baru</h1>

    <form action="{{ route('tasks.store') }}" method="POST" class="bg-white rounded-2xl shadow-xl p-6 space-y-6">
        @csrf

        <!-- Judul -->
        <div>
            <label for="title" class="block text-gray-700 font-medium mb-2">Judul Tugas</label>
            <input type="text" id="title" name="title"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   placeholder="Masukkan judul tugas" required>
        </div>

        <!-- Kategori -->
        <div>
            <label for="category_id" class="block text-gray-700 font-medium mb-2">Kategori</label>
            <select id="category_id" name="category_id" required
                    class="w-full px-5 py-3 rounded-full border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="" selected>Pilih Kategori</option>
                @foreach (\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
            <textarea id="description" name="description"
                      class="w-full px-5 py-3 rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                      rows="4" placeholder="Tulis deskripsi tugas..."></textarea>
        </div>

        <!-- Deadline -->
        <div>
            <label for="deadline" class="block text-gray-700 font-medium mb-2">Deadline</label>
            <input type="datetime-local" id="deadline" name="deadline"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   required>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('tasks.index') }}"
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition">
               Batal
            </a>
            <button type="submit"
                    class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-orange-400 to-pink-500 rounded-full shadow-md hover:scale-105 transition-transform">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
