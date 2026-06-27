<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';
    public bool $confirmingDeletion = false;

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }

    /**
     * Toggle deletion confirmation modal
     */
    public function toggleConfirmation(): void
    {
        $this->confirmingDeletion = !$this->confirmingDeletion;
        $this->reset('password');
    }
}; ?>

<section class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-lg p-6 mt-8">
    <header class="mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-red-600 dark:text-red-400">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Unduh terlebih dahulu data yang ingin Anda simpan.') }}
        </p>
    </header>

    <div class="space-y-6">
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 p-4 rounded-lg">
            <div class="flex items-start space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h3 class="text-red-800 dark:text-red-200 font-semibold">
                        {{ __('Peringatan Penghapusan Akun') }}
                    </h3>
                    <p class="text-sm text-red-700 dark:text-red-300">
                        {{ __('Tindakan ini tidak dapat dibatalkan. Seluruh data Anda akan dihapus secara permanen.') }}
                    </p>
                </div>
            </div>
        </div>

        <button wire:click="toggleConfirmation"
            class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition-colors duration-300 flex items-center justify-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <span>{{ __('Hapus Akun') }}</span>
        </button>

        @if ($confirmingDeletion)
            <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Konfirmasi Penghapusan Akun') }}
                        </h2>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            {{ __('Masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun secara permanen.') }}
                        </p>

                        <form wire:submit="deleteUser" class="space-y-4">
                            <div>
                                <x-input-label for="password" :value="__('Kata Sandi')" class="sr-only" />
                                <x-text-input wire:model="password" id="password" name="password" type="password"
                                    class="block w-full rounded-md shadow-sm" placeholder="{{ __('Kata Sandi') }}"
                                    required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="button" wire:click="toggleConfirmation"
                                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                    {{ __('Batal') }}
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    {{ __('Hapus Akun') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
