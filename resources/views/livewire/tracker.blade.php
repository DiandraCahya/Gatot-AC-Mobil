<div>
    <div x-data x-show="$wire.showModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50"
        x-on:keydown.escape.window="$wire.closeModal()" @click="$wire.closeModal()">

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div @click.stop
                class="relative inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">

                <!-- Header Section -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white">Buat Booking Baru</h2>
                    <p class="mt-2 text-blue-100">Silakan isi form di bawah ini untuk membuat reservasi</p>
                </div>

                <form wire:submit="save" class="px-8 py-6 space-y-6 bg-gray-800">
                    @if (session()->has('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Nama -->
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-2" for="name">
                            Nama
                        </label>
                        <input wire:model.live="nama" type="text" id="nama" placeholder="Nama lengkap"
                            class="w-full px-4 py-3 rounded-lg border @error('name') border-red-500 @else border-gray-600 @enderror bg-gray-700 text-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                            required>
                        @error('nama')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Layanan -->
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-2" for="jenis">
                            Jenis Layanan
                        </label>
                        <div class="relative">
                            <select wire:model.live="jenis"
                                class="w-full px-4 py-3 rounded-lg border @error('jenis') border-red-500 @else border-gray-600 @enderror bg-gray-700 text-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                                id="jenis" required>
                                <option value="">Pilih Jenis Layanan</option>
                                @foreach ($jasa as $jasas)
                                    <option value="{{ $jasas->name }}">
                                        {{ $jasas->name }} ({{ $jasas->price }})
                                    </option>
                                @endforeach
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('jenis')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal, Jam, dan Jenis Mobil -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-gray-300 text-sm font-semibold mb-2" for="tanggal">
                                Tanggal Tracking
                            </label>
                            <div class="relative">
                                <input wire:model.live="tanggal" type="date" id="tanggal"
                                    min="{{ Carbon\Carbon::today()->format('Y-m-d') }}"
                                    class="w-full px-4 py-3 rounded-lg border @error('tanggal') border-red-500 @else border-gray-300 @enderror focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                                @error('tanggal')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('tanggal')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-semibold mb-2" for="jam">
                                Jam Tracking
                            </label>
                            <input wire:model.live="jam" type="time" id="jam"
                                class="w-full px-4 py-3 rounded-lg border @error('jam') border-red-500 @else border-gray-300 @enderror focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            @error('jam')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-semibold mb-2" for="mobil">
                                Jenis Mobil
                            </label>
                            <input wire:model.live="mobil" type="text" id="mobil"
                                placeholder="Toyota Avanza 2020"
                                class="w-full px-4 py-3 rounded-lg border @error('mobil') border-red-500 @else border-gray-300 @enderror focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            @error('mobil')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-2" for="keterangan">
                            Keterangan Detail
                        </label>
                        <textarea wire:model.live="keterangan"
                            class="w-full px-4 py-3 rounded-lg border @error('keterangan') border-red-500 @else border-gray-600 @enderror bg-gray-700 text-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200 min-h-[120px]"
                            id="keterangan" rows="4" placeholder="Jelaskan detail permasalahan atau layanan yang Anda butuhkan..."></textarea>
                        @error('keterangan')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Lokasi Servis -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Lokasi Service
                        </label>
                        <div class="bg-gray-700 rounded-lg p-4 border border-gray-600">
                            <p class="mb-4 text-sm text-gray-400">Pilih lokasi servis yang Anda inginkan</p>
                            <div class="space-y-3">
                                <label
                                    class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-gray-600 transition-colors">
                                    <input type="radio" wire:model.live="tempat" value="1"
                                        class="form-radio h-5 w-5 text-green-500 border-gray-500 focus:ring-green-500">
                                    <div>
                                        <span class="text-gray-300 font-medium">Servis di Bengkel Kami</span>
                                        <p class="text-sm text-gray-400 mt-1">Kunjungi bengkel kami untuk pelayanan
                                            lengkap</p>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-gray-600 transition-colors">
                                    <input type="radio" wire:model.live="tempat" value="0"
                                        class="form-radio h-5 w-5 text-green-500 border-gray-500 focus:ring-green-500">
                                    <div>
                                        <span class="text-gray-300 font-medium">Servis di Lokasi Anda</span>
                                        <p class="text-sm text-gray-400 mt-1">Tim kami akan datang ke lokasi Anda</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="$wire.closeModal()"
                            class="px-4 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading.flex wire:target="save" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
