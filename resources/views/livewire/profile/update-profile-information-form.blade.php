<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $nomor = '';
    public string $alamat = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nomor = $user->nomor ?? '';
        $this->alamat = $user->alamat ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'nomor' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-lg p-6 mt-8">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 border-b pb-3">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi akun Anda.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Nama')" />
                <x-text-input 
                    wire:model="name" 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    required 
                    autofocus 
                    autocomplete="name" 
                />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input 
                    wire:model="email" 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="mt-1 block w-full" 
                    required 
                    autocomplete="username" 
                />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Alamat email Anda belum diverifikasi.') }}
                        <button 
                            wire:click.prevent="sendVerification" 
                            class="underline text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800"
                        >
                            {{ __('Kirim ulang email verifikasi') }}
                        </button>
                    </p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="nomor" :value="__('Nomor Telepon')" />
                <x-text-input 
                    wire:model="nomor" 
                    id="nomor" 
                    name="nomor" 
                    type="tel" 
                    class="mt-1 block w-full" 
                    autocomplete="tel" 
                />
                <x-input-error class="mt-2" :messages="$errors->get('nomor')" />
            </div>

            <div>
                <x-input-label for="alamat" :value="__('Alamat')" />
                <x-text-input 
                    wire:model="alamat" 
                    id="alamat" 
                    name="alamat" 
                    type="text" 
                    class="mt-1 block w-full" 
                    autocomplete="street-address" 
                />
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <x-primary-button>
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

            <x-action-message class="text-green-600" on="profile-updated">
                {{ __('Profil berhasil diperbarui.') }}
            </x-action-message>
        </div>
    </form>
</section>