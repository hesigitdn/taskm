@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📁 Daftar Kategori</h1>
        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center px-5 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-orange-400 to-pink-400 text-white hover:scale-105 shadow-md transition-all">
            ➕ Tambah Kategori
        </a>
    </div>

    <!-- Flash Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Daftar Kategori -->
    <div class="bg-white shadow rounded-2xl divide-y">
        @forelse ($categories as $category)
            <div class="flex justify-between items-center px-6 py-4 hover:bg-gray-50 transition">
                <div class="text-gray-800 font-medium">{{ $category->name }}</div>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-sm font-semibold text-red-500 hover:text-red-700 transition">
                        🗑️ Hapus
                    </button>
                </form>
            </div>
        @empty
            <div class="px-6 py-4 text-gray-500 text-center">
                Belum ada kategori ditambahkan.
            </div>
        @endforelse
    </div>
</div>
@endsection
