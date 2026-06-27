<div>
    {{-- Search and Filter Section --}}
    <div class="bg-white/5 backdrop-blur-lg rounded-xl p-4 md:p-6 mb-4 md:mb-6 shadow-lg">
        <div class="mb-4">
            <h2 class="text-lg md:text-xl font-semibold text-white mb-2">Filter & Pencarian</h2>
            <p class="text-gray-400 text-sm">Gunakan filter di bawah untuk mempermudah pencarian data booking</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
            {{-- Search Input with icon --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.defer="search" wire:change="$refresh"
                    placeholder="Cari nama, mobil, atau jenis..."
                    class="bg-white/10 border-0 text-white placeholder-gray-400 w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white/20 transition-all duration-200">
            </div>

            {{-- Date Filter with icon --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <input type="date" wire:model.defer="date" wire:change="$refresh"
                    class="bg-white/10 border-0 text-white w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white/20 transition-all duration-200">
            </div>

            {{-- Status Pembayaran --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <select wire:model.defer="payment_status" wire:change="$refresh"
                    class="bg-white/10 border-0 text-white w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white/20 transition-all duration-200 appearance-none">
                    <option value="" class="bg-gray-800">Semua Status Pembayaran</option>
                    <option value="paid" class="bg-gray-800">Paid</option>
                    <option value="unpaid" class="bg-gray-800">Unpaid</option>
                    <option value="cek" class="bg-gray-800">Cek</option>
                </select>
            </div>

            {{-- Status Booking --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <select wire:model.defer="booking_status" wire:change="$refresh"
                    class="bg-white/10 border-0 text-white w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white/20 transition-all duration-200 appearance-none">
                    <option value="" class="bg-gray-800">Semua Status Booking</option>
                    <option value="pending" class="bg-gray-800">Pending</option>
                    <option value="approved" class="bg-gray-800">Approved</option>
                    <option value="rejected" class="bg-gray-800">Rejected</option>
                </select>
            </div>
        </div>

        {{-- Reset Filter Button --}}
        <div class="mt-4 md:mt-6 flex justify-end">
            <button wire:click="resetFilters"
                class="w-full sm:w-auto bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors duration-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset Filter
            </button>
        </div>
    </div>

    {{-- Table Section with Loading State --}}
    <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden relative">
        {{-- Loading Overlay --}}
        <div wire:loading class="absolute inset-0 bg-gray-900/50 z-10">
            <div class="flex items-center justify-center h-full">
                <div class="flex flex-col items-center">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-white"></div>
                    <span class="mt-2 text-white">Loading...</span>
                </div>
            </div>
        </div>

        {{-- Desktop View (hidden on mobile) --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr class="bg-gray-800/50">
                        <th class="py-4 px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                            Pemohon</th>
                        <th class="py-4 px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                            Jenis</th>
                        <th class="py-4 px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                            Tanggal</th>
                        <th class="py-4 px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                            Lokasi</th>
                        <th class="py-4 px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                            Status</th>
                        <th class="py-4 px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-white/5 transition-colors duration-200">
                            <td class="py-4 px-6 text-sm text-gray-200 text-center">
                                {{ $booking->user->name }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-200 text-center">
                                {{ $booking->jenis }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-200 text-center">
                                {{ $booking->tanggal }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-200 text-center">
                                {{ $booking->tempat ? 'Di Bengkel' : $booking->user->alamat }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex flex-wrap gap-2 justify-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        @if ($booking->status == 'pending') bg-yellow-400/20 text-yellow-400
                                        @elseif($booking->status == 'approved') bg-green-400/20 text-green-400
                                        @else bg-red-400/20 text-red-400 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    @if (isset($booking->struk))
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if ($booking->struk->payment_status == 'paid') bg-green-400/20 text-green-400
                                            @elseif($booking->struk->payment_status == 'unpaid') bg-red-400/20 text-red-400 
                                            @elseif ($booking->struk->payment_status == 'cek') bg-blue-400/20 text-blue-400 @endif">
                                            {{ ucfirst($booking->struk->payment_status) }}
                                        </span>
                                        @if (isset($booking->struk->garansi_date))
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                @if (\Carbon\Carbon::parse($booking->struk->garansi_date)->isFuture()) bg-blue-400/20 text-blue-400
                                                @else bg-gray-400/20 text-gray-400 @endif">
                                                {{ \Carbon\Carbon::parse($booking->struk->garansi_date)->isFuture() ? 'Active' : 'Expired' }}
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center gap-2">
                                    @if (!$booking->struk)
                                        <button type="button" onclick="openBookingModal({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </button>
                                    @endif

                                    @if ($booking->struk)
                                        @if ($booking->struk->payment_status == 'paid' || $booking->struk->payment_status == 'cek')
                                            <button type="button"
                                                onclick="confirmDownload('{{ route('struk.generate', $booking->struk->id) }}')"
                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-7-4v6m0 0l-3-3m3 3l3-3m-7-4a4 4 0 118 0 4 4 0 01-8 0z" />
                                                </svg>
                                                Unduh Struk
                                            </button>
                                        @endif
                                    @endif

                                    @if ($booking->status == 'pending')
                                        <form id="approvalForm" action="{{ route('bookings.approve', $booking->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" onclick="confirmApproval()"
                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Setuju
                                            </button>
                                        </form>
                                        <button type="button" onclick="openRejectModal({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Tolak
                                        </button>
                                    @elseif ($booking->status == 'approved')
                                        @if (!$booking->struk)
                                            <button type="button"
                                                onclick="Livewire.dispatch('createStrukModal', { bookingId: {{ $booking->id }} })"
                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Buat Struk
                                            </button>
                                        @else
                                            <button type="button"
                                                onclick="Livewire.dispatch('editStrukModal', { strukId: {{ $booking->struk->id }} });"
                                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Detail Struk
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-6 text-center text-gray-400">
                                Tidak ada data booking yang ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile View (visible only on mobile) --}}
        <div class="md:hidden">
            <div class="divide-y divide-gray-700">
                @forelse ($bookings as $booking)
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-white font-medium">{{ $booking->user->name }}</h3>
                                <p class="text-sm text-gray-400">{{ $booking->jenis }}</p>
                            </div>
                            <div class="flex flex-wrap gap-1">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if ($booking->status == 'pending') bg-yellow-400/20 text-yellow-400
                                    @elseif($booking->status == 'approved') bg-green-400/20 text-green-400
                                    @else bg-red-400/20 text-red-400 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <span class="text-gray-400">Tanggal:</span>
                                <p class="text-white">{{ $booking->tanggal }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Lokasi:</span>
                                <p class="text-white">{{ $booking->tempat ? 'Di Bengkel' : $booking->user->alamat }}
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-center gap-2 pt-2">
                            @if (!$booking->struk)
                                <button type="button" onclick="openBookingModal({{ $booking->id }})"
                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </button>
                            @endif

                            @if ($booking->struk)
                                @if ($booking->struk->payment_status == 'paid' || $booking->struk->payment_status == 'cek')
                                    <button type="button"
                                        onclick="confirmDownload('{{ route('struk.generate', $booking->struk->id) }}')"
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-7-4v6m0 0l-3-3m3 3l3-3m-7-4a4 4 0 118 0 4 4 0 01-8 0z" />
                                        </svg>
                                        Unduh Struk
                                    </button>
                                @endif
                            @endif

                            @if ($booking->status == 'pending')
                                <form id="approvalForm" action="{{ route('bookings.approve', $booking->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" onclick="confirmApproval()"
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Setuju
                                    </button>
                                </form>
                                <button type="button" onclick="openRejectModal({{ $booking->id }})"
                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak
                                </button>
                            @elseif ($booking->status == 'approved')
                                @if (!$booking->struk)
                                    <button type="button"
                                        onclick="Livewire.dispatch('createStrukModal', { bookingId: {{ $booking->id }} })"
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Buat Struk
                                    </button>
                                @else
                                    <button type="button"
                                        onclick="Livewire.dispatch('editStrukModal', { strukId: {{ $booking->struk->id }} });"
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Detail Struk
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-400">
                        Tidak ada data booking yang ditemukan
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        @if ($bookings->hasPages())
            <div class="px-4 md:px-6 py-4 bg-gray-800/50 border-t border-gray-700">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-400 w-full sm:w-auto text-center sm:text-left">
                        Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }}
                        of {{ $bookings->total() }} results
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto justify-center">
                        {{-- Previous Page Link --}}
                        @if ($bookings->onFirstPage())
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-gray-500 bg-gray-700/50 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <button wire:click="previousPage" wire:loading.attr="disabled"
                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Previous
                            </button>
                        @endif

                        <div class="hidden sm:flex gap-1">
                            @foreach ($bookings->getUrlRange(max($bookings->currentPage() - 2, 1), min($bookings->currentPage() + 2, $bookings->lastPage())) as $page => $url)
                                @if ($page == $bookings->currentPage())
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})"
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-gray-300 hover:bg-white/10 transition-colors duration-200">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Page Link --}}
                        @if ($bookings->hasMorePages())
                            <button wire:click="nextPage" wire:loading.attr="disabled"
                                class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Next
                            </button>
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
