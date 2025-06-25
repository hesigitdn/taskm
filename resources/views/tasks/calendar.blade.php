@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">Kalender Tugas</h1>
        <p class="text-gray-500 mt-2 text-lg">Pantau semua deadline dan progres tugasmu dalam satu tampilan interaktif.</p>
    </div>

    <div id="calendar" class="bg-white shadow-xl rounded-3xl p-6 ring-1 ring-gray-200 transition-all duration-300 ease-in-out"></div>
</div>

<!-- Modal Interaktif -->
<div id="taskModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md mx-auto rounded-2xl shadow-xl p-6 space-y-4 transition-all scale-95">
        <h2 id="modalTitle" class="text-xl font-bold text-gray-800"></h2>
        <p id="modalDeadline" class="text-sm text-orange-600 font-semibold"></p>
        <p id="modalDescription" class="text-gray-600 text-sm leading-relaxed"></p>
        <div class="flex justify-end pt-4">
            <button onclick="closeModal()"
                    class="px-4 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- FullCalendar CDN --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>

{{-- Inisialisasi Kalender --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: @json($tasks),
            eventClick: function (info) {
                const title = info.event.title;
                const description = info.event.extendedProps.description || 'Tidak ada deskripsi';
                const deadline = new Date(info.event.start).toLocaleString('id-ID', {
                    weekday: 'long', year: 'numeric', month: 'long',
                    day: 'numeric', hour: '2-digit', minute: '2-digit'
                });

                document.getElementById('modalTitle').textContent = title;
                document.getElementById('modalDescription').textContent = description;
                document.getElementById('modalDeadline').textContent = `📅 ${deadline}`;
                document.getElementById('taskModal').classList.remove('hidden');
            },
                eventDrop: function (info) {
                    const taskId = info.event.id;
                    const newDeadline = info.event.start.toISOString().slice(0, 19).replace('T', ' '); // Format ke 'Y-m-d H:i:s'

                    fetch(`/tasks/${taskId}/update-deadline`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ deadline: newDeadline })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal memperbarui deadline.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data.message || 'Deadline berhasil diperbarui');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        info.revert(); // Kembalikan ke posisi semula jika gagal
                        alert('❌ Tidak dapat memperbarui deadline. Silakan coba lagi.');
                    });
                },

            dayMaxEvents: true,
            aspectRatio: 2.1,
            windowResize: () => calendar.render()
        });

        calendar.render();
    });

    function closeModal() {
        document.getElementById('taskModal').classList.add('hidden');
    }
</script>

{{-- Custom Styling --}}
<style>
    body {
        background-color: #f9fafb;
    }

    #calendar {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: #111827 !important; /* text-gray-900 */
    }

    .fc-button {
        background-color: #f97316 !important; /* orange-500 */
        border: none !important;
        border-radius: 0.75rem !important;
        padding: 0.4rem 1rem !important;
        font-weight: 600 !important;
        text-transform: none !important;
        font-size: 0.875rem !important;
    }

    .fc-button:hover {
        background-color: #ea580c !important; /* orange-600 */
    }

    .fc-button-primary:not(:disabled):active,
    .fc-button-primary:not(:disabled):focus {
        box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.4) !important;
    }

    .fc-event {
        background-color: #6366f1 !important; /* indigo-500 */
        border: none !important;
        border-radius: 0.5rem !important;
        padding: 3px 8px !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
    }

    .fc-daygrid-event-dot {
        display: none !important;
    }

    .fc-daygrid-event {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<!-- Modal Notifikasi -->
<div id="notificationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 backdrop-blur-sm">
    <div class="bg-white w-full max-w-sm mx-auto rounded-2xl shadow-xl p-6 space-y-4 animate-scale-in">
        <div class="flex items-center gap-3">
            <svg id="modalIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path id="modalIconPath" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7" />
            </svg>
            <h2 id="notificationTitle" class="text-lg font-semibold text-gray-800">Berhasil!</h2>
        </div>
        <p id="notificationText" class="text-gray-600 text-sm">Deadline berhasil diperbarui.</p>
        <div class="text-right">
            <button onclick="closeNotification()"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-full">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
@keyframes scale-in {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.animate-scale-in {
    animation: scale-in 0.2s ease-out;
}
</style>

@endsection
<script>
    function showNotification(success = true, message = 'Deadline berhasil diperbarui.') {
        const modal = document.getElementById('notificationModal');
        const icon = document.getElementById('modalIcon');
        const iconPath = document.getElementById('modalIconPath');
        const title = document.getElementById('notificationTitle');
        const text = document.getElementById('notificationText');

        // Ubah tampilan berdasarkan hasil
        if (success) {
            icon.classList.remove('text-red-500');
            icon.classList.add('text-green-500');
            iconPath.setAttribute('d', "M5 13l4 4L19 7");
            title.textContent = 'Berhasil!';
        } else {
            icon.classList.remove('text-green-500');
            icon.classList.add('text-red-500');
            iconPath.setAttribute('d', "M6 18L18 6M6 6l12 12");
            title.textContent = 'Gagal!';
        }

        text.textContent = message;

        // Tampilkan modal
        modal.classList.remove('hidden');

        // Tutup otomatis setelah 3 detik
        setTimeout(closeNotification, 3000);
    }

    function closeNotification() {
        document.getElementById('notificationModal').classList.add('hidden');
    }
</script>

