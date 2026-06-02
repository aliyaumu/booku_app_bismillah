<x-member-layout>
    <x-slot name="header">
        Katalog Buku
    </x-slot>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Filter -->
        <div class="w-full md:w-64 shrink-0 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Cari & Filter</h3>
                <form action="{{ route('member.books.index') }}" method="GET" class="space-y-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Kunci</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 text-sm focus:border-amber-500 focus:ring-amber-500 shadow-sm transition-colors" placeholder="Judul atau penulis...">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                        <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            <label class="flex items-center">
                                <input type="radio" name="category" value="" {{ request('category') == '' ? 'checked' : '' }} class="form-radio h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Semua Kategori</span>
                            </label>
                            @foreach($categories as $cat)
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'checked' : '' }} class="form-radio h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $cat->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        Terapkan Filter
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('member.books.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Book Grid -->
        <div class="flex-1 min-w-0">
            @if($books->isEmpty())
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 py-16 px-6 text-center">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-books text-4xl text-gray-400 dark:text-slate-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Buku tidak ditemukan</h3>
                    <p class="text-gray-500 dark:text-slate-400 max-w-sm mx-auto">Kami tidak dapat menemukan buku yang sesuai dengan filter pencarian Anda. Coba kata kunci atau kategori lain.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($books as $book)
                        <div class="group relative flex flex-col bg-white dark:bg-slate-800 rounded-2xl p-3 shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-xl hover:border-amber-200 dark:hover:border-amber-900/50 transition-all duration-300 hover:-translate-y-1">
                            
                            <!-- Wishlist Button -->
                            <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                <form action="{{ route('member.wishlist.toggle', $book->id) }}" method="POST">
                                    @csrf
                                    @php
                                        $inWishlist = Auth::user()->wishlists()->where('book_id', $book->id)->exists();
                                    @endphp
                                    <button type="submit" class="w-8 h-8 rounded-full bg-white/90 dark:bg-slate-800/90 backdrop-blur shadow-md flex items-center justify-center hover:scale-110 transition-transform focus:outline-none" title="Tambah ke Wishlist">
                                        <i class="ti {{ $inWishlist ? 'ti-heart-filled text-rose-500' : 'ti-heart text-gray-600 dark:text-gray-300 hover:text-rose-500 dark:hover:text-rose-400' }}"></i>
                                    </button>
                                </form>
                            </div>

                            <a href="{{ route('member.books.show', $book->slug) }}" class="block flex-1">
                                <div class="aspect-[2/3] w-full rounded-xl bg-gray-100 dark:bg-slate-700 overflow-hidden mb-3 relative">
                                    @if($book->cover_image)
                                        <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="ti ti-photo-off text-4xl text-gray-300 dark:text-slate-500"></i>
                                        </div>
                                    @endif
                                    
                                    @if($book->available_stock < 1)
                                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center backdrop-blur-[2px]">
                                            <span class="px-3 py-1 bg-rose-500 text-white text-xs font-bold rounded-full shadow-sm">Habis</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="px-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold mb-1 border" style="background-color: {{ $book->category->color }}15; color: {{ $book->category->color }}; border-color: {{ $book->category->color }}30;">
                                        {{ $book->category->name }}
                                    </span>
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2 leading-tight mb-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $book->title }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1 mb-2">{{ $book->author }}</p>
                                </div>
                            </a>
                            
                            <div class="px-1 pt-2 pb-1 border-t border-gray-100 dark:border-slate-700/50 flex items-center justify-between">
                                <div class="text-xs text-gray-500 dark:text-slate-400 flex items-center">
                                    <i class="ti ti-star-filled text-amber-400 mr-1 text-[10px]"></i>
                                    {{ $book->reviews()->count() > 0 ? number_format($book->reviews()->avg('rating'), 1) : '-' }}
                                </div>
                                <div class="text-xs {{ $book->available_stock > 0 ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-rose-500' }}">
                                    Stok: {{ $book->available_stock }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($books->hasPages())
                    <div class="mt-8">
                        {{ $books->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-member-layout>
