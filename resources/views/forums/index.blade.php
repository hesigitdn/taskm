@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Forum Diskusi</h1>
            <p class="text-gray-500 mt-2 text-base">Gabung dan temukan diskusi menarik sesuai minatmu.</p>
        </div>
        <a href="{{ route('forums.create') }}"
           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 text-sm font-medium rounded-full shadow transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Buat Forum
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <form action="{{ route('forums.index') }}" method="GET" class="w-full md:w-1/2">
            <input type="text" name="search" placeholder="🔍 Cari forum..."
                   class="w-full px-5 py-3 text-sm border border-gray-300 rounded-full shadow-sm focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all">
        </form>
        <div class="flex gap-2 text-sm">
            <a href="?filter=latest"
               class="px-4 py-2 rounded-full {{ request('filter') === 'latest' ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Terbaru
            </a>
            <a href="?filter=popular"
               class="px-4 py-2 rounded-full {{ request('filter') === 'popular' ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Populer
            </a>
            <a href="?filter=active"
               class="px-4 py-2 rounded-full {{ request('filter') === 'active' ? 'bg-orange-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Aktif
            </a>
        </div>
    </div>

    <!-- Forum List -->
    @if ($forums->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($forums as $forum)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <a href="{{ route('forums.show', $forum->id) }}">
                            <h2 class="text-lg font-semibold text-gray-900 hover:text-orange-500 mb-1">{{ $forum->title }}</h2>
                        </a>
                        <p class="text-sm text-gray-500 line-clamp-3">{{ $forum->description }}</p>
                    </div>
                    <div class="mt-4 flex justify-between text-xs text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M5.121 17.804A3 3 0 016 17h12a3 3 0 01.879.121M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $forum->user->name }}
                        </span>
                        <span>{{ $forum->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $forums->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">Belum ada forum yang tersedia saat ini.</p>
        </div>
    @endif
</div>
@endsection
