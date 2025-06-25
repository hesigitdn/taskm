@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📚 Forum Diskusi</h1>
        <a href="{{ route('forums.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-orange-500 text-white rounded-full hover:bg-orange-600 text-sm font-semibold transition">
            Buat Forum
        </a>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div class="flex gap-3">
            <button data-filter="all"
                    class="filter-btn px-4 py-2 rounded-full text-sm font-medium transition border border-gray-300 text-gray-600 hover:bg-gray-100 active-filter">
                Semua Forum
            </button>
            <button data-filter="mine"
                    class="filter-btn px-4 py-2 rounded-full text-sm font-medium transition border border-gray-300 text-gray-600 hover:bg-gray-100">
                Forum Saya
            </button>
        </div>

        <div class="relative w-full md:w-64">
            <input type="text" id="search" placeholder="Cari forum..."
                   class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-orange-500 text-sm">
        </div>
    </div>

    <!-- List Forum -->
    <div id="forum-list">
        @include('forums.partials.list', ['forums' => $forums])
    </div>
</div>

{{-- Optional style untuk tombol aktif --}}
<style>
    .active-filter {
        background-color: #f97316;
        color: white;
        border-color: #f97316;
    }
</style>

{{-- Script AJAX --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let filter = 'all';
        let search = '';

        const loadForums = (url = '{{ route('forums.list') }}') => {
            fetch(`${url}?filter=${encodeURIComponent(filter)}&search=${encodeURIComponent(search)}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('forum-list').innerHTML = html;
                });
        };

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                filter = btn.dataset.filter;

                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active-filter'));
                btn.classList.add('active-filter');

                loadForums();
            });
        });

        // Live search
        document.getElementById('search').addEventListener('input', e => {
            search = e.target.value;
            loadForums();
        });

        // AJAX pagination
        document.addEventListener('click', function (e) {
            if (e.target.matches('.pagination a')) {
                e.preventDefault();
                const url = e.target.getAttribute('href');
                loadForums(url);
            }
        });
    });
</script>
@endsection
