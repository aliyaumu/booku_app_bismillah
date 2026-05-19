<x-admin-layout>
    <x-slot name="header">
        Kelola Denda
    </x-slot>

    <div class="space-y-6">
        <!-- Top Actions & Filter -->
        <div class="flex flex-col sm:flex-row justify-between gap-4">
            <div class="flex-1 max-w-md">
                <form action="{{ route('admin.fines.index') }}" method="GET" class="flex gap-2">
                    <select name="status" class="block w-full rounded-xl border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm focus:border-amber-500 focus:ring-amber-500 shadow-sm transition-colors dark:text-gray-200">
                        <option value="">Semua Status Pembayaran</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Lunas</option>
                    </select>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        Filter
                    </button>
                    @if(request('status'))
                        <a href="{{ route('admin.fines.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
            
            <div class="flex items-center gap-4 bg-white dark:bg-slate-800 px-4 py-2 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700">
                <p class="text-sm text-gray-500 dark:text-slate-400">Total Belum Lunas:</p>
                <p class="text-lg font-bold text-rose-600 dark:text-rose-400">Rp {{ number_format(\App\Models\Fine::where('status', 'unpaid')->sum('total_amount'), 0, ',', '.') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-400 flex items-start shadow-sm">
                <i class="ti ti-check w-5 h-5 mr-3 mt-0.5"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Anggota</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Buku Terkait</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nominal Denda</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                        @forelse($fines as $fine)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($fine->user->name) }}&color=F59E0B&background=FEF3C7" alt="">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $fine->user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400">{{ $fine->user->student_id ?: '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ Str::limit($fine->borrowing->book->title, 40) }}</div>
                                <div class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Dikembalikan lambat pada: {{ \Carbon\Carbon::parse($fine->borrowing->returned_date)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">Rp {{ number_format($fine->total_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($fine->status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20">
                                        <i class="ti ti-check w-3 h-3 mr-1"></i> Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border bg-rose-50 text-rose-600 border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20">
                                        <i class="ti ti-x w-3 h-3 mr-1"></i> Belum Dibayar
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($fine->status !== 'paid')
                                    <form action="{{ route('admin.fines.pay', $fine->id) }}" method="POST" class="inline" onsubmit="return confirm('Tandai denda ini sebagai lunas?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:hover:bg-amber-500/20 rounded-lg text-sm font-medium transition-colors">
                                            Tandai Lunas
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 dark:bg-slate-800/80 rounded-full flex items-center justify-center mb-4 border border-gray-100 dark:border-slate-700">
                                        <i class="ti ti-cash text-3xl text-gray-400 dark:text-slate-500"></i>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">Tidak ada data denda</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($fines->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                {{ $fines->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
