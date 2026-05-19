<x-admin-layout>
    <x-slot name="header">
        Detail Anggota
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Profile Sidebar -->
        <div class="xl:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="h-32 bg-gradient-to-r from-amber-400 to-amber-600"></div>
                <div class="px-6 pb-6 relative">
                    <div class="flex justify-center -mt-16 mb-4">
                        <img class="h-32 w-32 rounded-full border-4 border-white dark:border-slate-800 bg-white dark:bg-slate-800" src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&color=F59E0B&background=FEF3C7&size=256" alt="{{ $member->name }}">
                    </div>
                    
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $member->name }}</h2>
                        <p class="text-gray-500 dark:text-slate-400 mt-1">{{ $member->student_id ?: 'Tidak ada NIM/NIP' }}</p>
                        
                        <div class="mt-3">
                            @if($member->status === 'active')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border bg-rose-50 text-rose-600 border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                    Suspended
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4 border-t border-gray-100 dark:border-slate-700 pt-4">
                        <div class="flex items-start gap-3">
                            <i class="ti ti-mail text-gray-400 dark:text-slate-500 mt-0.5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Email</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white break-all">{{ $member->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="ti ti-phone text-gray-400 dark:text-slate-500 mt-0.5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">No. Handphone</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $member->phone ?: '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="ti ti-map-pin text-gray-400 dark:text-slate-500 mt-0.5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Alamat</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $member->address ?: '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="ti ti-calendar text-gray-400 dark:text-slate-500 mt-0.5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Bergabung Sejak</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $member->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-700">
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="flex items-center justify-center w-full px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                            <i class="ti ti-edit mr-2 text-lg"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Statistik Peminjaman</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-500/10 rounded-xl p-4 border border-blue-100 dark:border-blue-500/20 text-center">
                        <p class="text-xs font-medium text-blue-600 dark:text-blue-400 mb-1">Total Pinjam</p>
                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $member->borrowings->count() }}</p>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-500/10 rounded-xl p-4 border border-amber-100 dark:border-amber-500/20 text-center">
                        <p class="text-xs font-medium text-amber-600 dark:text-amber-400 mb-1">Sedang Pinjam</p>
                        <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $member->borrowings->whereIn('status', ['borrowed', 'overdue'])->count() }}</p>
                    </div>
                    <div class="bg-emerald-50 dark:bg-emerald-500/10 rounded-xl p-4 border border-emerald-100 dark:border-emerald-500/20 text-center">
                        <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 mb-1">Dikembalikan</p>
                        <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ $member->borrowings->where('status', 'returned')->count() }}</p>
                    </div>
                    <div class="bg-rose-50 dark:bg-rose-500/10 rounded-xl p-4 border border-rose-100 dark:border-rose-500/20 text-center">
                        <p class="text-xs font-medium text-rose-600 dark:text-rose-400 mb-1">Denda Belum Lunas</p>
                        <p class="text-2xl font-bold text-rose-700 dark:text-rose-300">{{ $member->fines->where('status', 'unpaid')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content (History) -->
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Peminjaman</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-white dark:bg-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Buku</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tgl Pinjam/Kembali</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                            @forelse($member->borrowings->sortByDesc('created_at') as $borrowing)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-8 bg-gray-100 dark:bg-slate-700 rounded flex items-center justify-center overflow-hidden border border-gray-200 dark:border-slate-600">
                                            @if($borrowing->book->cover_image)
                                                <img class="h-full w-full object-cover" src="{{ asset('storage/'.$borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}">
                                            @else
                                                <i class="ti ti-book text-gray-400"></i>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ Str::limit($borrowing->book->title, 30) }}</div>
                                            <div class="text-xs text-gray-500 dark:text-slate-400">{{ $borrowing->book->author }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $borrowing->borrowed_date ? \Carbon\Carbon::parse($borrowing->borrowed_date)->format('d M Y') : '-' }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400">
                                        Tenggat: {{ $borrowing->due_date ? \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') : '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($borrowing->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">Menunggu</span>
                                            @break
                                        @case('approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400">Disetujui</span>
                                            @break
                                        @case('borrowed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-400">Dipinjam</span>
                                            @break
                                        @case('overdue')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 dark:bg-rose-500/20 dark:text-rose-400">Terlambat</span>
                                            @break
                                        @case('return_requested')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-500/20 dark:text-fuchsia-400">Meminta Kembali</span>
                                            @break
                                        @case('returned')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">Dikembalikan</span>
                                            @break
                                        @case('rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-400">Ditolak</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 dark:bg-slate-800/80 rounded-full flex items-center justify-center mb-3">
                                            <i class="ti ti-history text-2xl text-gray-400 dark:text-slate-500"></i>
                                        </div>
                                        <p class="text-sm font-medium">Belum ada riwayat peminjaman.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
