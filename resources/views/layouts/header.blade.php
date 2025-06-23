<nav class="bg-white shadow-md sticky top-0 z-30">
    <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
        <!-- Logo (opsional) -->
        <div class=" text-orange-500 font-bold text-xl">
            TaskJago
        </div>

        <!-- Dropdown Akun -->
        <div class="relative ml-auto" x-data="{ accountOpen: false }">
            <button @click="accountOpen = !accountOpen"
                    class="flex items-center space-x-2 hover:text-orange-600 transition focus:outline-none">
                <span class="text-sm text-gray-700 hover:text-orange-500 transition">
                    {{ Auth::user()->name }}
                </span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="accountOpen" x-transition x-cloak
                 class="absolute right-0 mt-2 w-48 bg-white border rounded-xl shadow-xl z-50">
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">Logout</button>
                </form>
            </div>
        </div>

    </div>
</nav>
