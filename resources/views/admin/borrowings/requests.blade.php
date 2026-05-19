<x-admin-layout>
    <x-slot name="header">
        Permintaan Pinjam Buku
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-400 flex items-start shadow-sm">
                <i class="ti ti-check w-5 h-5 mr-3 mt-0.5"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 dark:bg-rose-500/10 dark:border-rose-500/20 dark:text-rose-400 flex items-start shadow-sm">
                <i class="ti ti-alert-circle w-5 h-5 mr-3 mt-0.5"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Peminjam</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Buku yang Dipinjam</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Waktu Permintaan</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                        @forelse($requests as $req)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($req->user->name) }}&color=F59E0B&background=FEF3C7" alt="">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $req->user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400">{{ $req->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ Str::limit($req->book->title, 40) }}</div>
                                <div class="text-xs text-gray-500 dark:text-slate-400 flex items-center gap-1 mt-0.5">
                                    Stok tersedia: 
                                    <span class="{{ $req->book->available_stock > 0 ? 'text-emerald-500 font-bold' : 'text-rose-500 font-bold' }}">
                                        {{ $req->book->available_stock }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $req->created_at->format('d M Y, H:i') }}</div>
                                <div class="text-xs text-gray-500 dark:text-slate-400">{{ $req->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.borrowings.approve', $req->id) }}" method="POST" class="inline" onsubmit="return confirm('Setujui peminjaman ini?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-500/20 rounded-lg text-sm font-medium transition-colors" {{ $req->book->available_stock < 1 ? 'disabled' : '' }}>
                                            Setujui
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.borrowings.reject', $req->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak peminjaman ini?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20 rounded-lg text-sm font-medium transition-colors">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 dark:bg-slate-800/80 rounded-full flex items-center justify-center mb-4 border border-gray-100 dark:border-slate-700">
                                        <i class="ti ti-check text-3xl text-emerald-400"></i>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">Tidak ada permintaan baru</p>
                                    <p class="text-sm mt-1">Semua permintaan pinjam sudah diselesaikan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                {{ $requests->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
