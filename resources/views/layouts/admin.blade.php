<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 dark:bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Booku') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .heading-font { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full antialiased text-gray-800 dark:text-gray-200 selection:bg-amber-500 selection:text-white">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-gray-900/80 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 flex flex-col bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 transition-transform duration-300 lg:static lg:translate-x-0">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b border-gray-100 dark:border-slate-700/50 px-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                        <i class="ti ti-books text-xl"></i>
                    </div>
                    <span class="text-xl font-bold heading-font tracking-tight text-slate-800 dark:text-white">Booku<span class="text-amber-500">.</span></span>
                </a>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 scrollbar-hide">
                <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="ti-layout-dashboard">
                    Dashboard
                </x-admin-nav-link>

                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Katalog</p>
                </div>
                <x-admin-nav-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')" icon="ti-book">
                    Kelola Buku
                </x-admin-nav-link>

                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Sirkulasi</p>
                </div>
                <x-admin-nav-link :href="route('admin.borrowings.requests')" :active="request()->routeIs('admin.borrowings.requests')" icon="ti-hand-click">
                    Permintaan Pinjam
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.borrowings.index')" :active="request()->routeIs('admin.borrowings.index')" icon="ti-exchange">
                    Semua Transaksi
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.returns.index')" :active="request()->routeIs('admin.returns.*')" icon="ti-arrow-back-up">
                    Pengembalian
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.fines.index')" :active="request()->routeIs('admin.fines.*')" icon="ti-cash">
                    Kelola Denda
                </x-admin-nav-link>

                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Pengguna</p>
                </div>
                <x-admin-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')" icon="ti-users">
                    Data Anggota
                </x-admin-nav-link>

                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Laporan</p>
                </div>
                <x-admin-nav-link :href="route('admin.statistics')" :active="request()->routeIs('admin.statistics')" icon="ti-chart-bar">
                    Statistik
                </x-admin-nav-link>
            </div>

            <!-- User Info (Bottom) -->
            <div class="border-t border-gray-100 dark:border-slate-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center border border-gray-200 dark:border-slate-600">
                        <i class="ti ti-user text-slate-500 dark:text-slate-300"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-slate-400 truncate">
                            Administrator
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50/50 dark:bg-slate-900">
            
            <!-- Topbar -->
            <header class="h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-gray-200 dark:border-slate-700 z-10 sticky top-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none lg:hidden">
                        <i class="ti ti-menu-2 text-2xl"></i>
                    </button>
                    
                    @isset($header)
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white heading-font">
                            {{ $header }}
                        </h1>
                    @endisset
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notification Bell (Example) -->
                    <button class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <i class="ti ti-bell text-xl"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white dark:ring-slate-800"></span>
                    </button>

                    <!-- Dropdown Profile -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 text-sm focus:outline-none">
                            <img class="w-8 h-8 rounded-full border border-gray-200 dark:border-slate-600" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=F59E0B&background=FEF3C7" alt="Avatar">
                            <i class="ti ti-chevron-down text-gray-400 text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 py-1 z-50 origin-top-right">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
