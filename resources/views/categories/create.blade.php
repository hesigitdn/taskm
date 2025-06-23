@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-16 bg-white/70 backdrop-blur-md p-10 rounded-3xl shadow-xl border border-gray-200 transition-all">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">🧩 Tambah Kategori</h2>

    <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Kategori</label>
            <input type="text" name="name" id="name"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400 text-gray-800"
                   placeholder="Contoh: Tugas Kuliah" required>
            @error('name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
            <a href="{{ route('tasks.index') }}"
               class="inline-flex justify-center items-center px-6 py-2 rounded-full text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex justify-center items-center px-6 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-orange-400 to-pink-400 text-white hover:scale-105 hover:shadow-md transition-all">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
