<?php
// PHP code tetap sama seperti sebelumnya, tidak ada perubahan pada logic
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $nomor = '';
    public string $alamat = '';
    public bool $showPassword = false;
    public bool $showPasswordConfirmation = false;

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'nomor' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(
            new Registered(
                ($user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'nomor' => $validated['nomor'],
                    'alamat' => $validated['alamat'],
                ])),
            ),
        );

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

@section('title')
    {{ __('Register') }}
@endsection

<div class=" flex flex-col items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 pb-10">
    <div class="w-full sm:max-w-4xl mt-6 px-6 py-4 overflow-hidden rounded-lg">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Buat akunmu') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Buat akun dan mulai menggunakan layanan kami') }}
            </p>
        </div>

        <form wire:submit="register">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div class="border-b dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Informasi Personal') }}
                        </h3>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text"
                                name="name" required autofocus autocomplete="name" placeholder="Nama" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email"
                                name="email" required autocomplete="username" placeholder="sutrisno@example.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="mt-4">
                            <x-input-label for="nomor" :value="__('Nomor Telepon')" />
                            <x-text-input wire:model="nomor" id="nomor" class="block mt-1 w-full" type="text"
                                name="nomor" required placeholder="+62 xxx-xxxx-xxxx" />
                            <x-input-error :messages="$errors->get('nomor')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div class="border-b dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Keamanan Akun') }}
                        </h3>

                        <!-- Alamat -->
                        <div>
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea wire:model="alamat" id="alamat" name="alamat" rows="3"
                                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                required placeholder="Enter your address"></textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <div class="relative">
                                <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                                    :type="$showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password"
                                    placeholder="••••••••" />
                                <button type="button" wire:click="$toggle('showPassword')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-900">
                                    @if ($showPassword)
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    @endif
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <div class="relative">
                                <x-text-input wire:model="password_confirmation" id="password_confirmation"
                                    class="block mt-1 w-full" :type="$showPasswordConfirmation ? 'text' : 'password'" name="password_confirmation" required
                                    autocomplete="new-password" placeholder="••••••••" />
                                <button type="button" wire:click="$toggle('showPasswordConfirmation')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-900">
                                    @if ($showPasswordConfirmation)
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    @endif
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between mt-8">
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                    href="{{ route('login') }}" wire:navigate>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Sudah memiliki akun?') }}
                    </span>
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Buat Akun') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
