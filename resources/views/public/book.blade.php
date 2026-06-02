<x-public-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-4">
            <a href="{{ route('books.catalog') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-amber-600 dark:text-slate-400 dark:hover:text-amber-400 transition-colors">
                <i class="ti ti-arrow-left mr-1 text-lg"></i> Kembali ke Katalog
            </a>
        </div>

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

                    <!-- Call To Action for Guest -->
                    <div class="mt-6 p-5 rounded-2xl bg-amber-50 dark:bg-slate-900 border border-amber-200/50 dark:border-slate-700 text-center">
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center mx-auto mb-3">
                            <i class="ti ti-info-circle text-lg"></i>
                        </div>
                        <p class="text-xs font-semibold text-gray-900 dark:text-white mb-2">Ingin meminjam buku ini?</p>
                        <p class="text-[11px] text-gray-500 dark:text-slate-400 mb-4 leading-relaxed">
                            Silakan masuk ke akun Anda atau daftar sebagai anggota baru untuk melakukan peminjaman buku.
                        </p>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-colors shadow-sm">
                                Masuk ke Akun
                            </a>
                            <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-gray-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl transition-colors">
                                Daftar Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded border text-xs font-semibold" style="background-color: {{ $book->category->color ?? '#3B82F6' }}15; color: {{ $book->category->color ?? '#3B82F6' }}; border-color: {{ $book->category->color ?? '#3B82F6' }}30;">
                            {{ $book->category->name ?? 'Umum' }}
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
                        <a href="{{ route('books.show', $related->slug) }}" class="group block">
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
    </div>
</x-public-layout>
