<x-app-layout>
    @section('title', 'Dashboard')
    <div class="container mx-auto px-4 sm:px-6 py-6 space-y-6">
        {{-- Header --}}
        <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden p-4 sm:p-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-200">Selamat Datang, {{ $user->name }}!</h1>
            <p class="text-sm sm:text-base text-gray-300">Email: {{ $user->email }}</p>
            <p class="text-sm sm:text-base text-gray-300">Nomor Telepon: {{ $user->nomor }}</p>
        </div>

        {{-- Pesan Masuk --}}
        <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-bold text-gray-200 mb-4">Pesan Masuk</h2>
            @if ($messages->isEmpty())
                <p class="text-sm sm:text-base text-gray-300">Belum ada pesan masuk.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($messages as $message)
                        <li class="bg-white/5 rounded-lg p-3 sm:p-4">
                            <div class="text-sm sm:text-base text-gray-200"><strong>Dari:</strong>
                                {{ $message->sender->name }}</div>
                            <div class="text-sm sm:text-base text-gray-200"><strong>Pesan:</strong>
                                {{ $message->message }}</div>
                            <span
                                class="text-xs sm:text-sm text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
            <a href="{{ route('Chat') }}">
                <button
                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 sm:px-4 sm:py-2 text-sm sm:text-base rounded-md transition-colors duration-200">
                    Lihat Semua Pesan
                </button>
            </a>
        </div>

        {{-- Riwayat Booking --}}
        <h2 class="text-lg sm:text-xl font-bold text-gray-200">Riwayat Booking</h2>
        <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden">
            <div class="relative">
                @if ($bookings->isEmpty())
                    <p class="text-sm sm:text-base text-gray-300 p-4 sm:p-6">Belum ada riwayat booking.</p>
                @else
                    <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-transparent">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr class="bg-gray-800/50">
                                    <th
                                        class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center">
                                        Tanggal</th>
                                    <th
                                        class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center">
                                        Jenis</th>
                                    <th
                                        class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center">
                                        Status</th>
                                    <th
                                        class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center hidden sm:table-cell">
                                        Mobil</th>
                                    <th
                                        class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($bookings as $booking)
                                    <tr class="hover:bg-white/5 transition-colors duration-200">
                                        <td
                                            class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm text-gray-200 text-center">
                                            {{ $booking->tanggal }}</td>
                                        <td
                                            class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm text-gray-200 text-center">
                                            {{ $booking->jenis }}</td>
                                        <td class="py-3 px-4 sm:py-4 sm:px-6 text-center">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm font-medium
                                            @if ($booking->status == 'pending') bg-yellow-400/20 text-yellow-400
                                            @elseif($booking->status == 'approved') bg-green-400/20 text-green-400
                                            @else bg-red-400/20 text-red-400 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td
                                            class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm text-gray-200 text-center hidden sm:table-cell">
                                            {{ $booking->mobil }}</td>
                                        <td class="py-3 px-4 sm:py-4 sm:px-6 text-center">
                                            <div class="flex justify-center gap-2">
                                                <button type="button"
                                                    onclick="{{ $booking->struk ? 'openStrukDetail(' . $booking->id . ')' : 'openBookingModal(' . $booking->id . ')' }}"
                                                    class="inline-flex items-center px-2 py-1 sm:px-3 sm:py-1.5 rounded-md text-xs sm:text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Detail</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if ($bookings->hasPages())
                    <div class="px-6 py-4 bg-gray-800/50 border-t border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">
                                    Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }}
                                    of {{ $bookings->total() }} results
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- Previous Page Link --}}
                                @if ($bookings->onFirstPage())
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-gray-500 bg-gray-700/50 cursor-not-allowed">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $bookings->previousPageUrl() }}&payments_page={{ request('payments_page', 1) }}"
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                        Previous
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                <div class="hidden sm:flex gap-1">
                                    @foreach ($bookings->getUrlRange(max($bookings->currentPage() - 2, 1), min($bookings->currentPage() + 2, $bookings->lastPage())) as $page => $url)
                                        @if ($page == $bookings->currentPage())
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}&payments_page={{ request('payments_page', 1) }}"
                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-gray-300 hover:bg-white/10 transition-colors duration-200">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Next Page Link --}}
                                @if ($bookings->hasMorePages())
                                    <a href="{{ $bookings->nextPageUrl() }}&payments_page={{ request('payments_page', 1) }}"
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                        Next
                                    </a>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-gray-500 bg-gray-700/50 cursor-not-allowed">
                                        Next
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Riwayat Pembayaran --}}
        <h2 class="text-lg sm:text-xl font-bold text-gray-200">Riwayat Pembayaran</h2>
        <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden">
            @if ($payments->isEmpty())
                <p class="text-sm sm:text-base text-gray-300 p-4 sm:p-6">Belum ada pembayaran yang tercatat.</p>
            @else
                <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-transparent">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr class="bg-gray-800/50">
                                <th
                                    class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center">
                                    Tanggal</th>
                                <th
                                    class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center">
                                    Total</th>
                                <th
                                    class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center">
                                    Status</th>
                                <th
                                    class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm font-medium text-gray-300 uppercase tracking-wider text-center hidden sm:table-cell">
                                    Garansi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($payments as $payment)
                                <tr class="hover:bg-white/5 transition-colors duration-200">
                                    <td class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm text-gray-200 text-center">
                                        {{ $payment->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 sm:py-4 sm:px-6 text-xs sm:text-sm text-gray-200 text-center">
                                        Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 sm:py-4 sm:px-6 text-center">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm font-medium
                                            @if ($payment->payment_status == 'paid') bg-green-400/20 text-green-400
                                            @elseif($payment->payment_status == 'unpaid') bg-yellow-400/20 text-yellow-400
                                            @else bg-blue-400/20 text-blue-400 @endif">
                                            {{ ucfirst($payment->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 sm:py-4 sm:px-6 text-center hidden sm:table-cell">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm font-medium
                                            @if ($payment->is_garansi) bg-blue-400/20 text-blue-400
                                            @else bg-gray-400/20 text-gray-400 @endif">
                                            {{ $payment->is_garansi ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($payments->hasPages())
                        <div class="px-6 py-4 bg-gray-800/50 border-t border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-400">
                                        Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }}
                                        of {{ $payments->total() }} results
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    {{-- Previous Page Link --}}
                                    @if ($payments->onFirstPage())
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-gray-500 bg-gray-700/50 cursor-not-allowed">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $payments->previousPageUrl() }}&bookings_page={{ request('bookings_page', 1) }}"
                                            class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                            Previous
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    <div class="hidden sm:flex gap-1">
                                        @foreach ($payments->getUrlRange(max($payments->currentPage() - 2, 1), min($payments->currentPage() + 2, $payments->lastPage())) as $page => $url)
                                            @if ($page == $payments->currentPage())
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600">
                                                    {{ $page }}
                                                </span>
                                            @else
                                                <a href="{{ $url }}&bookings_page={{ request('bookings_page', 1) }}"
                                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-gray-300 hover:bg-white/10 transition-colors duration-200">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>

                                    {{-- Next Page Link --}}
                                    @if ($payments->hasMorePages())
                                        <a href="{{ $payments->nextPageUrl() }}&bookings_page={{ request('bookings_page', 1) }}"
                                            class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                            Next
                                        </a>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-gray-500 bg-gray-700/50 cursor-not-allowed">
                                            Next
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div id="bookingModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden flex justify-center z-40 p-4 overflow-y-auto">
        <div id="modalWrapper" class="flex flex-col items-center min-h-screen w-full ">
            <div id="modalContent" class="p-6 w-full max-w-3xl  rounded-lg shadow-lg">

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openBookingModal(bookingId) {
                fetch(`/bookings/${bookingId}/details`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('bookingModal').classList.remove('hidden');
                    });
            }

            function openStrukDetail(bookingId) {
                fetch(`/bookings/${bookingId}/struks`)
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
    @endpush
</x-app-layout>
