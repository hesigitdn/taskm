@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center sm:text-left">✏️ Edit Tugas</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST"
          class="bg-white shadow-xl rounded-2xl p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="col-span-1">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Judul Tugas</label>
                <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                       class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       placeholder="Masukkan judul tugas" required>
            </div>

            <div class="col-span-1">
                <label for="category" class="block text-gray-700 font-semibold mb-2">Kategori</label>
                <input type="text" id="category" name="category" value="{{ old('category', $task->category) }}"
                       class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       placeholder="Masukkan kategori tugas" required>
            </div>
        </div>

        <div>
            <label for="description" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
            <textarea id="description" name="description"
                      class="w-full px-5 py-3 rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                      rows="4" placeholder="Tulis deskripsi tugas...">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="col-span-1">
                <label for="deadline" class="block text-gray-700 font-semibold mb-2">Deadline</label>
                <input type="datetime-local" id="deadline" name="deadline"
                       value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i')) }}"
                       class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       required>
            </div>

            <div class="col-span-1">
                <label for="notification_minutes" class="block text-gray-700 font-semibold mb-2">
                    Notifikasi (menit sebelum deadline)
                </label>
                <input type="number" id="notification_minutes" name="notification_minutes"
                       value="{{ old('notification_minutes', $task->notification_minutes) }}"
                       class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       placeholder="Contoh: 30">
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-4">
            <a href="{{ route('tasks.index') }}"
               class="w-full sm:w-auto text-center px-6 py-3 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition">
               Batal
            </a>
            <button type="submit"
                    class="w-full sm:w-auto text-center px-6 py-3 bg-orange-500 text-white font-semibold rounded-full hover:bg-orange-600 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
