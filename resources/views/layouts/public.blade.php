<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-50 dark:bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Booku') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .heading-font { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="antialiased text-gray-800 dark:text-gray-200 selection:bg-amber-500 selection:text-white flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <nav x-data="{ mobileMenuOpen: false }" class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <a href="{{ route('landing') }}" class="flex items-center gap-2 shrink-0">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                            <i class="ti ti-books text-xl"></i>
                        </div>
                        <span class="text-xl font-bold heading-font tracking-tight text-slate-800 dark:text-white sm:block">Booku<span class="text-amber-500">.</span></span>
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex space-x-1">
                        <a href="{{ route('landing') }}" class="px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('landing') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-slate-300 hover:text-gray-900 hover:bg-gray-50 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                            Beranda
                        </a>
                        <a href="{{ route('books.catalog') }}" class="px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('books.catalog', 'books.show') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-slate-300 hover:text-gray-900 hover:bg-gray-50 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                            Katalog Buku
                        </a>
                    </div>
                </div>

                <!-- Right Side (Desktop) -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-all shadow-md shadow-amber-500/20">
                            Ke Dashboard <i class="ti ti-arrow-narrow-right ml-1 text-base"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 dark:text-slate-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-xl transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 dark:bg-amber-500 dark:hover:bg-amber-600 rounded-xl transition-all shadow-md shadow-slate-900/10 dark:shadow-amber-500/20">
                            Daftar Anggota
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none p-2">
                        <i class="ti text-2xl" :class="mobileMenuOpen ? 'ti-x' : 'ti-menu-2'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('landing') }}" class="block px-3 py-2 rounded-xl text-base font-medium {{ request()->routeIs('landing') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">Beranda</a>
                <a href="{{ route('books.catalog') }}" class="block px-3 py-2 rounded-xl text-base font-medium {{ request()->routeIs('books.catalog', 'books.show') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">Katalog Buku</a>
            </div>
            <div class="pt-4 pb-4 border-t border-gray-100 dark:border-slate-700 px-4 flex flex-col gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-2 text-base font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-all shadow-md shadow-amber-500/20">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2 text-base font-semibold text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 rounded-xl transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 text-base font-semibold text-white bg-slate-900 hover:bg-slate-800 dark:bg-amber-500 dark:hover:bg-amber-600 rounded-xl transition-all">
                        Daftar Anggota
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-1 w-full">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-800 border-t border-gray-100 dark:border-slate-700 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-sm">
                    <i class="ti ti-books text-sm"></i>
                </div>
                <span class="text-sm font-bold heading-font tracking-tight text-slate-800 dark:text-white">Booku<span class="text-amber-500">.</span></span>
            </div>
            <p class="text-sm text-gray-500 dark:text-slate-400">
                &copy; {{ date('Y') }} Booku. All rights reserved.
            </p>
            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-slate-400">
                <a href="#" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Bantuan</a>
                <a href="#" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>
</body>
</html>
