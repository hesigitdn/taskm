<x-guest-layout>
    <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Masuk ke TaskJago</h2>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" required autofocus
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
            <input id="password" type="password" name="password" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
            @error('password')
                <p class="text-red-500 text-sm italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded" name="remember">
            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                Ingat saya
            </label>
        </div>

        <!--<div class="flex justify-between items-center">
            <a href="{{ route('password.request') }}" class="text-sm text-orange-500 hover:underline">Lupa sandi?</a>
        </div>-->

        <div>
            <button type="submit"
                    class="w-full py-2 px-4 bg-orange-500 hover:bg-orange-600 text-white rounded-md font-semibold shadow">
                Masuk
            </button>
        </div>

        <p class="text-center text-sm mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-orange-500 hover:underline">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
