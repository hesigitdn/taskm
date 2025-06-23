@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl py-10 px-6">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Edit Tugas</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST"
          class="bg-white rounded-2xl shadow-xl p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-gray-700 font-medium mb-2">Judul Tugas</label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   placeholder="Masukkan judul tugas" required>
        </div>

        <div>
            <label for="category" class="block text-gray-700 font-medium mb-2">Kategori</label>
            <input type="text" id="category" name="category" value="{{ old('category', $task->category) }}"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   placeholder="Masukkan kategori tugas" required>
        </div>

        <div>
            <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
            <textarea id="description" name="description"
                      class="w-full px-5 py-3 rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                      rows="4" placeholder="Tulis deskripsi tugas...">{{ old('description', $task->description) }}</textarea>
        </div>

        <div>
            <label for="deadline" class="block text-gray-700 font-medium mb-2">Deadline</label>
            <input type="datetime-local" id="deadline" name="deadline"
                   value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i')) }}"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   required>
        </div>

        <div>
            <label for="notification_minutes" class="block text-gray-700 font-medium mb-2">Notifikasi (menit sebelum deadline)</label>
            <input type="number" id="notification_minutes" name="notification_minutes"
                   value="{{ old('notification_minutes', $task->notification_minutes) }}"
                   class="w-full px-5 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   placeholder="Contoh: 30">
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('tasks.index') }}"
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition">Batal</a>
            <button type="submit"
                    class="px-6 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition">Update Tugas</button>
        </div>
    </form>
</div>
@endsection
