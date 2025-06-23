@if ($forums->isEmpty())
    <div class="text-center text-gray-500 py-10">Tidak ada forum ditemukan.</div>
@else
    @foreach ($forums as $forum)
        <div class="p-4 mb-4 bg-white rounded-xl border border-gray-100 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-semibold text-gray-800">
                <a href="{{ route('forums.show', $forum->id) }}" class="hover:text-orange-600">
                    {{ $forum->title }}
                </a>
            </h2>
            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($forum->body, 120) }}</p>
            <div class="text-xs text-gray-400 mt-2">
                Dibuat oleh {{ $forum->user->name }} • {{ $forum->created_at->diffForHumans() }}
            </div>
        </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-6">
        {{ $forums->withQueryString()->links() }}
    </div>
@endif
