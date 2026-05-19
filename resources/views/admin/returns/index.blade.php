<x-admin-layout>
    <x-slot name="header">
        Verifikasi Pengembalian
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
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Buku</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tgl Pinjam / Jatuh Tempo</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                        @forelse($returns as $ret)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($ret->user->name) }}&color=F59E0B&background=FEF3C7" alt="">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ret->user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400">{{ $ret->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ Str::limit($ret->book->title, 40) }}</div>
                                <div class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Stok tersedia saat ini: {{ $ret->book->available_stock }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">Pinjam: {{ \Carbon\Carbon::parse($ret->borrowed_date)->format('d M Y') }}</div>
                                @php
                                    $dueDate = \Carbon\Carbon::parse($ret->due_date);
                                    $isLate = now()->gt($dueDate->copy()->endOfDay());
                                @endphp
                                <div class="text-xs {{ $isLate ? 'text-rose-500 font-semibold' : 'text-gray-500 dark:text-slate-400' }}">
                                    Jatuh Tempo: {{ $dueDate->format('d M Y') }}
                                    @if($isLate)
                                        (Terlambat)
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('admin.returns.verify', $ret->id) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi bahwa buku ini telah diterima secara fisik?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500/20 rounded-lg text-sm font-medium transition-colors inline-flex items-center">
                                        <i class="ti ti-check w-4 h-4 mr-1"></i> Verifikasi Fisik
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 dark:bg-slate-800/80 rounded-full flex items-center justify-center mb-4 border border-gray-100 dark:border-slate-700">
                                        <i class="ti ti-check text-3xl text-indigo-400"></i>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">Tidak ada buku yang menunggu verifikasi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($returns->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                {{ $returns->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
