<x-app-layout>
    @section('title', 'Admin Control')
    <div class="min-h-screen py-4 sm:py-8 rounded-lg">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <x-slot name="header">
                <div class="justify-between items-center inline">
                    <h2 class="font-bold text-xl sm:text-2xl leading-tight">
                        {{ __('Admin Control') }}
                    </h2>
                </div>
            </x-slot>

            <!-- Profit Cards - Made responsive -->
            <div class="mb-6 sm:mb-8 bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-200">Profit Overview</h2>
                    <span class="text-xs sm:text-sm text-gray-400">{{ now()->format('F Y') }}</span>
                </div>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="bg-green-500/10 rounded-lg p-3 sm:p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-medium text-green-400">Total Profit (Paid
                                Orders)</span>
                            <svg class="h-6 w-6 sm:h-8 sm:w-8 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="mt-2 text-2xl sm:text-3xl font-bold text-green-400">
                            Rp {{ number_format($totalProfit, 0, ',', '.') }}
                        </p>
                        <p class="mt-1 text-xs sm:text-sm text-gray-400">From {{ $paidOrdersCount }} paid orders</p>
                    </div>
                    <div class="bg-blue-500/10 rounded-lg p-3 sm:p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-medium text-blue-400">Pending Payments</span>
                            <svg class="h-6 w-6 sm:h-8 sm:w-8 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="mt-2 text-2xl sm:text-3xl font-bold text-blue-400">
                            Rp {{ number_format($pendingPayments, 0, ',', '.') }}
                        </p>
                        <p class="mt-1 text-xs sm:text-sm text-gray-400">From {{ $pendingOrdersCount }} pending orders
                        </p>
                    </div>
                </div>
            </div>

            <livewire:backup-booking />

            <!-- Messages Section - Made responsive -->
            <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden p-3 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-200 mb-4">Pesan Masuk</h2>
                @if ($messages->isEmpty())
                    <p class="text-sm sm:text-base text-gray-300">Belum ada pesan masuk.</p>
                @else
                    <ul class="space-y-3 sm:space-y-4">
                        @foreach ($messages as $message)
                            <li class="bg-white/5 rounded-lg p-2 sm:p-4">
                                <div class="text-xs sm:text-base text-gray-200"><strong>Dari:</strong>
                                    {{ $message->sender->name }}</div>
                                <div class="text-xs sm:text-base text-gray-200"><strong>Pesan:</strong>
                                    {{ $message->message }}</div>
                                <span
                                    class="text-xs sm:text-sm text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <a href="{{ route('Chat') }}">
                    <button
                        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-base rounded-md transition-colors duration-200">
                        Lihat Semua Pesan
                    </button>
                </a>
            </div>

            <!-- Services Header - Made responsive -->
            <div class="flex justify-between items-center my-4 sm:my-6">
                <h2 class="text-xl sm:text-2xl font-bold text-white">Daftar Jasa</h2>
                <button onclick="openCreateJasaModal()"
                    class="group relative inline-flex items-center overflow-hidden rounded-lg bg-green-600 px-4 sm:px-8 py-2 sm:py-3 hover:bg-green-700">
                    <span class="text-white text-sm sm:text-base font-bold">
                        Tambah Jasa
                    </span>
                </button>
            </div>

            <!-- Services Table - Made responsive with horizontal scroll -->
            <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr class="bg-gray-800/50">
                                <th
                                    class="py-3 sm:py-4 px-4 sm:px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                                    Nama Jasa
                                </th>
                                <th
                                    class="py-3 sm:py-4 px-4 sm:px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                                    Harga
                                </th>
                                <th
                                    class="py-3 sm:py-4 px-4 sm:px-6 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($jasas as $jasa)
                                <tr class="hover:bg-white/5 transition-colors duration-200">
                                    <td class="py-2 sm:py-4 px-4 sm:px-6 text-xs sm:text-sm text-gray-200 text-center">
                                        {{ $jasa->name }}</td>
                                    <td class="py-2 sm:py-4 px-4 sm:px-6 text-xs sm:text-sm text-gray-200 text-center">
                                        Rp {{ $jasa->price }}
                                    </td>
                                    <td class="py-2 sm:py-4 px-4 sm:px-6 text-center">
                                        <div class="flex justify-center gap-1 sm:gap-2">
                                            <button onclick="openEditJasaModal({{ $jasa->id }})"
                                                class="inline-flex items-center px-2 sm:px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </button>
                                            <button onclick="confirmDeleteJasa({{ $jasa->id }})"
                                                class="inline-flex items-center px-2 sm:px-3 py-1 rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition-colors duration-200">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span class="hidden sm:inline">Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Booking Header - Made responsive -->
            <div class="flex justify-between items-center my-4 sm:my-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-200">Daftar Booking</h2>
                <button onclick="Livewire.dispatch('CreateTracking')"
                    class="group relative inline-flex items-center overflow-hidden rounded-lg px-4 sm:px-8 py-2 sm:py-3 bg-green-600 hover:bg-green-700">
                    <span class="text-white text-sm sm:text-base font-bold">
                        Tambah Tracking
                    </span>
                </button>
            </div>

            <!-- Keep the Livewire components as is -->
            <livewire:tracker />
            <livewire:create-struk />
            <livewire:edit-struk />

            <!-- Success Message - Made responsive -->
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

            <livewire:booking-table />
        </div>
    </div>

    <!-- Enhanced Modal -->
    <div id="bookingModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden flex justify-center z-40 p-4 overflow-y-auto">
        <div id="modalWrapper" class="flex flex-col items-center min-h-screen w-full">
            <div id="modalContent" class="p-6 w-full max-w-3xl text-black rounded-lg shadow-lg">

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function openBookingModal(bookingId) {
                fetch(`/bookings/${bookingId}/detail`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('bookingModal').classList.remove('hidden');
                    });
            }

            function openStrukModal(bookingId) {
                fetch(`/bookings/${bookingId}/struk/create`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('bookingModal').classList.remove('hidden');
                    });
            }

            function openStrukDetail(bookingId) {
                fetch(`/bookings/${bookingId}/struk`)
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

            function confirmApproval() {
                Swal.fire({
                    title: 'Konfirmasi Persetujuan',
                    text: "Apakah Anda yakin ingin menyetujui booking ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#dc2626',
                    confirmButtonText: 'Ya, Setuju!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('approvalForm').submit();
                        Swal.fire({
                            title: 'Disetujui!',
                            text: 'Booking telah berhasil disetujui.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            }
        </script>

        {{-- Jasa Script --}}
        <script>
            function openCreateJasaModal() {
                fetch('/jasa/create')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('bookingModal').classList.remove('hidden');
                    });
            }

            function openEditJasaModal(jasaId) {
                fetch(`/jasa/${jasaId}/edit`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('bookingModal').classList.remove('hidden');
                    });
            }

            function confirmDeleteJasa(jasaId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data jasa yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/jasa/${jasaId}`;

                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        form.appendChild(csrfInput);
                        form.appendChild(methodInput);
                        document.body.appendChild(form);

                        form.submit();
                    }
                });
            }

            // Add form submission handler
            document.addEventListener('submit', function(e) {
                if (e.target && e.target.id === 'jasaForm') {
                    e.preventDefault();

                    const formData = new FormData(e.target);
                    fetch(e.target.action, {
                            method: e.target.method,
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('bookingModal').classList.add('hidden');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.message || 'Terjadi kesalahan!'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan!'
                            });
                        });
                }
            });
        </script>

        {{-- Struk Modal --}}
        <script>
            let itemCount = 1;

            function addItem() {
                const container = document.getElementById('itemContainer');
                const itemDiv = document.createElement('div');
                itemDiv.className = 'bg-gray-50 p-4 rounded-lg';
                itemDiv.innerHTML = `
        <!-- Row 1: Nama dan Jumlah -->
        <div class="grid grid-cols-12 gap-4 mb-3">
            <div class="col-span-8">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item</label>
                <input type="text" name="items[${itemCount}][name]" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>
            
            <div class="col-span-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="items[${itemCount}][quantity]" min="1" value="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                    onchange="calculateItemTotal(this.closest('.bg-gray-50'))">
            </div>
        </div>

        <!-- Row 2: Harga Satuan, Total, dan Delete -->
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                    <input type="number" name="items[${itemCount}][unit_price]" 
                        class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                        onchange="calculateItemTotal(this.closest('.bg-gray-50'))">
                </div>
            </div>
            
            <div class="col-span-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                    <input type="number" name="items[${itemCount}][price]" readonly
                        class="w-full pl-9 pr-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div class="col-span-2 flex items-end justify-center">
                <button type="button" onclick="removeItem(this)"
                    class="p-2 hover:bg-red-100 rounded-lg text-red-600 transition duration-150 ease-in-out">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </div>
    `;
                container.appendChild(itemDiv);
                itemCount++;
            }

            function calculateItemTotal(itemDiv) {
                const quantity = parseInt(itemDiv.querySelector('input[name$="[quantity]"]').value) || 0;
                const unitPrice = parseInt(itemDiv.querySelector('input[name$="[unit_price]"]').value) || 0;
                const totalPrice = quantity * unitPrice;
                itemDiv.querySelector('input[name$="[price]"]').value = totalPrice;
                calculateTotal();
            }

            function removeItem(button) {
                const itemContainer = document.getElementById('itemContainer');
                if (itemContainer.children.length > 1) {
                    button.closest('.bg-gray-50').remove();
                    calculateTotal();
                } else {
                    alert('Minimal harus ada satu item');
                }
            }

            function calculateTotal() {
                let total = 0;
                const priceInputs = document.querySelectorAll('input[name$="[price]"]');
                priceInputs.forEach(input => {
                    total += parseInt(input.value) || 0;
                });
                document.getElementById('totalAmount').textContent = total.toLocaleString('id-ID');
            }

            function toggleGaransiFields() {
                const isGaransi = document.getElementById('is_garansi').checked;
                const garansiFields = document.getElementById('garansiFields');
                const garansiInputs = garansiFields.querySelectorAll('input, textarea');

                if (isGaransi) {
                    garansiFields.classList.remove('hidden');
                    garansiInputs.forEach(input => {
                        input.required = true;
                    });
                } else {
                    garansiFields.classList.add('hidden');
                    garansiInputs.forEach(input => {
                        input.required = false;
                        input.value = '';
                    });
                }
            }
        </script>

        {{-- Reject Modal --}}
        <script>
            function openRejectModal(bookingId) {
                fetch(`/bookings/${bookingId}/reject-modal`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('bookingModal').classList.remove('hidden');

                        // Setup form submission
                        const form = document.getElementById('rejectForm');
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();

                            const formData = new FormData(form);

                            fetch(`/bookings/${bookingId}/reject`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .content,
                                    },
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.reload();
                                    } else {
                                        alert(data.error || 'Terjadi kesalahan saat menolak booking');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Terjadi kesalahan saat menolak booking');
                                });
                        });
                    });
            }
        </script>
    @endpush
</x-app-layout>
