@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-16 bg-white/60 backdrop-blur-md p-8 rounded-2xl shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Tambah Kategori Baru</h2>

    <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700">Nama Kategori</label>
            <input type="text" name="name" id="name"
                   class="mt-2 block w-full rounded-full border border-gray-300 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-300 px-4 py-2 text-gray-800"
                   placeholder="Masukkan nama kategori" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('tasks.index') }}"
               class="inline-flex items-center px-5 py-2 rounded-full text-sm font-medium bg-gray-200 hover:bg-gray-300 text-gray-800 transition">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-orange-400 to-pink-400 text-white hover:scale-105 shadow-md transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
