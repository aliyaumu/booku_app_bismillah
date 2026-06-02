<x-member-layout>
    <div class="mb-4">
        <a href="{{ route('member.books.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-amber-600 dark:text-slate-400 dark:hover:text-amber-400 transition-colors">
            <i class="ti ti-arrow-left mr-1 text-lg"></i> Kembali ke Katalog
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-400 flex items-start shadow-sm">
            <i class="ti ti-check w-5 h-5 mr-3 mt-0.5"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="p-4 mb-6 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 dark:bg-rose-500/10 dark:border-rose-500/20 dark:text-rose-400 flex items-start shadow-sm">
            <i class="ti ti-alert-circle w-5 h-5 mr-3 mt-0.5"></i>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-10">
        <div class="p-6 md:p-10 flex flex-col md:flex-row gap-10">
            <!-- Book Cover -->
            <div class="w-full md:w-80 shrink-0">
                <div class="aspect-[2/3] w-full rounded-2xl bg-gray-100 dark:bg-slate-700 overflow-hidden shadow-md border border-gray-200 dark:border-slate-600 relative">
                    @if($book->cover_image)
                        <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="ti ti-photo-off text-6xl text-gray-300 dark:text-slate-500"></i>
                        </div>
                    @endif
                    
                    @if($book->available_stock < 1)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center backdrop-blur-[2px]">
                            <span class="px-4 py-1.5 bg-rose-500 text-white text-sm font-bold rounded-full shadow-sm">Stok Habis</span>
                        </div>
                    @endif
                </div>

                <div class="mt-6 space-y-3">
                    @if($activeBorrowing)
                        <div class="w-full text-center p-3 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20">
                            <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-400 mb-1">Status Peminjaman Anda</p>
                            <p class="text-xs text-indigo-600 dark:text-indigo-300">
                                @switch($activeBorrowing->status)
                                    @case('pending') Menunggu persetujuan admin @break
                                    @case('approved') Disetujui, silakan ambil buku di perpustakaan @break
                                    @case('borrowed') Sedang Anda pinjam @break
                                    @case('overdue') Terlambat dikembalikan @break
                                    @case('return_requested') Menunggu verifikasi pengembalian @break
                                @endswitch
                            </p>
                        </div>
                    @else
                        <form action="{{ route('member.books.borrow', $book->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin meminjam buku ini?');">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors {{ $book->available_stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $book->available_stock < 1 ? 'disabled' : '' }}>
                                <i class="ti ti-book-download mr-2 text-lg"></i> Pinjam Buku Ini
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('member.wishlist.toggle', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                            <i class="ti {{ $inWishlist ? 'ti-heart-filled text-rose-500' : 'ti-heart text-gray-400' }} mr-2 text-lg transition-colors"></i> 
                            {{ $inWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Book Info -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded border text-xs font-semibold" style="background-color: {{ $book->category->color }}15; color: {{ $book->category->color }}; border-color: {{ $book->category->color }}30;">
                        {{ $book->category->name }}
                    </span>
                    <span class="text-sm flex items-center text-gray-500 dark:text-slate-400">
                        <i class="ti ti-star-filled text-amber-400 mr-1"></i>
                        {{ $book->reviews->count() > 0 ? number_format($book->reviews->avg('rating'), 1) : 'Belum ada ulasan' }} 
                        @if($book->reviews->count() > 0)
                            <span class="mx-1">&bull;</span> {{ $book->reviews->count() }} ulasan
                        @endif
                    </span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white heading-font mb-2 leading-tight">{{ $book->title }}</h1>
                <p class="text-xl text-gray-600 dark:text-slate-300 mb-8">Oleh <span class="font-semibold text-gray-900 dark:text-white">{{ $book->author }}</span></p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-gray-50 dark:bg-slate-900/50 p-5 rounded-2xl border border-gray-100 dark:border-slate-700 mb-8">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1">Stok Tersedia</p>
                        <p class="text-lg font-bold {{ $book->available_stock > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-500' }}">{{ $book->available_stock }} <span class="text-sm font-normal text-gray-500 dark:text-slate-400">/ {{ $book->total_stock }}</span></p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1">Tahun Terbit</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $book->published_year ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1">Penerbit</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">{{ $book->publisher ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1">ISBN</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5 break-all">{{ $book->isbn ?: '-' }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Sinopsis</h3>
                    <div class="prose prose-sm sm:prose-base dark:prose-invert text-gray-600 dark:text-gray-300 leading-relaxed max-w-none">
                        @if($book->synopsis)
                            {!! nl2br(e($book->synopsis)) !!}
                        @else
                            <p class="italic text-gray-500">Sinopsis belum tersedia untuk buku ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Books -->
    @if($relatedBooks->count() > 0)
        <div class="mb-10">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white heading-font mb-6">Buku Terkait dalam Kategori Ini</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                @foreach($relatedBooks as $related)
                    <a href="{{ route('member.books.show', $related->slug) }}" class="group block">
                        <div class="aspect-[2/3] w-full rounded-xl bg-gray-100 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 overflow-hidden mb-3 relative shadow-sm group-hover:shadow-md transition-all group-hover:-translate-y-1">
                            @if($related->cover_image)
                                <img src="{{ $related->cover_image_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="ti ti-photo-off text-4xl text-gray-300 dark:text-slate-600"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2 leading-tight mb-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $related->title }}</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1">{{ $related->author }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-member-layout>
