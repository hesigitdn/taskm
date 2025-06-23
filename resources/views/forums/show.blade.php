@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12 space-y-10">

    <!-- Forum Detail -->
    <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">
        <h1 class="text-3xl font-bold text-gray-900">{{ $forum->title }}</h1>
        <p class="text-sm text-gray-500 mt-1">
            oleh <span class="font-medium text-gray-700">{{ $forum->user->name }}</span> · {{ $forum->created_at->diffForHumans() }}
        </p>

        <div class="mt-5 text-gray-800 text-base leading-relaxed">
            {{ $forum->description ?? $forum->body }}
        </div>

        @if (! $isMember)
        <form action="{{ route('forums.join', $forum->id) }}" method="POST" class="mt-6">
            @csrf
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-full text-sm font-medium shadow-sm">
                Gabung Forum
            </button>
        </form>
        @else
        <p class="mt-6 text-sm text-green-600 font-medium">✅ Kamu sudah bergabung di forum ini.</p>
        @endif
    </div>

    <!-- Komentar Utama -->
    <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">💬 Diskusi</h2>

        @auth
        <form action="{{ route('comments.store', $forum->id) }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 space-y-4" x-data="{ filePreview: null }">
            @csrf
            <input type="hidden" name="forum_id" value="{{ $forum->id }}">

            <textarea name="body" rows="3" required
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none"
                      placeholder="Tulis komentar kamu..."></textarea>

            <div class="space-y-2">
                <label class="text-sm text-gray-500">📎 Lampiran (Opsional)</label>
                <input type="file" name="attachment"
                       @change="filePreview = URL.createObjectURL($event.target.files[0])"
                       class="block mt-1 w-full text-sm text-gray-600 file:bg-orange-50 file:text-orange-600 file:px-4 file:py-1 file:rounded-md file:border-none" />

                <template x-if="filePreview">
                    <div class="mt-2">
                        <span class="text-xs text-gray-500">Preview:</span>
                        <img :src="filePreview" class="mt-1 w-40 h-auto rounded-md border border-gray-200 shadow">
                    </div>
                </template>
            </div>

            <div class="text-right">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-full text-sm font-medium">
                    Kirim
                </button>
            </div>
        </form>
        @endauth

        @forelse ($forum->comments as $comment)
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-3">
            <div class="text-sm text-gray-500 flex justify-between">
                <span><strong class="text-gray-800">{{ $comment->user->name }}</strong> · {{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-gray-800 text-sm">{{ $comment->body }}</p>

            @if ($comment->attachment)
            <div class="text-sm mt-1">
                📎 <a href="{{ asset('storage/' . $comment->attachment) }}" target="_blank"
                      class="text-orange-600 hover:underline">Lihat Lampiran</a>
            </div>
            @endif

            @if (auth()->id() === $comment->user_id)
            <div class="flex items-center gap-3 text-xs text-gray-400 mt-2">
                <a href="{{ route('comments.edit', $comment->id) }}" class="hover:underline">Edit</a>
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                      onsubmit="return confirm('Hapus komentar ini?')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                </form>
            </div>
            @endif

            <!-- Balasan -->
            @foreach ($comment->replies as $reply)
            <div class="ml-6 mt-4 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="text-sm text-gray-500 flex justify-between">
                    <span><strong class="text-gray-800">{{ $reply->user->name }}</strong> · {{ $reply->created_at->diffForHumans() }}</span>
                </div>
                <p class="mt-1 text-gray-800 text-sm">{{ $reply->body }}</p>

                @if ($reply->attachment)
                <div class="mt-1 text-xs">
                    📎 <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank"
                          class="text-orange-600 hover:underline">Lihat Lampiran</a>
                </div>
                @endif

                @if (auth()->id() === $reply->user_id)
                <div class="flex items-center gap-3 text-xs text-gray-400 mt-2">
                    <a href="{{ route('comments.edit', $reply->id) }}" class="hover:underline">Edit</a>
                    <form action="{{ route('comments.destroy', $reply->id) }}" method="POST"
                          onsubmit="return confirm('Hapus balasan ini?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach

            <!-- Form Balasan di Bawah -->
            @auth
            <form action="{{ route('comments.reply', $comment->id) }}" method="POST" enctype="multipart/form-data"
                  class="mt-4 ml-4 bg-gray-50 rounded-xl p-4 space-y-3 border border-gray-200" x-data="{ filePreviewReply: null }">
                @csrf
                <textarea name="body" rows="2" required
                          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none"
                          placeholder="Balas komentar ini..."></textarea>

                <input type="file" name="attachment"
                       @change="filePreviewReply = URL.createObjectURL($event.target.files[0])"
                       class="block w-full text-xs text-gray-600 file:bg-gray-100 file:text-orange-600 file:px-3 file:py-1 file:rounded-md file:border-none" />

                <template x-if="filePreviewReply">
                    <div class="mt-2">
                        <span class="text-xs text-gray-500">Preview:</span>
                        <img :src="filePreviewReply" class="mt-1 w-32 h-auto rounded-md border border-gray-200 shadow">
                    </div>
                </template>

                <div class="text-right">
                    <button type="submit"
                            class="bg-gray-100 hover:bg-gray-200 text-xs px-4 py-1.5 rounded-md font-medium">
                        Balas
                    </button>
                </div>
            </form>
            @endauth
        </div>
        @empty
        <p class="text-gray-500">Belum ada komentar.</p>
        @endforelse
    </div>
</div>
@endsection
