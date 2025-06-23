@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-6">
    <div class="w-full max-w-2xl bg-white/60 backdrop-blur-md border border-gray-200 shadow-xl rounded-2xl p-8 space-y-6">
        <h1 class="text-3xl font-bold text-gray-800">Pengaturan Akun</h1>
        
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm @error('name') border-red-500 @enderror"
                    placeholder="Nama lengkap">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email"
                    value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm @error('email') border-red-500 @enderror"
                    placeholder="Email aktif">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm @error('password') border-red-500 @enderror"
                    placeholder="Kosongkan jika tidak ingin mengubah">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                    placeholder="Konfirmasi password">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('tasks.dashboard') }}"
                   class="px-5 py-2 rounded-xl border border-gray-300 text-gray-600 hover:text-gray-800 hover:border-gray-500 text-sm">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm rounded-xl shadow-md transition duration-200 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
