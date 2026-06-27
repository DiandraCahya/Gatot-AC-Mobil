<div class="max-w-4xl mx-auto p-4 sm:p-6 bg-gray-200 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Detail Struk</h2>

    <!-- Booking Details -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Informasi Pemohon</h3>
            <div class="space-y-3">
                <p class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Nama:</span>
                    <span class="text-gray-800 mt-1 sm:mt-0">{{ $struk->booking->user->name }}</span>
                </p>
                <p class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Email:</span>
                    <span class="text-gray-800 mt-1 sm:mt-0">{{ $struk->booking->user->email }}</span>
                </p>
                <p class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Telepon:</span>
                    <span class="text-gray-800 mt-1 sm:mt-0">{{ $struk->booking->user->nomor }}</span>
                </p>
                <p class="flex flex-col sm:flex-row sm:justify-between">
                    <span class="text-gray-600 font-medium">Alamat:</span>
                    <span class="text-gray-800 mt-1 sm:mt-0">{{ $struk->booking->user->alamat }}</span>
                </p>
            </div>
        </div>

        <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Informasi Pesanan</h3>
            <div class="space-y-3">
                <p class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Jenis Layanan:</span>
                    <span class="text-gray-800 mt-1 sm:mt-0">{{ $struk->booking->jenis }}</span>
                </p>
                <p class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Tanggal:</span>
                    <span class="text-gray-800 mt-1 sm:mt-0">{{ $struk->booking->tanggal }}</span>
                </p>
                <p class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Mobil:</span>
                    <span class="text-gray-800 mt-1 sm:mt-0">{{ $struk->booking->mobil }}</span>
                </p>
                <p class="flex flex-col sm:flex-row sm:justify-between">
                    <span class="text-gray-600 font-medium">Lokasi:</span>
                    <span
                        class="text-gray-800 mt-1 sm:mt-0">{{ $struk->booking->tempat ? 'Di Bengkel' : $struk->booking->user->alamat }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Items Section -->
    <div class="bg-gray-100 rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Item Service</h3>
        <div id="itemContainer" class="space-y-4">
            @foreach ($struk->items as $item)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6">
                            <span class="text-gray-700 font-medium">{{ $item->name }}</span>
                        </div>
                        <div class="col-span-2 text-right">
                            <span class="text-gray-600">{{ $item->quantity }}x</span>
                        </div>
                        <div class="col-span-4 text-right">
                            <span class="text-gray-800 font-medium">Rp
                                {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Deskripsi -->
    <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
        <label class="block text-gray-700 text-lg font-semibold mb-3 border-b pb-2">
            Deskripsi
        </label>
        <div class="bg-gray-50 rounded-lg p-4 text-gray-800 border border-gray-100">
            {{ $struk->description }}
        </div>
    </div>

    <!-- Status -->
    <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
        <label class="block text-gray-700 text-lg font-semibold mb-3 border-b pb-2">
            Status
        </label>
        <div>
            <span
                class="inline-flex px-4 py-2 rounded-full text-sm font-medium {{ $struk->payment_status === 'paid' ? 'bg-green-100 text-green-800' : ($struk->payment_status === 'cek' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                {{ ucfirst($struk->payment_status) }}
            </span>
        </div>
    </div>

    <!-- Warranty Section -->
    @if ($struk->is_garansi)
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            @php
                $today = \Carbon\Carbon::now();
                $garansiDate = \Carbon\Carbon::parse($struk->garansi_date);
                $isExpired = $today->gt($garansiDate);
            @endphp
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Informasi Garansi</h3>
            <div class="space-y-3">
                <p class="flex flex-col sm:flex-row sm:justify-between">
                    <span class="text-gray-600 font-medium">Status Garansi:</span>
                    <span
                        class="inline-flex px-4 py-2 rounded-full text-sm font-medium {{ $isExpired ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $isExpired ? 'Expired' : 'Aktif' }}
                    </span>
                </p>
                <p class="flex flex-col sm:flex-row sm:justify-between">
                    <span class="text-gray-600 font-medium">Berlaku Sampai:</span>
                    <span
                        class="text-gray-800">{{ \Carbon\Carbon::parse($struk->garansi_date)->format('d M Y') }}</span>
                </p>
                <p class="flex flex-col sm:flex-row sm:justify-between">
                    <span class="text-gray-600 font-medium">Deskripsi:</span>
                    <span class="text-gray-800">{{ $struk->garansi_desc }}</span>
                </p>
            </div>
        </div>
    @endif

    <!-- Total -->
    <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg mb-6">
        <h3 class="text-xl font-semibold flex justify-between items-center">
            <span>Total Pembayaran:</span>
            <span class="text-2xl">Rp. {{ number_format($struk->total_amount, 0, ',', '.') }}</span>
        </h3>
    </div>

    <div class="mt-6 text-center">
        <button onclick="document.getElementById('bookingModal').classList.add('hidden')"
            class="w-full md:w-auto px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow">
            Tutup
        </button>
    </div>
</div>
