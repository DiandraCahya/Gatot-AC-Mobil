<x-app-layout>
    @section('title', 'Layanan')
    <div class="min-h-screen py-4 sm:py-8 rounded-lg">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <x-slot name="header">
                <div class="justify-between items-center inline">
                    <h2 class="font-bold text-xl sm:text-2xl leading-tight">
                        {{ __('Layanan') }}
                    </h2>
                </div>
            </x-slot>

            <div class="mb-4 sm:mb-6">
                <!-- Informasi Layanan -->
                <div class="grid gap-4 sm:gap-6 mb-6 sm:mb-8">
                    <div class="bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md">
                        <h3 class="text-xl sm:text-2xl font-bold text-green-500 mb-4 text-center">Layanan Gatot AC Mobil
                        </h3>

                        <div class="space-y-4 sm:space-y-6">
                            @foreach ($jasa as $jasas)
                                <div class="border-b border-gray-700 pb-4">
                                    <h4 class="font-semibold text-green-400 text-base sm:text-lg mb-2">
                                        {{ $jasas->name }}</h4>
                                    <p class="text-gray-300 mb-3 text-sm sm:text-base">
                                        {{ $jasas->description }}
                                    </p>
                                    <p class="text-gray-200 text-sm sm:text-base">
                                        Harga: <span class="text-green-400 font-semibold">Rp {{ $jasas->price }}</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Button Booking -->
                <div class="text-center">
                    <button onclick="Livewire.dispatch('CreateBookingModal')"
                        class="w-full sm:w-auto group relative inline-flex items-center justify-center overflow-hidden rounded-lg px-4 sm:px-8 py-2 sm:py-3 bg-green-600 hover:bg-green-700 transition-all duration-300">
                        <span class="text-white text-base sm:text-lg font-bold">
                            Tambah Booking
                        </span>
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 sm:mb-6 transform transition-all duration-300 ease-in-out">
                    <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-lg p-3 sm:p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-green-400" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs sm:text-sm text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden">
                <div class="relative">
                    <div class="overflow-x-auto">
                        @if ($bookings->isEmpty())
                            <div class="flex flex-col items-center justify-center py-8 sm:py-12">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400 mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-base sm:text-lg font-medium text-gray-400">Belum ada booking yang dibuat
                                </p>
                                <p class="text-xs sm:text-sm text-gray-500 mt-2">Silakan buat booking baru untuk memulai
                                </p>
                            </div>
                        @else
                            <div class="min-w-full">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead class="bg-gray-800/50">
                                        <tr>
                                            <th
                                                class="px-3 py-3 sm:px-6 sm:py-4 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                                                Jenis
                                            </th>
                                            <th
                                                class="px-3 py-3 sm:px-6 sm:py-4 text-xs font-medium text-gray-300 uppercase tracking-wider text-center hidden sm:table-cell">
                                                Tanggal
                                            </th>
                                            <th
                                                class="px-3 py-3 sm:px-6 sm:py-4 text-xs font-medium text-gray-300 uppercase tracking-wider text-center hidden sm:table-cell">
                                                Mobil
                                            </th>
                                            <th
                                                class="px-3 py-3 sm:px-6 sm:py-4 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                                                Status
                                            </th>
                                            <th
                                                class="px-3 py-3 sm:px-6 sm:py-4 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach ($bookings as $booking)
                                            <tr class="hover:bg-white/5 transition-colors duration-200">
                                                <td
                                                    class="px-3 py-3 sm:px-6 sm:py-4 text-xs sm:text-sm text-gray-200 text-center">
                                                    {{ $booking->jenis }}
                                                    <div class="sm:hidden text-xs text-gray-400 mt-1">
                                                        {{ $booking->tanggal }}<br>
                                                        {{ $booking->mobil }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-3 py-3 sm:px-6 sm:py-4 text-xs sm:text-sm text-gray-200 text-center hidden sm:table-cell">
                                                    {{ $booking->tanggal }}
                                                </td>
                                                <td
                                                    class="px-3 py-3 sm:px-6 sm:py-4 text-xs sm:text-sm text-gray-200 text-center hidden sm:table-cell">
                                                    {{ $booking->mobil }}
                                                </td>
                                                <td class="px-3 py-3 sm:px-6 sm:py-4 text-center">
                                                    <div class="flex flex-wrap gap-1 sm:gap-2 justify-center">
                                                        <span
                                                            class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium
                                                        @if ($booking->status == 'pending') bg-yellow-400/20 text-yellow-400
                                                        @elseif($booking->status == 'approved') bg-green-400/20 text-green-400
                                                        @else bg-red-400/20 text-red-400 @endif">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-3 sm:px-6 sm:py-4 text-center">
                                                    <div class="flex flex-wrap justify-center gap-1 sm:gap-2">
                                                        <!-- Action buttons with responsive styling -->
                                                        @if (!$booking->struk)
                                                            <button type="button"
                                                                onclick="openBookingModal({{ $booking->id }})"
                                                                class="inline-flex items-center px-2 sm:px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                </svg>
                                                                Detail
                                                            </button>
                                                        @endif
                                                        @if ($booking->struk)
                                                            @if ($booking->struk->payment_status == 'paid' || $booking->struk->payment_status == 'cek')
                                                                <button type="button"
                                                                    onclick="confirmDownload('{{ route('struk.generate', $booking->struk->id) }}')"
                                                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                                                    <svg class="w-4 h-4 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-7-4v6m0 0l-3-3m3 3l3-3m-7-4a4 4 0 118 0 4 4 0 01-8 0z" />
                                                                    </svg>
                                                                    Unduh Struk
                                                                </button>
                                                            @endif
                                                        @endif

                                                        @if ($booking->struk && $booking->struk->payment_status === 'paid')
                                                            @if (!$booking->rating)
                                                                <button type="button"
                                                                    onclick="openRatingModal({{ $booking->id }})"
                                                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-yellow-600 hover:bg-yellow-700 transition-colors duration-200">
                                                                    <svg class="w-4 h-4 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                                    </svg>
                                                                    Beri Rating
                                                                </button>
                                                            @endif
                                                        @endif

                                                        @if ($booking->struk && $booking->struk->payment_status === 'unpaid')
                                                            <button type="button"
                                                                onclick="initiatePayment({{ $booking->struk->id }})"
                                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                </svg>
                                                                Bayar Sekarang
                                                            </button>
                                                        @endif

                                                        @if ($booking->struk)
                                                            <button type="button"
                                                                onclick="openStrukDetail({{ $booking->id }})"
                                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                Detail Struk
                                                            </button>
                                                        @endif

                                                        @if ($booking->status == 'pending')
                                                            <button type="button"
                                                                onclick="Livewire.dispatch('EditBookingModal', { bookingId: {{ $booking->id }} })"
                                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                                Edit
                                                            </button>
                                                        @endif

                                                        @if (in_array($booking->status, ['pending', 'rejected']))
                                                            <button type="button"
                                                                onclick="deleteBooking({{ $booking->id }})"
                                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    @if ($bookings->hasPages())
                        <div class="sticky left-0 right-0 bottom-0 min-w-full border-t border-gray-700">
                            <div class="px-3 py-3 sm:px-6 sm:py-4 bg-gray-800/50">
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                                    {{-- Results Info --}}
                                    <div class="w-full sm:w-auto text-center sm:text-left">
                                        <p class="text-xs sm:text-sm text-gray-400">
                                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }}
                                            of {{ $bookings->total() }} results
                                        </p>
                                    </div>

                                    {{-- Pagination Controls --}}
                                    <div class="flex items-center justify-center w-full sm:w-auto gap-2">
                                        {{-- Previous Page Link --}}
                                        @if ($bookings->onFirstPage())
                                            <span
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs sm:text-sm font-medium text-gray-500 bg-gray-700/50 rounded-md cursor-not-allowed">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </span>
                                        @else
                                            <a href="{{ $bookings->previousPageUrl() }}"
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs sm:text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </a>
                                        @endif

                                        {{-- Page Numbers - Desktop --}}
                                        <div class="hidden sm:flex items-center gap-1">
                                            @foreach ($bookings->getUrlRange(max($bookings->currentPage() - 2, 1), min($bookings->currentPage() + 2, $bookings->lastPage())) as $page => $url)
                                                @if ($page == $bookings->currentPage())
                                                    <span
                                                        class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-blue-600 rounded-md">
                                                        {{ $page }}
                                                    </span>
                                                @else
                                                    <a href="{{ $url }}"
                                                        class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-gray-300 hover:bg-white/10 rounded-md transition-colors duration-200">
                                                        {{ $page }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>

                                        {{-- Mobile Page Indicator --}}
                                        <span
                                            class="sm:hidden flex items-center justify-center px-3 py-1.5 text-xs font-medium text-gray-400 bg-gray-800/50 rounded-md">
                                            Page {{ $bookings->currentPage() }} of {{ $bookings->lastPage() }}
                                        </span>

                                        {{-- Next Page Link --}}
                                        @if ($bookings->hasMorePages())
                                            <a href="{{ $bookings->nextPageUrl() }}"
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs sm:text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs sm:text-sm font-medium text-gray-500 bg-gray-700/50 rounded-md cursor-not-allowed">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <livewire:create-booking />
            <livewire:edit-booking />

            <div id="bookingModal"
                class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden flex justify-center z-40 p-4 overflow-y-auto">
                <div id="modalWrapper" class="flex flex-col items-center min-h-screen w-full">
                    <div id="modalContent" class="p-6 w-full max-w-3xl text-white rounded-lg shadow-lg">

                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
            </script>
            <script>
                document.addEventListener('livewire:initialized', () => {
                    Livewire.on('booking-stored', () => {
                        window.location.reload();
                    });

                    Livewire.on('booking-updated', () => {
                        window.location.reload();
                    });
                });
            </script>
            <script>
                function openStrukDetail(bookingId) {
                    fetch(`/bookings/${bookingId}/struks`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('modalContent').innerHTML = html;
                            document.getElementById('bookingModal').classList.remove('hidden');
                        });
                }

                function deleteBooking(bookingId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Booking akan dihapus permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/bookings/${bookingId}/delete`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Terhapus!',
                                            data.message,
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Gagal!',
                                            data.error,
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(
                                        'Kesalahan!',
                                        'Terjadi kesalahan saat menghapus booking',
                                        'error'
                                    );
                                });
                        }
                    });
                }

                function confirmDownload(url) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan mengunduh struk ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, unduh!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect ke URL download
                            window.location.href = url;
                        }
                    });
                }

                function openBookingModal(bookingId) {
                    fetch(`/bookings/${bookingId}/details`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('modalContent').innerHTML = html;
                            document.getElementById('bookingModal').classList.remove('hidden');
                        });
                }

                function openEditBookingModal(bookingId) {
                    fetch(`/bookings/${bookingId}/edit`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('modalContent').innerHTML = html;
                            document.getElementById('bookingModal').classList.remove('hidden');
                        });
                }

                document.getElementById('closeModal').addEventListener('click', function() {
                    document.getElementById('bookingModal').classList.add('hidden');
                });

                document.getElementById('bookingModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                    }
                });
            </script>

            {{-- Midtrans Script --}}
            <script>
                function initiatePayment(strukId) {
                    // Show loading indicator
                    const loadingEl = document.createElement('div');
                    loadingEl.innerText = 'Memproses pembayaran...';
                    document.body.appendChild(loadingEl);

                    fetch(`/payment/token/${strukId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            loadingEl.remove();
                            if (data.snap_token) {
                                window.snap.pay(data.snap_token, {
                                    onSuccess: function(result) {
                                        console.log('success', result);
                                        location.reload();
                                    },
                                    onPending: function(result) {
                                        console.log('pending', result);
                                        alert('Pembayaran pending, silahkan selesaikan pembayaran');
                                    },
                                    onError: function(result) {
                                        console.log('error', result);
                                        alert('Pembayaran gagal: ' + result.status_message);
                                    },
                                    onClose: function() {
                                        console.log('customer closed the popup without finishing the payment');
                                        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                                    }
                                });
                            } else {
                                throw new Error('Snap token not found in response');
                            }
                        })
                        .catch(error => {
                            loadingEl.remove();
                            console.error('Payment Error:', error);
                            alert(`Terjadi kesalahan: ${error.message}`);
                        });
                }
            </script>


            {{-- Rating Script --}}
            <script>
                function openRatingModal(bookingId) {
                    fetch(`/ratings/create/${bookingId}`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('modalContent').innerHTML = html;
                            document.getElementById('bookingModal').classList.remove('hidden');

                            // Initialize rating functionality
                            initializeRating();
                        });
                }

                function initializeRating() {
                    const stars = document.querySelectorAll('.star');
                    const form = document.getElementById('ratingForm');

                    // Handle star selection
                    stars.forEach((star) => {
                        star.addEventListener('click', function() {
                            const rating = this.querySelector('input').value;

                            // Update radio button
                            this.querySelector('input').checked = true;

                            // Update star colors
                            stars.forEach(s => {
                                const svg = s.querySelector('.star-svg');
                                if (s.querySelector('input').value <= rating) {
                                    svg.classList.add('text-yellow-400');
                                    svg.classList.remove('text-gray-300');
                                } else {
                                    svg.classList.remove('text-yellow-400');
                                    svg.classList.add('text-gray-300');
                                }
                            });
                        });
                    });

                    // Handle form submission
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();

                            const formData = new FormData(this);
                            const bookingId = formData.get('booking_id');

                            // Create payload object
                            const payload = {
                                booking_id: bookingId,
                                rating: formData.get('rating'),
                                review: formData.get('review')
                            };

                            // Send request
                            fetch(this.action, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify(payload)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Sukses!', 'Rating berhasil disimpan', 'success')
                                            .then(() => {
                                                location.reload();
                                            });
                                    } else {
                                        Swal.fire('Error!', data.error || 'Terjadi kesalahan', 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan rating', 'error');
                                });
                        });
                    }
                }

                // Initialize when document loads
                document.addEventListener('DOMContentLoaded', function() {
                    // Only initialize if rating form exists on page load
                    if (document.getElementById('ratingForm')) {
                        initializeRating();
                    }
                });
            </script>
        @endpush
</x-app-layout>
