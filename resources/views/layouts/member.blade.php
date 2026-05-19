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
    <nav x-data="{ mobileMenuOpen: false, profileDropdownOpen: false }" class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2 shrink-0">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                            <i class="ti ti-books text-xl"></i>
                        </div>
                        <span class="text-xl font-bold heading-font tracking-tight text-slate-800 dark:text-white hidden sm:block">Booku<span class="text-amber-500">.</span></span>
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex space-x-1">
                        <a href="{{ route('member.dashboard') }}" class="px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('member.dashboard') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-slate-300 hover:text-gray-900 hover:bg-gray-50 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('member.books.index') }}" class="px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('member.books.*') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-slate-300 hover:text-gray-900 hover:bg-gray-50 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                            Katalog
                        </a>
                        <a href="{{ route('member.borrowings.index') }}" class="px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('member.borrowings.*', 'member.history') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-slate-300 hover:text-gray-900 hover:bg-gray-50 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                            Buku Saya
                        </a>
                        <a href="{{ route('member.wishlist.index') }}" class="px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('member.wishlist.*') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-600 dark:text-slate-300 hover:text-gray-900 hover:bg-gray-50 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                            Wishlist
                        </a>
                    </div>
                </div>

                <!-- Right Side (Desktop) -->
                <div class="hidden md:flex items-center gap-4">
                    <!-- Global Search -->
                    <div class="relative w-64">
                        <form action="{{ route('member.books.index') }}" method="GET">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ti ti-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" class="block w-full pl-10 pr-3 py-1.5 border border-gray-200 dark:border-slate-700 rounded-full bg-gray-50 dark:bg-slate-900/50 text-sm placeholder-gray-500 focus:ring-amber-500 focus:border-amber-500 dark:text-gray-200 transition-colors" placeholder="Cari buku...">
                        </form>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative ml-2">
                        <button @click="profileDropdownOpen = !profileDropdownOpen" @click.away="profileDropdownOpen = false" class="flex items-center gap-2 focus:outline-none rounded-full p-1 border border-transparent hover:border-gray-200 dark:hover:border-slate-700 transition-colors">
                            <img class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=F59E0B&background=FEF3C7" alt="">
                            <div class="hidden lg:block text-left mr-1">
                                <p class="text-xs font-semibold text-gray-900 dark:text-white leading-none">{{ Str::limit(Auth::user()->name, 15) }}</p>
                            </div>
                            <i class="ti ti-chevron-down text-gray-400 text-xs mr-1 hidden lg:block"></i>
                        </button>

                        <div x-show="profileDropdownOpen" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 py-1 z-50 origin-top-right">
                            <div class="px-4 py-2 border-b border-gray-100 dark:border-slate-700 mb-1 lg:hidden">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors"><i class="ti ti-user mr-2 text-gray-400"></i> Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors">
                                    <i class="ti ti-logout mr-2 text-rose-400"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
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
                <form action="{{ route('member.books.index') }}" method="GET" class="mb-4 mt-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50 dark:bg-slate-900/50 text-sm placeholder-gray-500 focus:ring-amber-500 focus:border-amber-500 dark:text-gray-200" placeholder="Cari buku...">
                    </div>
                </form>
                
                <a href="{{ route('member.dashboard') }}" class="block px-3 py-2 rounded-xl text-base font-medium {{ request()->routeIs('member.dashboard') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">Dashboard</a>
                <a href="{{ route('member.books.index') }}" class="block px-3 py-2 rounded-xl text-base font-medium {{ request()->routeIs('member.books.*') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">Katalog</a>
                <a href="{{ route('member.borrowings.index') }}" class="block px-3 py-2 rounded-xl text-base font-medium {{ request()->routeIs('member.borrowings.*', 'member.history') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">Buku Saya</a>
                <a href="{{ route('member.wishlist.index') }}" class="block px-3 py-2 rounded-xl text-base font-medium {{ request()->routeIs('member.wishlist.*') ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">Wishlist</a>
            </div>
            <div class="pt-4 pb-4 border-t border-gray-100 dark:border-slate-700">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=F59E0B&background=FEF3C7" alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-4">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-xl text-base font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-xl text-base font-medium text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @isset($header)
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white heading-font">{{ $header }}</h1>
                @isset($description)
                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">{{ $description }}</p>
                @endisset
            </div>
        @endisset

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-800 border-t border-gray-100 dark:border-slate-700 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
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
