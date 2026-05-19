<x-admin-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Books -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 dark:bg-blue-500/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Total Buku</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_books']) }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <i class="ti ti-books text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Members -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 dark:bg-emerald-500/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Total Anggota</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_members']) }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <i class="ti ti-users text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Borrowings -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 dark:bg-amber-500/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Sedang Dipinjam</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['active_borrowings']) }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <i class="ti ti-book-upload text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-50 dark:bg-rose-500/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Permintaan Baru</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['pending_requests']) }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-rose-100 dark:bg-rose-500/20 flex items-center justify-center text-rose-600 dark:text-rose-400">
                        <i class="ti ti-bell-ringing text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Permintaan Pinjam Terbaru -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 dark:text-white">Permintaan Pinjam (Perlu Persetujuan)</h3>
                    <a href="{{ route('admin.borrowings.requests') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($recentRequests as $request)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                                    <i class="ti ti-book-download"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $request->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-400">Ingin meminjam: <span class="font-medium text-gray-700 dark:text-gray-300">{{ Str::limit($request->book->title, 30) }}</span></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400 dark:text-slate-500">{{ $request->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                            <p class="text-sm">Tidak ada permintaan pinjaman baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Permintaan Kembali Terbaru -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 dark:text-white">Permintaan Pengembalian</h3>
                    <a href="{{ route('admin.returns.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($recentReturns as $return)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                    <i class="ti ti-arrow-back-up"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $return->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-400">Mengembalikan: <span class="font-medium text-gray-700 dark:text-gray-300">{{ Str::limit($return->book->title, 30) }}</span></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400 dark:text-slate-500">{{ $return->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                            <p class="text-sm">Tidak ada permintaan pengembalian baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
