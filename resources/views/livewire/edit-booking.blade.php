<div>
    <!-- Modal Backdrop -->
    <div x-data x-show="$wire.showModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm overflow-y-auto h-full w-full z-50"
        x-on:keydown.escape.window="$wire.closeModal()" @click="$wire.closeModal()">

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div class="bg-gray-900 rounded-xl shadow-2xl w-full max-w-2xl border border-gray-700 mx-auto" @click.stop>
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-4 sm:px-6 py-3 sm:py-4 rounded-t-xl">
                    <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Edit Booking
                    </h2>
                </div>

                <!-- Form Content -->
                <form wire:submit.prevent="updateBooking" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                    <!-- Form fields with improved mobile spacing -->
                    <div class="space-y-4">
                        <!-- Jenis Layanan Field -->
                        <div class="space-y-1 sm:space-y-2">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Jenis Layanan
                            </label>
                            <input type="text" wire:model.live="jenis"
                                class="w-full px-3 sm:px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-white placeholder-gray-400 text-sm sm:text-base">
                            @error('jenis')
                                <span class="text-red-400 text-xs sm:text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tanggal Field -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Tanggal Service
                            </label>
                            <input type="date" wire:model.live="tanggal" min="{{ now()->format('Y-m-d') }}"
                                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-white placeholder-gray-400">
                            @error('tanggal')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Jam Field -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Jam Service
                            </label>
                            <input type="time" wire:model.live="jam"
                                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-white placeholder-gray-400">
                            @error('jam')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Mobil Field -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Model Mobil
                            </label>
                            <input type="text" wire:model.live="mobil"
                                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-white placeholder-gray-400">
                            @error('mobil')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Location Selection -->
                        <div class="space-y-1 sm:space-y-2">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                Lokasi Service
                            </label>
                            <div class="bg-gray-800 rounded-lg p-3 sm:p-4 border border-gray-700">
                                <div class="space-y-2 sm:space-y-3">
                                    <label
                                        class="flex items-center gap-2 sm:gap-3 cursor-pointer p-2 sm:p-3 rounded-lg hover:bg-gray-700 transition-colors">
                                        <input type="radio" wire:model.live="tempat" value="1"
                                            class="form-radio h-4 w-4 sm:h-5 sm:w-5 text-indigo-500 border-gray-600 focus:ring-indigo-500 bg-gray-700">
                                        <div>
                                            <span class="text-sm sm:text-base text-gray-200 font-medium">Servis di
                                                Bengkel Kami</span>
                                            <p class="text-xs sm:text-sm text-gray-400 mt-1">Kunjungi bengkel kami untuk
                                                pelayanan lengkap</p>
                                        </div>
                                    </label>
                                    <label
                                        class="flex items-center gap-2 sm:gap-3 cursor-pointer p-2 sm:p-3 rounded-lg hover:bg-gray-700 transition-colors">
                                        <input type="radio" wire:model.live="tempat" value="0"
                                            class="form-radio h-4 w-4 sm:h-5 sm:w-5 text-indigo-500 border-gray-600 focus:ring-indigo-500 bg-gray-700">
                                        <div>
                                            <span class="text-sm sm:text-base text-gray-200 font-medium">Servis di
                                                Lokasi Anda</span>
                                            <p class="text-xs sm:text-sm text-gray-400 mt-1">Tim kami akan datang ke
                                                lokasi Anda</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan with mobile-friendly textarea -->
                        <div class="space-y-1 sm:space-y-2">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Keterangan
                            </label>
                            <textarea wire:model.live="keterangan" rows="3" sm:rows="4"
                                class="w-full px-3 sm:px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-white placeholder-gray-400 text-sm sm:text-base"></textarea>
                        </div>
                    </div>

                    <!-- Buttons with mobile-friendly layout -->
                    <div class="pt-2 sm:pt-4 flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <button type="button" wire:click="closeModal"
                            class="w-full sm:flex-1 px-4 py-2.5 sm:py-3 bg-gray-700 hover:bg-gray-600 text-gray-200 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="w-full sm:flex-1 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-2.5 sm:py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-sm sm:text-base">
                            <svg wire:loading.remove class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <svg wire:loading wire:target="updateBooking"
                                class="animate-spin h-4 w-4 sm:h-5 sm:w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="updateBooking">Perbarui Booking</span>
                            <span wire:loading wire:target="updateBooking">Memperbarui...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Flash Messages with mobile responsive adjustments -->
    <div x-data="{ show: false, message: '', type: '' }"
        x-on:success.window="show = true; message = $event.detail.message; type = 'success'; setTimeout(() => show = false, 3000)"
        x-on:error.window="show = true; message = $event.detail.message; type = 'error'; setTimeout(() => show = false, 3000)"
        x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="fixed top-2 right-2 sm:top-4 sm:right-4 z-50 max-w-[calc(100%-1rem)] sm:max-w-md">
        <div x-bind:class="{
            'bg-green-900 border-green-600 text-green-200': type === 'success',
            'bg-red-900 border-red-600 text-red-200': type === 'error'
        }"
            class="rounded-lg border px-3 sm:px-4 py-2 sm:py-3 shadow-lg">
            <div class="flex items-center gap-2">
                <svg x-show="type === 'success'" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <svg x-show="type === 'error'" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="text-sm sm:text-base" x-text="message"></span>
            </div>
        </div>
    </div>
</div>
