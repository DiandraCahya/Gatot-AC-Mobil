<div class="p-6 bg-[#1a1f2e] text-gray-100 rounded-2xl">
    <h3 class="text-2xl font-semibold mb-6 text-white">Berikan Rating</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Informasi Pemohon Card -->
        <div class="bg-[#1e2433] p-6 rounded-2xl">
            <div class="flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <h3 class="font-medium text-lg text-white">Informasi Pemohon</h3>
            </div>
            <div class="space-y-3">
                <p class="flex justify-between text-sm">
                    <span class="text-gray-400">Nama</span>
                    <span class="text-white">{{ $booking->user->name }}</span>
                </p>
                <p class="flex justify-between text-sm">
                    <span class="text-gray-400">Email</span>
                    <span class="text-white">{{ $booking->user->email }}</span>
                </p>
                <p class="flex justify-between text-sm">
                    <span class="text-gray-400">Telepon</span>
                    <span class="text-white">{{ $booking->user->nomor }}</span>
                </p>
                <p class="flex justify-between text-sm">
                    <span class="text-gray-400">Alamat</span>
                    <span class="text-white">{{ $booking->user->alamat }}</span>
                </p>
            </div>
        </div>

        <!-- Informasi Pesanan Card -->
        <div class="bg-[#1e2433] p-6 rounded-2xl">
            <div class="flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" clip-rule="evenodd" />
                </svg>
                <h3 class="font-medium text-lg text-white">Informasi Pesanan</h3>
            </div>
            <div class="space-y-3">
                <p class="flex justify-between text-sm">
                    <span class="text-gray-400">Jenis Layanan</span>
                    <span class="text-white">{{ $booking->jenis }}</span>
                </p>
                <p class="flex justify-between text-sm">
                    <span class="text-gray-400">Tanggal</span>
                    <span class="text-white">{{ $booking->tanggal }}</span>
                </p>
                <p class="flex justify-between text-sm">
                    <span class="text-gray-400">Mobil</span>
                    <span class="text-white">{{ $booking->mobil }}</span>
                </p>
                <p class="flex justify-between text-sm">
                    <span class="text-gray-400">Lokasi</span>
                    <span class="text-white">{{ $booking->tempat ? 'Di Bengkel' : $booking->user->alamat }}</span>
                </p>
            </div>
        </div>
    </div>

    <form id="ratingForm" action="{{ route('ratings.store') }}" method="POST" class="bg-[#1e2433] p-6 rounded-2xl">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

        <div class="mb-6">
            <label class="block text-white text-sm font-medium mb-2">Rating</label>
            <div class="flex justify-center">
                <div class="rating">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label title="Excellent!" for="star5">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                    </label>
                    <input value="4" name="rating" id="star4" type="radio" />
                    <label title="Great!" for="star4">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                    </label>
                    <input value="3" name="rating" id="star3" type="radio" />
                    <label title="Good" for="star3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                    </label>
                    <input value="2" name="rating" id="star2" type="radio" />
                    <label title="Okay" for="star2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                    </label>
                    <input value="1" name="rating" id="star1" type="radio" />
                    <label title="Bad" for="star1">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-white text-sm font-medium mb-2" for="review">
                Review (Opsional)
            </label>
            <textarea name="review" id="review" rows="3"
                class="w-full bg-[#1a1f2e] text-white rounded-xl p-3 border border-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors">
                Kirim Rating
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <button onclick="document.getElementById('bookingModal').classList.add('hidden')" 
            class="w-full md:w-auto px-6 py-2 text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors">
            Tutup
        </button>
    </div>

    <style>
        .rating>label {
            margin-right: 4px;
        }

        .rating:not(:checked)>input {
            display: none;
        }

        .rating:not(:checked)>label {
            float: right;
            cursor: pointer;
            font-size: 30px;
        }

        .rating:not(:checked)>label>svg {
            fill: #4b5563;
            transition: all 0.2s ease;
        }

        .rating>input:checked~label>svg {
            fill: #3b82f6;
        }

        .rating:not(:checked)>label:hover~label>svg,
        .rating:not(:checked)>label:hover>svg {
            fill: #60a5fa;
        }

        /* Checked states */
        #star1:checked~label>svg {
            fill: #ef4444 !important;
        }

        #star2:checked~label>svg {
            fill: #f97316 !important;
        }

        #star3:checked~label>svg {
            fill: #eab308 !important;
        }

        #star4:checked~label>svg {
            fill: #22c55e !important;
        }

        #star5:checked~label>svg {
            fill: #8b5cf6 !important;
        }

        /* Hover states */
        #star1:hover~label>svg,
        #star1:hover>svg {
            fill: #dc2626;
        }

        #star2:hover~label>svg,
        #star2:hover>svg {
            fill: #ea580c;
        }

        #star3:hover~label>svg,
        #star3:hover>svg {
            fill: #ca8a04;
        }

        #star4:hover~label>svg,
        #star4:hover>svg {
            fill: #16a34a;
        }

        #star5:hover~label>svg,
        #star5:hover>svg {
            fill: #7c3aed;
        }
    </style>
</div>