@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Edit Komentar</h1>

    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
        @csrf
        @method('PUT')
        <textarea name="body" rows="5" class="w-full p-2 border rounded mb-4">{{ $comment->body }}</textarea>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
