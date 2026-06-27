<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="$wire.showModal"
    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-gray-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-700"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="bg-gray-900 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-6 pb-2 border-b border-gray-700">
                        <h2 class="text-2xl font-bold text-white">
                            @if ($struk && $struk->exists)
                                @if ($struk->payment_status === 'paid')
                                    Detail Struk
                                @elseif ($struk->payment_status === 'cek')
                                    Cek struk
                                @else
                                    Edit Struk
                                @endif
                            @endif
                        </h2>
                    </div>

                    @if ($struk && $booking)
                        <!-- Customer & Order Info Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Customer Info -->
                            <div
                                class="bg-gray-800/50 p-5 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                <h3 class="text-lg font-semibold mb-4 text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Informasi Pemohon
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                        <span class="text-gray-400">Nama</span>
                                        <span class="text-white font-medium">{{ $booking->user->name }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                        <span class="text-gray-400">Email</span>
                                        <span class="text-white font-medium">{{ $booking->user->email }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                        <span class="text-gray-400">Telepon</span>
                                        <span class="text-white font-medium">{{ $booking->user->nomor }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-400">Alamat</span>
                                        <span class="text-white font-medium">{{ $booking->user->alamat }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Info -->
                            <div
                                class="bg-gray-800/50 p-5 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                <h3 class="text-lg font-semibold mb-4 text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Informasi Pesanan
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                        <span class="text-gray-400">Jenis Layanan</span>
                                        <span class="text-white font-medium">{{ $booking->jenis }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                        <span class="text-gray-400">Tanggal</span>
                                        <span class="text-white font-medium">{{ $booking->tanggal }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                        <span class="text-gray-400">Mobil</span>
                                        <span class="text-white font-medium">{{ $booking->mobil }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-400">Lokasi</span>
                                        <span class="text-white font-medium">
                                            {{ $booking->tempat ? 'Di Bengkel' : $booking->user->alamat }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (($struk->payment_status === 'unpaid' || $struk->payment_status === 'cek') && auth()->user()->is_admin)
                            <form wire:submit.prevent="save" class="space-y-8">
                                <!-- Items Section -->
                                <div class="bg-gray-800/50 border-gray-700 rounded-lg shadow-sm p-6">
                                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                                        <h3 class="text-lg font-semibold text-gray-300">Item Service</h3>
                                        <button type="button" wire:click="addItem"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out shadow-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Tambah Item
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        @foreach ($items as $index => $item)
                                            <div class="bg-gray-800/50 p-4 rounded-lg">
                                                <!-- Row 1: Nama dan Jumlah -->
                                                <div class="grid grid-cols-12 gap-4 mb-3">
                                                    <div class="col-span-8">
                                                        <label class="block text-sm font-medium text-gray-300 mb-1">Nama
                                                            Item</label>
                                                        <input type="text"
                                                            wire:model="items.{{ $index }}.name"
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                                                        @error("items.{$index}.name")
                                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-span-4">
                                                        <label
                                                            class="block text-sm font-medium text-gray-300 mb-1">Jumlah</label>
                                                        <input type="number"
                                                            wire:model="items.{{ $index }}.quantity"
                                                            wire:change="calculateItemTotal({{ $index }})"
                                                            min="1"
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                                                        @error("items.{$index}.quantity")
                                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Row 2: Harga Satuan, Total, dan Delete -->
                                                <div class="grid grid-cols-12 gap-4">
                                                    <div class="col-span-5">
                                                        <label
                                                            class="block text-sm font-medium text-gray-300 mb-1">Harga
                                                            Satuan</label>
                                                        <div class="relative">
                                                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                                            <input type="number"
                                                                wire:model="items.{{ $index }}.unit_price"
                                                                wire:change="calculateItemTotal({{ $index }})"
                                                                class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                                                            @error("items.{$index}.unit_price")
                                                                <span
                                                                    class="text-red-500 text-sm">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-span-5">
                                                        <label
                                                            class="block text-sm font-medium text-gray-300 mb-1">Total</label>
                                                        <div class="relative">
                                                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                                            <input type="number"
                                                                wire:model="items.{{ $index }}.price" readonly
                                                                class="w-full pl-9 pr-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                                                        </div>
                                                    </div>

                                                    <div class="col-span-2 flex items-end justify-center">
                                                        <button type="button"
                                                            wire:click="removeItem({{ $index }})"
                                                            class="p-2 hover:bg-red-100 rounded-lg text-red-600 transition duration-150 ease-in-out">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Description Section -->
                                <div
                                    class="bg-gray-800/50 p-6 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">
                                        Deskripsi</label>
                                    <textarea wire:model="description" rows="4"
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-400 transition-all duration-300 resize-none"
                                        placeholder="Masukkan deskripsi service..."></textarea>
                                    @error('description')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status Section -->
                                <div
                                    class="bg-gray-800/50 p-6 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">
                                        Status Pembayaran
                                    </label>
                                    <select wire:model="payment_status"
                                        class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white transition-all duration-300">
                                        <option value="unpaid">Belum Dibayar</option>
                                        <option value="paid">Sudah Dibayar</option>
                                        <option value="cek">Cek Saja</option>
                                    </select>
                                    @error('payment_status')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Warranty Section -->
                                <div
                                    class="bg-gray-800/50 p-6 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                    <div class="flex items-center mb-6">
                                        <input type="checkbox" wire:model="is_garansi" id="is_garansi"
                                            class="w-5 h-5 text-blue-600 border-gray-700 rounded focus:ring-blue-500 bg-gray-900">
                                        <label for="is_garansi" class="ml-2 text-sm font-medium text-white">
                                            Tambah Garansi
                                        </label>
                                    </div>

                                    <div class="space-y-6" x-show="$wire.is_garansi" x-transition>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                                Tanggal Berakhir Garansi
                                            </label>
                                            <input type="date" wire:model="garansi_date"
                                                class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white transition-all duration-300">
                                            @error('garansi_date')
                                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                                Deskripsi Garansi
                                            </label>
                                            <textarea wire:model="garansi_desc" rows="3"
                                                class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-400 transition-all duration-300 resize-none"
                                                placeholder="Masukkan detail garansi..."></textarea>
                                            @error('garansi_desc')
                                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Section -->
                                <div
                                    class="bg-gray-800/50 p-6 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-semibold text-white">Total Pembayaran</h3>
                                        <div class="text-2xl font-bold text-blue-400">
                                            Rp. {{ number_format($totalAmount, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-end pt-6 space-x-4">
                                    <button type="button" wire:click="closeModal"
                                        class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-all duration-300 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-300 flex items-center shadow-lg hover:shadow-blue-500/50">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Simpan Struk
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Read-only view for paid status -->
                            <div class="space-y-8">
                                <!-- Items Section -->
                                <div class="bg-gray-800/50 border-gray-700 rounded-lg shadow-sm p-6">
                                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                                        <h3 class="text-lg font-semibold text-gray-300">Item Service</h3>
                                    </div>

                                    <div class="space-y-4">
                                        @foreach ($items as $item)
                                            <div class="bg-gray-800/50 p-4 rounded-lg">
                                                <!-- Row 1: Nama dan Jumlah -->
                                                <div class="grid grid-cols-12 gap-4 mb-3">
                                                    <div class="col-span-8">
                                                        <label
                                                            class="block text-sm font-medium text-gray-300 mb-1">Nama
                                                            Item</label>
                                                        <div
                                                            class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white">
                                                            {{ $item['name'] }}
                                                        </div>
                                                    </div>

                                                    <div class="col-span-4">
                                                        <label
                                                            class="block text-sm font-medium text-gray-300 mb-1">Jumlah</label>
                                                        <div
                                                            class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white">
                                                            {{ $item['quantity'] }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Row 2: Harga Satuan dan Total -->
                                                <div class="grid grid-cols-12 gap-4">
                                                    <div class="col-span-6">
                                                        <label
                                                            class="block text-sm font-medium text-gray-300 mb-1">Harga
                                                            Satuan</label>
                                                        <div class="relative">
                                                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                                            <div
                                                                class="w-full pl-9 pr-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white">
                                                                {{ number_format($item['unit_price'], 0, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-span-6">
                                                        <label
                                                            class="block text-sm font-medium text-gray-300 mb-1">Total</label>
                                                        <div class="relative">
                                                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                                            <div
                                                                class="w-full pl-9 pr-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white">
                                                                {{ number_format($item['price'], 0, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Description Section -->
                                <div
                                    class="bg-gray-800/50 p-6 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                                    <div
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white min-h-[100px]">
                                        {{ $description }}
                                    </div>
                                </div>

                                <!-- Status Section -->
                                <div
                                    class="bg-gray-800/50 p-6 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Status
                                        Pembayaran</label>
                                    <div
                                        class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-white">
                                        @if ($payment_status === 'paid')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-900/50 text-green-400 border border-green-600">
                                                Sudah Dibayar
                                            </span>
                                        @elseif($payment_status === 'unpaid')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-900/50 text-yellow-400 border border-yellow-600">
                                                Belum Dibayar
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-900/50 text-blue-400 border border-blue-600">
                                                Cek Saja
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Warranty Section -->
                                @if ($is_garansi)
                                    <div
                                        class="bg-gray-800/50 p-6 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                        <h3 class="text-lg font-semibold text-white mb-4">Informasi Garansi</h3>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal
                                                    Berakhir Garansi</label>
                                                <div
                                                    class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-white">
                                                    {{ \Carbon\Carbon::parse($garansi_date)->format('d M Y') }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-300 mb-2">Status
                                                    Garansi</label>
                                                <div
                                                    class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-white">
                                                    @php
                                                        $today = \Carbon\Carbon::now();
                                                        $garansiDate = \Carbon\Carbon::parse($garansi_date);
                                                        $isExpired = $today->gt($garansiDate);
                                                    @endphp

                                                    @if ($isExpired)
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-900/50 text-red-400 border border-red-600">
                                                            Kadaluarsa
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-900/50 text-green-400 border border-green-600">
                                                            Aktif
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi
                                                    Garansi</label>
                                                <div
                                                    class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-white min-h-[80px]">
                                                    {{ $garansi_desc }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Total Section -->
                                <div
                                    class="bg-gray-800/50 p-6 rounded-xl border border-gray-700 shadow-lg backdrop-blur-sm">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-semibold text-white">Total Pembayaran</h3>
                                        <div class="text-2xl font-bold text-blue-400">
                                            Rp. {{ number_format($totalAmount, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-end pt-6">
                                    <button type="button" wire:click="closeModal"
                                        class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-all duration-300 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="fixed bottom-4 right-4 z-50 space-y-4">
        @if (session()->has('success'))
            <div class="bg-green-900/75 backdrop-blur-sm border border-green-500 text-green-300 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3"
                role="alert" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-900/75 backdrop-blur-sm border border-red-500 text-red-300 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3"
                role="alert" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
    </div>
</div>
