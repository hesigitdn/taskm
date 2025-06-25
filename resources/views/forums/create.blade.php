@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Buat Forum Baru</h1>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('forums.store') }}" method="POST" class="bg-white rounded-2xl shadow-md p-8 space-y-6">
        @csrf

        <!-- Judul Forum -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Forum</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                   class="w-full px-5 py-3 border border-gray-300 rounded-full shadow-sm focus:ring-2 focus:ring-orange-500 focus:outline-none text-sm">
        </div>

        <!-- Deskripsi Forum -->
        <div>
            <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="body" id="body" rows="5" required
                      class="w-full px-5 py-3 border border-gray-300 rounded-2xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:outline-none text-sm resize-none">{{ old('description') }}</textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-2">
            <a href="{{ route('forums.index') }}"
               class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-full hover:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-6 py-2.5 text-sm font-semibold text-white bg-orange-500 hover:bg-orange-600 rounded-full transition">
                Simpan Forum
            </button>
        </div>
    </form>
</div>
@endsection
