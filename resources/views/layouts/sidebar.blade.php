<aside class="h-full overflow-y-auto">
    <nav class="mt-4 space-y-2 px-4 text-sm font-medium flex flex-col items-center">
        <a href="{{ route('tasks.dashboard') }}"
           class="w-full max-w-[200px] text-center block py-2 px-4 rounded-lg transition
           {{ request()->routeIs('tasks.dashboard') ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}">
            Dashboard
        </a>
        <a href="{{ route('tasks.index') }}"
           class="w-full max-w-[200px] text-center block py-2 px-4 rounded-lg transition
           {{ request()->routeIs('tasks.index') ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}">
            Tugas
        </a>
        <a href="{{ route('tasks.calendar') }}"
           class="w-full max-w-[200px] text-center block py-2 px-4 rounded-lg transition
           {{ request()->routeIs('tasks.calendar') ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}">
            Kalender
        </a>
        <a href="{{ route('forums.index') }}"
           class="w-full max-w-[200px] text-center block py-2 px-4 rounded-lg transition
           {{ request()->routeIs('forums.index') ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}">
            Forum
        </a>
        <a href="{{ route('forums.mine') }}"
           class="w-full max-w-[200px] text-center block py-2 px-4 rounded-lg transition
           {{ request()->routeIs('forums.mine') ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}">
            Forum Saya
        </a>
    </nav>
</aside>
