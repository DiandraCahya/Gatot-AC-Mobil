<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }

    /**
     * Check password strength
     */
    public function checkPasswordStrength(): string
    {
        if (strlen($this->password) < 8) return 'weak';
        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[\w@$!%*?&]{8,}$/', $this->password)) return 'strong';
        return 'medium';
    }
}; ?>

<section class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-lg p-6 mt-8">
    <header class="mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ __('Perbarui Kata Sandi') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="space-y-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" />
                <x-text-input 
                    wire:model="current_password" 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="mt-1 block w-full rounded-md shadow-sm" 
                    autocomplete="current-password" 
                />
                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" />
                <x-text-input 
                    wire:model="password" 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    class="mt-1 block w-full rounded-md shadow-sm" 
                    autocomplete="new-password" 
                />
                @if($this->password)
                    <div class="mt-2">
                        @php
                            $strength = $this->checkPasswordStrength();
                        @endphp
                        <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                            <div 
                                class="h-full {{ 
                                    $strength == 'weak' ? 'bg-red-500 w-1/3' : 
                                    ($strength == 'medium' ? 'bg-yellow-500 w-2/3' : 'bg-green-500 w-full')
                                }}"
                            ></div>
                        </div>
                        <p class="text-sm mt-1 
                            {{ 
                                $strength == 'weak' ? 'text-red-600' : 
                                ($strength == 'medium' ? 'text-yellow-600' : 'text-green-600')
                            }}"
                        >
                            {{ 
                                $strength == 'weak' ? __('Kata sandi lemah') : 
                                ($strength == 'medium' ? __('Kata sandi sedang') : __('Kata sandi kuat'))
                            }}
                        </p>
                    </div>
                @endif
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                <x-text-input 
                    wire:model="password_confirmation" 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="mt-1 block w-full rounded-md shadow-sm" 
                    autocomplete="new-password" 
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
            <x-primary-button class="w-full sm:w-auto">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

            <x-action-message 
                class="text-green-600 text-center w-full sm:w-auto" 
                on="password-updated"
            >
                {{ __('Kata sandi berhasil diperbarui.') }}
            </x-action-message>
        </div>
    </form>
</section>