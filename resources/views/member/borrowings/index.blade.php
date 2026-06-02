<x-member-layout>
    <x-slot name="header">
        Buku Saya
    </x-slot>

    <div class="space-y-8">
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

        <!-- Active Borrowings -->
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white heading-font mb-4">Peminjaman Aktif</h2>
            
            @if($borrowings->isEmpty())
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 py-12 px-6 text-center">
                    <div class="w-16 h-16 bg-gray-50 dark:bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-book text-3xl text-gray-400 dark:text-slate-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Belum ada buku yang dipinjam</h3>
                    <p class="text-gray-500 dark:text-slate-400 mb-6">Ayo jelajahi katalog dan temukan buku menarik untuk dibaca.</p>
                    <a href="{{ route('member.books.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        Jelajahi Katalog
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($borrowings as $borrowing)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5 flex flex-col sm:flex-row gap-5 relative overflow-hidden">
                            <!-- Status Indicator Line -->
                            @php
                                $statusColor = 'bg-gray-400';
                                if($borrowing->status === 'pending') $statusColor = 'bg-yellow-500';
                                if($borrowing->status === 'approved') $statusColor = 'bg-blue-500';
                                if($borrowing->status === 'borrowed') $statusColor = 'bg-indigo-500';
                                if($borrowing->status === 'overdue') $statusColor = 'bg-rose-500';
                                if($borrowing->status === 'return_requested') $statusColor = 'bg-fuchsia-500';
                            @endphp
                            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $statusColor }}"></div>

                            <!-- Cover -->
                            <div class="w-24 shrink-0 mx-auto sm:mx-0">
                                <div class="aspect-[2/3] w-full rounded-lg bg-gray-100 dark:bg-slate-700 overflow-hidden shadow-sm border border-gray-200 dark:border-slate-600">
                                    @if($borrowing->book->cover_image)
                                        <img src="{{ $borrowing->book->cover_image_url }}" alt="{{ $borrowing->book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center"><i class="ti ti-book text-gray-400 text-2xl"></i></div>
                                    @endif
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="flex-1 flex flex-col min-w-0">
                                <a href="{{ route('member.books.show', $borrowing->book->slug) }}" class="text-lg font-bold text-gray-900 dark:text-white line-clamp-2 hover:text-amber-600 dark:hover:text-amber-400 transition-colors leading-tight mb-1">
                                    {{ $borrowing->book->title }}
                                </a>
                                <p class="text-sm text-gray-500 dark:text-slate-400 mb-3">{{ $borrowing->book->author }}</p>

                                <div class="space-y-2 mt-auto text-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-500 dark:text-slate-400">Status</span>
                                        <span class="font-medium px-2.5 py-0.5 rounded-full text-xs
                                            @if($borrowing->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400
                                            @elseif($borrowing->status === 'approved') bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400
                                            @elseif($borrowing->status === 'borrowed') bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-400
                                            @elseif($borrowing->status === 'overdue') bg-rose-100 text-rose-800 dark:bg-rose-500/20 dark:text-rose-400
                                            @elseif($borrowing->status === 'return_requested') bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-500/20 dark:text-fuchsia-400
                                            @endif
                                        ">
                                            @switch($borrowing->status)
                                                @case('pending') Menunggu Persetujuan @break
                                                @case('approved') Siap Diambil @break
                                                @case('borrowed') Sedang Dipinjam @break
                                                @case('overdue') Terlambat @break
                                                @case('return_requested') Menunggu Verifikasi Kembali @break
                                            @endswitch
                                        </span>
                                    </div>
                                    
                                    @if(in_array($borrowing->status, ['borrowed', 'overdue', 'return_requested']))
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-500 dark:text-slate-400">Jatuh Tempo</span>
                                            @php
                                                $dueDate = \Carbon\Carbon::parse($borrowing->due_date);
                                                $isLate = now()->gt($dueDate->copy()->endOfDay());
                                            @endphp
                                            <span class="font-medium {{ $isLate ? 'text-rose-600 dark:text-rose-400' : 'text-gray-900 dark:text-white' }}">
                                                {{ $dueDate->format('d M Y') }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if($borrowing->status === 'pending')
                                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-slate-400 pt-2 border-t border-gray-100 dark:border-slate-700">
                                            <span>Diajukan pada:</span>
                                            <span>{{ $borrowing->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if(in_array($borrowing->status, ['borrowed', 'overdue']))
                                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-700 text-right">
                                        <form action="{{ route('member.borrowings.requestReturn', $borrowing->id) }}" method="POST" onsubmit="return confirm('Ajukan pengembalian buku? Pastikan Anda sudah/akan menyerahkan fisik buku ke petugas.');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors w-full sm:w-auto justify-center">
                                                <i class="ti ti-arrow-back-up mr-2"></i> Kembalikan Buku
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- History -->
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white heading-font mb-4">Riwayat Peminjaman</h2>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-800/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Buku</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tgl Pinjam</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tgl Kembali / Selesai</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                            @forelse($history as $item)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('member.books.show', $item->book->slug) }}" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">{{ Str::limit($item->book->title, 40) }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $item->borrowed_date ? \Carbon\Carbon::parse($item->borrowed_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $item->returned_date ? \Carbon\Carbon::parse($item->returned_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->status === 'returned')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-400">Dikembalikan</span>
                                    @elseif($item->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-600/20 dark:text-red-500">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400 text-sm">
                                    Belum ada riwayat peminjaman yang selesai.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($history->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                    {{ $history->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-member-layout>
