<div id="bookingModal" class="p-8 bg-white rounded-lg shadow-md max-w-4xl mx-auto md:p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Detail Pemesanan</h2>

    <div class="bg-gray-100 rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center mb-4">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-800">Informasi Pesanan</h3>
        </div>

        <div class="space-y-4">
            <!-- Status Badge -->
            <div>
                <h4 class="text-gray-500 text-base mb-1">Status</h4>
                <span
                    class="inline-flex px-4 py-2 rounded-full text-base font-medium
                        @if ($booking->status == 'pending') bg-yellow-100 text-yellow-700
                        @elseif($booking->status == 'approved') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700 @endif">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <div>
                <h4 class="text-gray-500 text-base mb-1">Jenis Layanan</h4>
                <p class="text-lg font-medium text-gray-800">{{ $booking->jenis }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="text-gray-500 text-base mb-1">Tanggal</h4>
                    <p class="text-lg font-medium text-gray-800">{{ $booking->tanggal }}</p>
                </div>
                <div>
                    <h4 class="text-gray-500 text-base mb-1">Jam</h4>
                    <p class="text-lg font-medium text-gray-800">{{ date('H:i', strtotime($booking->jam)) }}</p>
                </div>
            </div>

            <div>
                <h4 class="text-gray-500 text-base mb-1">Mobil</h4>
                <p class="text-lg font-medium text-gray-800">{{ $booking->mobil }}</p>
            </div>

            <div>
                <h4 class="text-gray-500 text-base mb-1">Lokasi</h4>
                <p class="text-lg font-medium text-gray-800">
                    {{ $booking->tempat ? 'Di Bengkel' : $booking->user->alamat }}
                </p>
            </div>

            @if ($booking->keterangan)
                <div>
                    <h4 class="text-gray-500 text-base mb-1">Keterangan</h4>
                    <p class="text-lg font-medium text-gray-800">{{ $booking->keterangan }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-6 text-center">
        <button onclick="document.getElementById('bookingModal').classList.add('hidden')" class="w-full md:w-auto px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow">
            Tutup
        </button>
    </div>
</div>