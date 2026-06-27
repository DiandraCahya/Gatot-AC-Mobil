<div class="min-h-screen bg-gray-100 rounded-lg py-12 px-4 sm:px-6 lg:px-8 ">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg px-8 py-6">
        <h2 class="text-2xl font-bold text-white">Tracking</h2>
        <p class="mt-2 text-blue-100">Silakan isi form di bawah ini untuk membuat reservasi</p>
    </div>

    <form action="{{ route('tracking.store') }}" method="POST" class="px-8 py-6 space-y-6">
        @csrf

        <!-- Nama Field -->
        <div>
            <label class="block text-gray-700 text-sm font-semibold mb-2" for="nama">
                Nama
            </label>
            <input type="text" name="nama" id="nama"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 ease-in-out bg-white"
                placeholder="Nama orang yang melakukan booking" required>
        </div>

        <!-- Jenis Layanan -->
        <div>
            <label class="block text-gray-700 text-sm font-semibold mb-2" for="jenis">
                Jenis Layanan
            </label>
            <div class="relative">
                <select
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 ease-in-out bg-white"
                    id="jenis" name="jenis" required>
                    <option value="">Pilih Jenis Layanan</option>
                    <option value="Tambah / Isi Freon">Tambah / Isi Freon (200k - 300k)</option>
                    <option value="Pasang AC Baru">Pasang AC Baru (6jt - 7,5jt)</option>
                    <option value="Service AC">Service AC (350k - 700k)</option>
                    <option value="Cek">Cek (Gratis)</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tanggal, Jam, dan Jenis Mobil dalam satu baris -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="tanggal">
                    Tanggal Booking
                </label>
                <input
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                    id="tanggal" name="tanggal" type="date" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="jam">
                    Jam Booking
                </label>
                <input
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                    id="jam" name="jam" type="time" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="mobil">
                    Jenis Mobil
                </label>
                <input
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                    id="mobil" name="mobil" type="text" placeholder="Toyota Avanza 2020" required>
            </div>
        </div>

        <!-- Keterangan -->
        <div>
            <label class="block text-gray-700 text-sm font-semibold mb-2" for="keterangan">
                Keterangan Detail
            </label>
            <textarea
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 min-h-[120px]"
                id="keterangan" name="keterangan" rows="4"
                placeholder="Jelaskan detail permasalahan atau layanan yang Anda butuhkan..."></textarea>
        </div>

        <!-- Lokasi Servis -->
        <div class="space-y-2">
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Lokasi Service
            </label>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="mb-4 text-sm text-gray-500">Pilih lokasi servis yang Anda inginkan</p>
                <div class="space-y-3">
                    <label
                        class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-gray-100 transition-colors">
                        <input type="radio" name="tempat" value="1"
                            class="form-radio h-5 w-5 text-blue-500 border-gray-300 focus:ring-blue-500">
                        <div>
                            <span class="text-gray-700 font-medium">Servis di Bengkel Kami</span>
                            <p class="text-sm text-gray-500 mt-1">Kunjungi bengkel kami untuk pelayanan lengkap
                            </p>
                        </div>
                    </label>
                    <label
                        class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-gray-100 transition-colors">
                        <input type="radio" name="tempat" value="0"
                            class="form-radio h-5 w-5 text-blue-500 border-gray-300 focus:ring-blue-500">
                        <div>
                            <span class="text-gray-700 font-medium">Servis di Lokasi Anda</span>
                            <p class="text-sm text-gray-500 mt-1">Tim kami akan datang ke lokasi Anda</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Button Section -->
        <div class="pt-4">
            <button
                class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 ease-in-out transform hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                type="submit">
                Submit
            </button>
        </div>
    </form>
</div>
