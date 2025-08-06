<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BusGo - Pesan Tiket Bus Online</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <!-- Navigation -->
    <nav class="relative z-50 bg-white/90 backdrop-blur-md border-b border-gray-200/50 sticky top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">BusGo</span>
                </div>

                <!-- Navigation Links -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] -z-10"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center space-x-2 bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <span>Booking Online Terpercaya</span>
                        </div>
                        
                        <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Perjalanan 
                            <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                                Nyaman
                            </span>
                            Dimulai dari Sini
                        </h1>
                        
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Pesan tiket bus dengan mudah, aman, dan terpercaya. Ribuan rute tersedia dengan harga terbaik untuk perjalanan Anda.
                        </p>
                    </div>

                    <!-- Search Form -->
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border border-gray-200/50">
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Dari</label>
                                <div class="relative">
                                    <input type="text" placeholder="Kota asal" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Ke</label>
                                <div class="relative">
                                    <input type="text" placeholder="Kota tujuan" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Tanggal Keberangkatan</label>
                                <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Jumlah Penumpang</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                    <option>1 Penumpang</option>
                                    <option>2 Penumpang</option>
                                    <option>3 Penumpang</option>
                                    <option>4+ Penumpang</option>
                                </select>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span>Cari Tiket Bus</span>
                            </div>
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">500K+</div>
                            <div class="text-sm text-gray-600">Penumpang</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-indigo-600">150+</div>
                            <div class="text-sm text-gray-600">Rute</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">24/7</div>
                            <div class="text-sm text-gray-600">Support</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Illustration -->
                <div class="relative">
                    <div class="relative bg-gradient-to-br from-blue-400 via-blue-500 to-indigo-600 rounded-3xl p-8 shadow-2xl">
                        <!-- Bus Illustration -->
                        <div class="relative bg-white rounded-2xl p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">Executive Class</div>
                                        <div class="text-sm text-gray-500">Jakarta - Bandung</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-gray-900">Rp 75,000</div>
                                    <div class="text-sm text-green-600">Tersedia</div>
                                </div>
                            </div>
                            
                            <!-- Bus seats preview -->
                            <div class="grid grid-cols-4 gap-2 mb-4">
                                <div class="w-8 h-6 bg-green-200 rounded border-2 border-green-400"></div>
                                <div class="w-8 h-6 bg-green-200 rounded border-2 border-green-400"></div>
                                <div class="w-8 h-6 bg-gray-200 rounded border-2 border-gray-300"></div>
                                <div class="w-8 h-6 bg-green-200 rounded border-2 border-green-400"></div>
                                <div class="w-8 h-6 bg-green-200 rounded border-2 border-green-400"></div>
                                <div class="w-8 h-6 bg-red-200 rounded border-2 border-red-400"></div>
                                <div class="w-8 h-6 bg-green-200 rounded border-2 border-green-400"></div>
                                <div class="w-8 h-6 bg-green-200 rounded border-2 border-green-400"></div>
                            </div>
                            
                            <div class="text-center">
                                <button class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-2 rounded-lg text-sm font-medium hover:from-green-600 hover:to-emerald-600 transition-all duration-300">
                                    Pilih Kursi
                                </button>
                            </div>
                        </div>

                        <!-- Floating elements -->
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-yellow-800" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        </div>
                        
                        <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-pink-400 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-pink-800" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-white/50 backdrop-blur-sm py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih BusGo?</h2>
                    <p class="text-lg text-gray-600">Platform booking terdepan dengan layanan terbaik</p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200/50">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aman & Terpercaya</h3>
                        <p class="text-gray-600">Sistem pembayaran yang aman dengan enkripsi SSL dan partner bus terpercaya.</p>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200/50">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Booking Instan</h3>
                        <p class="text-gray-600">Proses pemesanan cepat dalam hitungan menit dengan konfirmasi real-time.</p>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200/50">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">24/7 Support</h3>
                        <p class="text-gray-600">Tim customer service siap membantu Anda kapan saja, di mana saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold">BusGo</span>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-gray-400">&copy; 2025 BusGo. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>