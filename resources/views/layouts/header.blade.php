<nav class="bg-white shadow-md sticky top-0 z-30">
    <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">

        <!-- Logo -->
        <div class="text-orange-500 font-bold text-xl">TaskJago</div>

        @php
            $notifications = Auth::user()->unreadNotifications;
        @endphp

        <div class="flex items-center gap-6">

<!-- Notifikasi Dropdown -->
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative focus:outline-none">
        🔔
        @if ($notifications->count() > 0)
            <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1">
                {{ $notifications->count() }}
            </span>
        @endif
    </button>

    <!-- Perbaikan posisi agar tidak tertahan sidebar -->
    <div x-show="open" x-transition x-cloak
         @click.outside="open = false"
         class="fixed top-14 right-4 w-80 max-w-[90vw] bg-white border rounded-xl shadow-xl z-[9999]">

        <!-- Header -->
        <div class="px-4 py-3 border-b font-semibold text-gray-800">
            Notifikasi
        </div>

        <!-- Isi scrollable -->
        <div class="max-h-64 overflow-y-auto divide-y">
            @forelse ($notifications as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50">
                    <div class="font-medium text-sm text-gray-900">
                        {{ $notification->data['title'] ?? 'Notifikasi' }}
                    </div>
                    <div class="text-gray-500 text-xs">
                        {{ $notification->data['body'] ?? '' }}
                    </div>
                </a>
            @empty
                <div class="px-4 py-3 text-sm text-gray-500">Tidak ada notifikasi baru.</div>
            @endforelse
        </div>

        <!-- Footer -->
        <a href="{{ route('notifications.read') }}"
           class="block text-center text-sm text-blue-600 py-3 hover:bg-gray-100 font-medium">
            Tandai semua sudah dibaca
        </a>
    </div>
</div>

            <!-- Dropdown Akun -->
            <div class="relative" x-data="{ accountOpen: false }">
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

                <div x-show="accountOpen" x-transition x-cloak
                     class="absolute right-0 mt-2 w-48 bg-white border rounded-xl shadow-xl z-50">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-center text-gray-700 hover:bg-gray-100">Edit Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-center px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</nav>
