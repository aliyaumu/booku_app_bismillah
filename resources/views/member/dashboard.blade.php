<x-member-layout>
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-amber-700 rounded-3xl p-8 sm:p-10 shadow-lg text-white">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-20 -mb-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <h1 class="text-3xl sm:text-4xl font-bold heading-font mb-2">Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
                <p class="text-amber-100 text-lg max-w-xl">Selamat datang di Booku. Temukan dan pinjam buku favoritmu hari ini untuk memperluas wawasanmu.</p>
                
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('member.books.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white text-amber-600 hover:bg-amber-50 font-semibold rounded-xl transition-colors shadow-sm">
                        <i class="ti ti-search mr-2 text-lg"></i> Jelajahi Katalog
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-5">
                <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center shrink-0">
                    <i class="ti ti-book-upload text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Buku Sedang Dipinjam</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeBorrowings->count() }}</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-5">
                <div class="w-14 h-14 bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 rounded-2xl flex items-center justify-center shrink-0">
                    <i class="ti ti-cash text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Total Denda Belum Lunas</p>
                    <h3 class="text-2xl font-bold {{ $unpaidFines > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-gray-900 dark:text-white' }}">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>



        <!-- Active Borrowings Section -->
        @if($activeBorrowings->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white heading-font">Aktivitas Peminjamanmu</h2>
                <a href="{{ route('member.borrowings.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 dark:text-amber-400">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach($activeBorrowings->take(4) as $borrowing)
                    <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl p-4 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-16 h-24 bg-gray-100 dark:bg-slate-700 rounded-lg overflow-hidden shrink-0 border border-gray-200 dark:border-slate-600">
                            @if($borrowing->book->cover_image)
                                <img src="{{ $borrowing->book->cover_image_url }}" alt="{{ $borrowing->book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center"><i class="ti ti-book text-gray-400"></i></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">{{ $borrowing->book->title }}</h3>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mb-2 truncate">{{ $borrowing->book->author }}</p>
                            
                            @if($borrowing->status === 'borrowed' || $borrowing->status === 'overdue')
                                @php
                                    $dueDate = \Carbon\Carbon::parse($borrowing->due_date);
                                    $isLate = now()->gt($dueDate->copy()->endOfDay());
                                    $daysLeft = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);
                                @endphp
                                <div class="text-xs font-medium {{ $isLate ? 'text-rose-500' : ($daysLeft <= 2 ? 'text-amber-500' : 'text-emerald-500') }}">
                                    @if($isLate)
                                        Terlambat {{ abs($daysLeft) }} hari
                                    @elseif($daysLeft == 0)
                                        Jatuh tempo hari ini
                                    @else
                                        Sisa waktu {{ $daysLeft }} hari
                                    @endif
                                </div>
                            @else
                                <div class="text-xs font-medium text-blue-500">
                                    {{ $borrowing->status === 'approved' ? 'Silakan ambil buku' : 'Menunggu verifikasi kembali' }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Latest Books -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white heading-font">Koleksi Terbaru</h2>
                <a href="{{ route('member.books.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 dark:text-amber-400">Lihat Katalog</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
                @foreach($latestBooks as $book)
                    <a href="{{ route('member.books.show', $book->slug) }}" class="group block">
                        <div class="aspect-[2/3] w-full rounded-xl bg-gray-100 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 overflow-hidden mb-3 relative shadow-sm group-hover:shadow-md transition-all group-hover:-translate-y-1">
                            @if($book->cover_image)
                                <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="ti ti-photo-off text-4xl text-gray-300 dark:text-slate-600"></i>
                                </div>
                            @endif
                            
                            @if($book->available_stock < 1)
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center backdrop-blur-[2px]">
                                    <span class="px-3 py-1 bg-rose-500 text-white text-xs font-bold rounded-full shadow-sm">Habis</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2 leading-tight mb-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $book->title }}</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1">{{ $book->author }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-member-layout>
