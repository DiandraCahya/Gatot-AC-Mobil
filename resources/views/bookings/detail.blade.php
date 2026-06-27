<div class="p-6 bg-white rounded-lg shadow-md max-w-4xl mx-auto md:p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Detail Pemesanan</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Pemohon Card -->
        <div class="bg-gray-50 rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800">Informasi Pemohon</h3>
            </div>
            <div class="space-y-4 text-gray-700">
                <p><span class="font-semibold">Nama:</span> {{ $booking->user->name }}</p>
                <p><span class="font-semibold">Email:</span> {{ $booking->user->email }}</p>
                <p><span class="font-semibold">Telepon:</span> {{ $booking->user->nomor }}</p>
                <p><span class="font-semibold">Alamat:</span> {{ $booking->user->alamat }}</p>
            </div>
        </div>

        <!-- Informasi Pesanan Card -->
        <div class="bg-gray-50 rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800">Informasi Pesanan</h3>
            </div>
            <div class="space-y-4 text-gray-700">
                <p>
                    <span class="font-semibold">Status:</span>
                    <span class="px-3 py-1 rounded-full text-white text-sm font-medium"
                        :class="{
                            'bg-yellow-500': '{{ $booking->status }}' === 'pending',
                            'bg-green-500': '{{ $booking->status }}' === 'approved',
                            'bg-red-500': '{{ $booking->status }}' === 'rejected'
                        }">
                        {{ ucfirst($booking->status) }}
                    </span>
                </p>
                <p><span class="font-semibold">Jenis Layanan:</span> {{ $booking->jenis }}</p>
                <p><span class="font-semibold">Tanggal:</span> {{ $booking->tanggal }}</p>
                <p><span class="font-semibold">Jam:</span> {{ date('H:i', strtotime($booking->jam)) }}</p>
                <p><span class="font-semibold">Mobil:</span> {{ $booking->mobil }}</p>
                <p><span class="font-semibold">Lokasi:</span> {{ $booking->tempat ? 'Di Bengkel' : $booking->user->alamat }}</p>
                @if ($booking->keterangan)
                    <p><span class="font-semibold">Keterangan:</span> {{ $booking->keterangan }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6 text-center">
        <button onclick="document.getElementById('bookingModal').classList.add('hidden')" class="w-full md:w-auto px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow">
            Tutup
        </button>
    </div>
</div>