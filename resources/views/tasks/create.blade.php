@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl py-10 px-6">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Tambah Tugas Baru</h1>

    <form action="{{ route('tasks.store') }}" method="POST" class="bg-white rounded-2xl shadow-xl p-6 space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-gray-700 font-medium mb-2">Judul Tugas</label>
            <input type="text" id="title" name="title"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   placeholder="Masukkan judul tugas" required>
        </div>

        <div>
            <label for="category" class="block text-gray-700 font-medium mb-2">Kategori</label>
            <select id="category" name="category"
                    class="w-full px-5 py-3 rounded-full border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-orange-400"
                    required>
                <option value="" selected>Pilih Kategori</option>
                @foreach (\App\Models\Category::all() as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
            <textarea id="description" name="description"
                      class="w-full px-5 py-3 rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                      rows="4" placeholder="Tulis deskripsi tugas..."></textarea>
        </div>

        <div>
            <label for="deadline" class="block text-gray-700 font-medium mb-2">Deadline</label>
            <input type="datetime-local" id="deadline" name="deadline"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   required>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('tasks.index') }}"
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition">Batal</a>
            <button type="submit"
                    class="px-6 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
