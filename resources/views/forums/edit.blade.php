@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Edit Forum</h1>

    @if (session('success'))
        <div class="mb-4 text-sm text-green-600 bg-green-100 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('forums.update', $forum->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Nama Forum</label>
            <input type="text" id="title" name="title" value="{{ old('title', $forum->title) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-orange-200 focus:border-orange-500">
            @error('title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea id="body" name="body" rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-orange-200 focus:border-orange-500">{{ old('body', $forum->body) }}</textarea>
            @error('body')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('forums.show', $forum->id) }}"
               class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm font-medium">
                Batal
            </a>
            <button type="submit"
                    class="inline-block px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm font-medium">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
