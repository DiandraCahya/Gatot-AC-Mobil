<div class="p-6 max-w-lg mx-auto bg-white rounded-lg shadow-md md:p-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Alasan Penolakan Booking</h3>
    
    <form id="rejectForm" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="pesan" class="block text-sm font-medium text-gray-700 mb-2">
                Pesan Penolakan
            </label>
            <textarea 
                id="pesan"
                name="pesan"
                rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
                placeholder="Masukkan alasan penolakan booking"
                required
            ></textarea>
        </div>

        <div class="mt-6 flex flex-col md:flex-row justify-end md:space-x-3 space-y-2 md:space-y-0">
            <button 
                type="button"
                onclick="document.getElementById('bookingModal').classList.add('hidden')"
                class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Batal
            </button>
            <button 
                type="submit"
                class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            >
                Tolak Booking
            </button>
        </div>
    </form>
</div>
