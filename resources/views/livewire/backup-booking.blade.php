<div class="mb-8">
    {{-- Page Title --}}
    {{-- Backup Form Section --}}
    <div class="bg-white/5 backdrop-blur-lg rounded-xl p-4 md:p-6 shadow-lg">
        <div class="mb-4">
            <h2 class="text-lg md:text-xl font-semibold text-white mb-2">Backup Data Booking</h2>
            <p class="text-gray-400 text-sm">Backup dan hapus data booking untuk periode tertentu</p>
        </div>

        <form wire:submit.prevent="backup">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-6 mb-4">
                {{-- Month Selection with icon --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <select wire:model="selectedMonth" id="selectedMonth"
                        class="bg-white/10 border-0 text-white w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white/20 transition-all duration-200 appearance-none">
                        @foreach ($months as $key => $month)
                            <option value="{{ $key }}" class="bg-gray-800">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Year Selection with icon --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <select wire:model="selectedYear" id="selectedYear"
                        class="bg-white/10 border-0 text-white w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white/20 transition-all duration-200 appearance-none">
                        @foreach ($years as $key => $year)
                            <option value="{{ $key }}" class="bg-gray-800">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Warning Alert --}}
            <div class="bg-yellow-400/10 border border-yellow-400/20 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-400">Perhatian!</h3>
                        <div class="mt-2 text-sm text-gray-300">
                            Proses ini akan membuat backup dalam format Excel dan menghapus data booking dan struk untuk
                            periode yang dipilih.
                            Data rating yang terkait dengan booking akan dipertahankan dengan booking_id disetel ke
                            NULL.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors duration-200">
                    <span wire:loading wire:target="backup">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Memproses...
                    </span>
                    <span wire:loading.remove wire:target="backup">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Backup & Hapus Data
                    </span>
                </button>
            </div>
        </form>

        <!-- Result Messages without download button -->
        @if ($result)
            <div class="mt-4 bg-green-400/10 border border-green-400/20 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-400">{{ $result }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errorMessage)
            <div class="mt-4 bg-red-400/10 border border-red-400/20 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-400">{{ $errorMessage }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:initialized', function () {
        Livewire.on('showDownloadConfirmation', function (params) {
            const filename = params.filename || '';
            
            Swal.fire({
                title: 'Download Excel Backup?',
                text: "Apakah Anda ingin mendownload file Excel backup?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Use the route for download
                    window.location.href = `/download-backup/${filename}`;
                }
            });
        });
    });
</script>
@endpush