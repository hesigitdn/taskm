@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">📁 Forum Saya</h1>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if($forums->count())
        <div class="grid gap-4">
            @foreach($forums as $forum)
                <div class="flex justify-between items-center p-6 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 hover:text-orange-500">
                            <a href="{{ route('forums.show', $forum->id) }}">{{ $forum->title }}</a>
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            oleh <span class="font-medium text-gray-700">{{ $forum->user->name }}</span>
                            · {{ $forum->created_at->diffForHumans() }}
                        </p>
                    </div>

                    {{-- Tombol Keluar / Label Pembuat --}}
                    @if ($forum->user_id !== auth()->id())
                        <form method="POST" action="{{ route('forums.leave', $forum->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-sm text-red-500 hover:underline hover:text-red-600 transition"
                                    onclick="return confirm('Yakin ingin keluar dari forum ini?')">
                                Keluar
                            </button>
                        </form>
                    @else
                        <span class="text-sm text-gray-400 italic">Pembuat forum</span>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $forums->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">Kamu belum mengikuti forum manapun.</p>
        </div>
    @endif
</div>
@endsection
