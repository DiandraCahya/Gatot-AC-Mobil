<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;
    public bool $showPassword = false;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class=" flex items-center justify-center bg-gradient-to-r ">
    <div class="max-w-md w-full bg-gray-900 rounded-lg p-8 space-y-6">
        <!-- Logo or Brand -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang</h2>
            <p class="text-gray-600">Silahkan login untuk melanjutkan</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login" class="space-y-6">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
                <div class="mt-2">
                    <x-text-input 
                        wire:model="form.email" 
                        id="email" 
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                        type="email" 
                        name="email"
                        placeholder="Enter your email"
                        required 
                        autofocus 
                        autocomplete="username" 
                    />
                </div>
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                <div class="mt-2 relative">
                    <x-text-input 
                        wire:model="form.password" 
                        id="password" 
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                        :type="$showPassword ? 'text' : 'password'"
                        name="password" 
                        placeholder="Enter your password"
                        required 
                        autocomplete="current-password" 
                    />
                    <button 
                        type="button" 
                        wire:click="$toggle('showPassword')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-900 transition duration-150"
                    >
                        @if ($showPassword)
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        @endif
                    </button>
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <!-- Remember Me -->
                <label for="remember" class="flex items-center">
                    <input 
                        wire:model="form.remember" 
                        id="remember" 
                        type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember"
                    >
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a 
                        class="text-sm text-indigo-600 hover:text-indigo-500 transition duration-150"
                        href="{{ route('password.request') }}" 
                        wire:navigate
                    >
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="space-y-4">
                <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                    {{ __('Sign in') }}
                </x-primary-button>

                <p class="text-center text-sm text-gray-600">
                    {{ __("Belum memiliki akun?") }}
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150">
                        {{ __('Sign up') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>