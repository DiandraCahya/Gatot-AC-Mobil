<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatot AC Mobil - Premium Car AC Service</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .glass-effect {
            background: rgba(17, 25, 40, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .gradient-text {
            background: linear-gradient(135deg, #60A5FA, #34D399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #1E293B, #0F172A);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .wave-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-effect border-b border-gray-800/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <div class="flex-shrink-0">
                    <span class="text-xl sm:text-3xl font-bold gradient-text">Gatot AC Mobil</span>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" type="button"
                        class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <!-- Desktop menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="#home"
                            class="text-gray-300 hover:text-blue-400 transition-colors duration-300 px-3 py-2 text-lg">Beranda</a>
                        <a href="#services"
                            class="text-gray-300 hover:text-blue-400 transition-colors duration-300 px-3 py-2 text-lg">Layanan</a>
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="bg-gradient-to-r from-blue-500 to-teal-400 text-white px-6 py-2 rounded-full hover:shadow-lg hover:shadow-blue-500/50 transition duration-300">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-gradient-to-r from-blue-500 to-teal-400 text-white px-6 py-2 rounded-full hover:shadow-lg hover:shadow-blue-500/50 transition duration-300">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-900/90 backdrop-blur-md">
                <a href="#home"
                    class="text-gray-300 hover:text-blue-400 block px-3 py-2 text-base font-medium">Beranda</a>
                <a href="#services"
                    class="text-gray-300 hover:text-blue-400 block px-3 py-2 text-base font-medium">Layanan</a>
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-gradient-to-r from-blue-500 to-teal-400 text-white block px-3 py-2 text-base font-medium rounded-md">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-gradient-to-r from-blue-500 to-teal-400 text-white block px-3 py-2 text-base font-medium rounded-md">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home"
        class="relative min-h-screen flex items-center justify-center hero-gradient overflow-hidden pt-16 sm:pt-20">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/20 to-gray-900">
            <div class="absolute inset-0">
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-500/10 via-transparent to-transparent animate-pulse">
                </div>
            </div>
            <div
                class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-32 flex flex-col items-center md:grid md:grid-cols-2 md:gap-12 md:items-center">
                <!-- Image for mobile (shown above text) -->
                <div class="w-2/3 sm:w-3/5 mx-auto mb-8 md:hidden" data-aos="fade-down">
                    <img src="{{ asset('img/hero.png') }}" alt="Modern AC Service"
                        class="rounded-full animate-float shadow-2xl shadow-blue-500/20">
                </div>

                <!-- Text content -->
                <div class="text-center md:text-left" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-bold mb-4 md:mb-6">
                        <span class="gradient-text">Service</span> dan
                        <br class="hidden sm:block">Perawatan AC Mobil
                    </h1>
                    <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 md:mb-8 text-gray-300">Service AC Mobil
                        untuk kenyamanan berkendara yang maksimal</p>
                    <div
                        class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 items-center sm:items-start">
                        <a href="{{ route('bookings.user') }}"
                            class="w-full sm:w-auto text-center bg-gradient-to-r from-blue-600 to-teal-400 text-white font-bold py-3 px-6 rounded-full hover:shadow-lg hover:shadow-blue-500/50 transition duration-300 transform hover:-translate-y-1">
                            Booking Sekarang
                        </a>
                        <a href="#services"
                            class="w-full sm:w-auto text-center bg-gray-800/50 backdrop-blur-lg text-white font-bold py-3 px-6 rounded-full hover:bg-gray-700/50 transition duration-300 transform hover:-translate-y-1">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <!-- Image for desktop (hidden on mobile) -->
                <div class="hidden md:block" data-aos="fade-left">
                    <img src="{{ asset('img/hero.png') }}" alt="Modern AC Service"
                        class="rounded-full animate-float shadow-2xl shadow-blue-500/20">
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full overflow-hidden">
            <svg class="w-full h-10 sm:h-12 md:h-16 lg:h-24 fill-current text-gray-800" viewBox="0 0 1440 116"
                preserveAspectRatio="none">
                <path
                    d="M0 116L60 96.3C120 77 240 37 360 27.8C480 19 600 39 720 58.8C840 77 960 96 1080 89.2C1200 83 1320 50 1380 34.3L1440 19V116H1380C1320 116 1200 116 1080 116C960 116 840 116 720 116C600 116 480 116 360 116C240 116 120 116 60 116H0Z" />
            </svg>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-32 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 gradient-text">Layanan Premium Kami</h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">Solusi lengkap untuk sistem AC mobil Anda dengan
                    teknologi terkini dan layanan profesional</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($jasa as $service)
                    <div class="glass-effect p-8 rounded-3xl card-hover" data-aos="fade-up" data-aos-delay="100">
                        <!-- Icon Circle -->
                        <div class="mb-8">
                            <div
                                class="w-16 h-16 mx-auto rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Service Content -->
                        <div class="text-center">
                            <h3 class="text-2xl font-bold mb-4 gradient-text">{{ $service->name }}</h3>
                            <p class="text-gray-400 mb-6">{{ $service->description }}</p>

                            <!-- Price Tag -->
                            <div class="mb-6">
                                <span class="text-3xl font-bold text-white">Rp
                                    {{ $service->price }}</span>
                            </div>

                            <!-- Action Button -->
                            <a href="#booking"
                                class="inline-flex items-center justify-center w-full px-8 py-4 text-base font-medium text-white bg-gradient-to-r from-blue-600 to-teal-400 rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition duration-300 transform hover:-translate-y-1">
                                Pilih Layanan
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-32 bg-gray-900 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/10 via-transparent to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 gradient-text">Booking Service</h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">Dapatkan kemudahan booking service AC mobil Anda
                    secara online</p>
            </div>

            <div class="bg-gray-800/50 backdrop-blur-lg p-12 rounded-3xl max-w-3xl mx-auto" data-aos="fade-up">
                <!-- Icon -->
                <div
                    class="w-20 h-20 mx-auto rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center mb-8">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>

                <!-- Content -->
                <h3 class="text-3xl font-bold text-center gradient-text mb-6">Sistem Booking Online</h3>
                <p class="text-gray-400 text-lg text-center max-w-2xl mx-auto mb-12">
                    Nikmati kemudahan melakukan booking service AC mobil Anda melalui sistem booking online kami.
                    Pilih jadwal yang sesuai dengan kenyamanan Anda.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="text-center">
                        <div
                            class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold mb-2">Hemat Waktu</h4>
                        <p class="text-gray-400">Booking service tanpa perlu antri</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-12 h-12 rounded-full bg-teal-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-bold mb-2">Pilih Jadwal</h4>
                        <p class="text-gray-400">Fleksibilitas memilih waktu service</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold mb-2">Konfirmasi Instan</h4>
                        <p class="text-gray-400">Dapat konfirmasi booking langsung</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="text-center mb-12">
                    <a href="{{ route('bookings.user') }}"
                        class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-teal-400 rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition duration-300 transform hover:-translate-y-1">
                        Mulai Booking
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="border-t border-gray-700 pt-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="flex items-center justify-center space-x-4">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span
                                class="text-gray-400">{{ '+62 ' . substr(\App\Models\User::where('is_admin', true)->value('nomor'), 1) }}</span>
                        </div>
                        <div class="flex items-center justify-center space-x-4">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span
                                class="text-gray-400">{{ \App\Models\User::where('is_admin', true)->value('email') }}</span>
                        </div>
                        <div class="flex items-center justify-center space-x-4">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-400">Jl.
                                {{ \App\Models\User::where('is_admin', true)->value('alamat') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-32 bg-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div data-aos="fade-right">
                    <h2 class="text-4xl md:text-5xl font-bold mb-8 gradient-text">Keunggulan Layanan Kami</h2>
                    <div class="space-y-6">
                        <!-- Booking Online -->
                        <div class="flex items-start space-x-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Booking Online</h3>
                                <p class="text-gray-400">Kemudahan reservasi service AC mobil melalui sistem booking
                                    online 24/7</p>
                            </div>
                        </div>

                        <!-- Garansi Service -->
                        <div class="flex items-start space-x-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Garansi Service</h3>
                                <p class="text-gray-400">Jaminan kualitas layanan dengan garansi service yang
                                    terpercaya</p>
                            </div>
                        </div>

                        <!-- Service Cepat -->
                        <div class="flex items-start space-x-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Service Cepat</h3>
                                <p class="text-gray-400">Penanganan service yang cepat dan efisien oleh tim profesional
                                    kami</p>
                            </div>
                        </div>

                        <!-- Teknisi Profesional -->
                        <div class="flex items-start space-x-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Teknisi Profesional</h3>
                                <p class="text-gray-400">Ditangani oleh teknisi berpengalaman dan tersertifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative" data-aos="fade-left">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-teal-400/20 rounded-full blur-3xl">
                    </div>
                    <img src="{{ asset('img/Feature.jpg') }}" alt="Features"
                        class="relative rounded-3xl shadow-2xl transform hover:scale-105 transition duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">10K+</div>
                    <p class="text-gray-400">Pelanggan Puas</p>
                </div>
                <div class="text-center p-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">25+</div>
                    <p class="text-gray-400">Tahun Pengalaman</p>
                </div>
                <div class="text-center p-8" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">2</div>
                    <p class="text-gray-400">Teknisi Ahli</p>
                </div>
                <div class="text-center p-8" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">24/7</div>
                    <p class="text-gray-400">Layanan Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials  -->
    <section class="py-32 bg-gray-900 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/10 via-transparent to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 gradient-text">Apa Kata Mereka</h2>
                @php
                    $averageRating = $ratings->avg('rating');
                    // Sort by rating (highest first) and limit to 6 reviews
                    $displayedRatings = $ratings->sortByDesc('rating')->take(6);
                @endphp
                <div class="flex justify-center items-center space-x-2 mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-8 h-8 {{ $i <= floor($averageRating) ? 'text-yellow-500' : ($i - $averageRating < 1 && $i - $averageRating > 0 ? 'text-yellow-500/50' : 'text-gray-500') }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    @endfor
                    <span class="text-xl text-gray-300 ml-2">{{ number_format($averageRating, 1) }} / 5.0</span>
                </div>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">{{ $ratings->count() }} pelanggan telah memberikan
                    rating untuk website ini</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($displayedRatings as $rating)
                    <div class="glass-effect p-8 rounded-3xl" data-aos="fade-up" data-aos-delay="100">
                        <div class="mb-6">
                            <div class="flex space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-500' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-400 mb-6">"{{ $rating->review }}"</p>
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($rating->user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold">{{ $rating->user->name }}</h4>
                                <p class="text-sm text-gray-400">{{ $rating->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <span class="text-3xl font-bold gradient-text">Gatot AC Mobil</span>
                    <p class="text-gray-400">Solusi terbaik untuk perawatan AC mobil Anda dengan pelayanan profesional
                        dan teknologi terkini.</p>
                    <div class="flex space-x-4">
                        <a href="https://wa.me/{{ \App\Models\User::where('is_admin', true)->value('nomor') }}"
                            class="text-gray-400 hover:text-green-400">
                            <i class="fa-brands fa-whatsapp text-2xl"></i>
                        </a>
                        <a href="https://www.tiktok.com/@gatotacmobil" class="text-gray-400 hover:text-black">
                            <i class="fab fa-tiktok text-2xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-blue-400">Beranda</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-blue-400">Layanan</a></li>
                        <li><a href="#booking" class="text-gray-400 hover:text-blue-400">Booking</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span
                                class="text-gray-400">{{ \App\Models\User::where('is_admin', true)->value('nomor') }}</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span
                                class="text-gray-400">{{ \App\Models\User::where('is_admin', true)->value('email') }}</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-400">Jl.
                                {{ \App\Models\User::where('is_admin', true)->value('alamat') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Business Hours -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Jam Operasional</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400">Senin - Jumat: 08:00 - 17:00</li>
                        <li class="text-gray-400">Sabtu: 08:00 - 15:00</li>
                        <li class="text-gray-400">Minggu: Tutup</li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-12 pt-8">
                <p class="text-center text-gray-400">© 2024 Gatot AC Mobil. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>

        <!-- Wave Divider for Footer -->
        <div class="wave-divider rotate-180">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none" fill="#111827">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
                </path>
            </svg>
        </div>
    </footer>
</body>

</html>

<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>
</body>

</html>
