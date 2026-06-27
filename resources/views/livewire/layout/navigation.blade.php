<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class=" text-white relative z-30 shadow-lg"
    style="background: linear-gradient(to left, black, #2A3C4D 50%, black),
linear-gradient(to right, black, black 50%, black);
background-blend-mode: screen;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-3 group">
                        <img src="{{ asset('img/Logo6.png') }}" alt="Logo"
                            class="h-10 w-auto group-hover:scale-110 transition-transform" />
                        <span
                            class="text-2xl font-bold text-white tracking-tight group-hover:text-gray-300 transition-colors">Gatot
                            AC Mobil</span>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden space-x-6 sm:ms-10 sm:flex sm:items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="text-gray-300 hover:text-white hover:scale-105 transition-all duration-300 px-3 py-2 rounded-md font-medium 
                        {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : '' }}">
                        {{ __('Beranda') }}
                    </a>

                    <a href="{{ route('bookings.user') }}" wire:navigate
                        class="text-gray-300 hover:text-white hover:scale-105 transition-all duration-300 px-3 py-2 rounded-md font-medium 
                        {{ request()->routeIs('bookings.user') ? 'bg-gray-800 text-white' : '' }}">
                        {{ __('Layanan') }}
                    </a>

                    <a href="{{ route('Chat') }}" wire:navigate
                        class="text-gray-300 hover:text-white hover:scale-105 transition-all duration-300 px-3 py-2 rounded-md font-medium 
                        {{ request()->routeIs('Chat') ? 'bg-gray-800 text-white' : '' }}">
                        {{ __('Chat') }}
                    </a>

                    @if (auth()->check() && auth()->user()->is_admin)
                        <a href="{{ route('bookings.admin') }}" wire:navigate
                            class="text-gray-300 hover:text-white hover:scale-105 transition-all duration-300 px-3 py-2 rounded-md font-medium 
                            {{ request()->routeIs('bookings.admin') ? 'bg-gray-800 text-white' : '' }}">
                            {{ __('Admin Panel') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Desktop Right Side Menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4 ">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 
                            hover:text-white hover:bg-gray-800 transition-all duration-300 rounded-full 
                            focus:outline-none focus:ring-2 focus:ring-gray-600">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name"></div>
                            <svg class="ms-2 h-4 w-4 transition-transform duration-300" :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition
                            class="absolute right-0 mt-2 w-64 bg-white text-gray-800 rounded-lg shadow-2xl border border-gray-200 overflow-hidden">
                            <!-- User Info -->
                            <div class="px-4 py-3 bg-gray-100 border-b">
                                <p class="text-xs text-gray-500">Signed in as</p>
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <!-- Profile Link -->
                            <a href="{{ route('profile') }}" wire:navigate
                                class="block px-4 py-3 hover:bg-gray-100 transition-colors 
                                flex items-center text-gray-800 hover:text-black">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profil Saya') }}
                            </a>

                            <!-- Logout Button -->
                            <button wire:click="logout"
                                class="w-full text-left px-4 py-3 hover:bg-gray-100 transition-colors 
                                flex items-center text-gray-800 hover:text-red-600">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Keluar') }}
                            </button>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-gray-300 hover:text-white hover:bg-gray-800 transition-all duration-300 
                        px-4 py-2 rounded-full border border-gray-700 hover:border-white">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-gray-700 text-white px-6 py-2 rounded-full 
                        hover:bg-gray-600 transition-all duration-300 
                        hover:scale-105 shadow-md hover:shadow-lg">
                        Daftar
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 
                    hover:text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-900">
            <a href="{{ route('dashboard') }}" wire:navigate
                class="text-gray-300 hover:bg-gray-800 hover:text-white block px-3 py-2 rounded-md text-base font-medium 
                {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : '' }}">
                {{ __('Beranda') }}
            </a>

            <a href="{{ route('bookings.user') }}" wire:navigate
                class="text-gray-300 hover:bg-gray-800 hover:text-white block px-3 py-2 rounded-md text-base font-medium 
                {{ request()->routeIs('bookings.user') ? 'bg-gray-800 text-white' : '' }}">
                {{ __('Layanan') }}
            </a>

            <a href="{{ route('Chat') }}" wire:navigate
                class="text-gray-300 hover:bg-gray-800 hover:text-white block px-3 py-2 rounded-md text-base font-medium 
                {{ request()->routeIs('Chat') ? 'bg-gray-800 text-white' : '' }}">
                {{ __('Chat') }}
            </a>

            @if (auth()->check() && auth()->user()->is_admin)
                <a href="{{ route('bookings.admin') }}" wire:navigate
                    class="text-gray-300 hover:bg-gray-800 hover:text-white block px-3 py-2 rounded-md text-base font-medium 
                    {{ request()->routeIs('bookings.admin') ? 'bg-gray-800 text-white' : '' }}">
                    {{ __('Admin Panel') }}
                </a>
            @endif
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-gray-700">
                <div class="px-4 flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 rounded-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                            x-on:profile-updated.window="name = $event.detail.name">
                        </div>
                        <div class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 
                        hover:bg-gray-800 hover:text-white">
                        {{ __('Profil Saya') }}
                    </a>
                    <button wire:click="logout" class="w-full text-left">
                        <span
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 
                        hover:bg-gray-800 hover:text-white">
                            {{ __('Keluar') }}
                        </span>
                    </button>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-gray-700">
                <div class="px-4 space-y-1">
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 
                        hover:bg-gray-800 hover:text-white">
                        {{ __('Masuk') }}
                    </a>
                    <a href="{{ route('register') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 
                        hover:bg-gray-800 hover:text-white">
                        {{ __('Daftar') }}
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>
