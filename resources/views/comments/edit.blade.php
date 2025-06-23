@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="bg-white p-8 rounded-2xl shadow border border-gray-100">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Edit Komentar</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded border border-red-300">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('comments.update', $comment->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Isi Komentar</label>
                <textarea name="body" id="body" rows="4" required
                          class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-orange-500 focus:border-orange-500">{{ old('body', $comment->body) }}</textarea>
            </div>

            {{-- Lampiran lama --}}
            @if ($comment->attachment)
                <div class="text-sm text-gray-600">
                    📎 Lampiran saat ini:
                    <a href="{{ asset('storage/' . $comment->attachment) }}" target="_blank" class="text-orange-600 hover:underline">
                        Lihat Lampiran
                    </a>
                </div>
            @endif

            {{-- Input file baru --}}
            <div>
                <label for="attachment" class="block text-sm font-medium text-gray-700">Ganti Lampiran (opsional)</label>
                <input type="file" name="attachment" id="attachment"
                       class="mt-1 block w-full text-sm text-gray-600 file:bg-orange-50 file:text-orange-600 file:px-4 file:py-1 file:rounded-lg file:border-none" />
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti lampiran.</p>
            </div>

            <div class="text-right">
                <a href="{{ url()->previous() }}"
                   class="inline-block px-4 py-2 mr-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
