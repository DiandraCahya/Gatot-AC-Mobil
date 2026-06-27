<div class="p-6 bg-white shadow-lg rounded-xl max-w-lg mx-auto">
    <h3 class="text-xl font-semibold text-gray-900 mb-5 text-center">
        {{ isset($jasa) ? 'Edit Jasa' : 'Tambah Jasa Baru' }}
    </h3>
    <form id="jasaForm" action="{{ isset($jasa) ? route('jasa.update', $jasa->id) : route('jasa.store') }}"
        method="POST">
        @csrf
        @if (isset($jasa))
            @method('PUT')
        @endif

        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Jasa</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 bg-gray-50"
                    value="{{ $jasa->name ?? old('name') }}">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="3" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 bg-gray-50">{{ $jasa->description ?? old('description') }}</textarea>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <div class="relative mt-1">
                    <input type="text" name="price" id="price" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 bg-gray-50"
                        value="{{ $jasa->price ?? old('price') }}">
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="document.getElementById('bookingModal').classList.add('hidden')"
                class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                Batal
            </button>
            <button type="submit"
                class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                {{ isset($jasa) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
