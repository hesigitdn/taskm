@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">👥 Kelola Anggota Forum</h1>

    <div class="mb-6">
        <p class="text-sm text-gray-600">Forum: <strong>{{ $forum->title }}</strong></p>
        <a href="{{ route('forums.show', $forum->id) }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke forum
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 text-sm text-green-600 bg-green-100 p-3 rounded">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <table class="min-w-full table-auto border rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($members as $member)
                <tr>
                    <td class="px-4 py-3">{{ $member->name }}</td>
                    <td class="px-4 py-3">{{ $member->email }}</td>
                    <td class="px-4 py-3">
                        @if ($member->id !== $forum->user_id)
                            <form action="{{ route('forums.kick', [$forum->id, $member->id]) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin mengeluarkan anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-sm text-red-600 hover:underline">
                                    Keluarkan
                                </button>
                            </form>
                        @else
                            <span class="text-sm text-gray-500 italic">Pembuat forum</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
