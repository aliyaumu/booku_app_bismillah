<x-member-layout>
    <x-slot name="header">
        Wishlist Buku Saya
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-400 flex items-start shadow-sm">
                <i class="ti ti-check w-5 h-5 mr-3 mt-0.5"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($wishlists->isEmpty())
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 py-16 px-6 text-center">
                <div class="w-20 h-20 bg-gray-50 dark:bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ti ti-heart text-4xl text-gray-400 dark:text-slate-500"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Wishlist masih kosong</h3>
                <p class="text-gray-500 dark:text-slate-400 max-w-sm mx-auto mb-6">Anda belum menambahkan buku apapun ke dalam wishlist. Jelajahi katalog dan simpan buku yang ingin Anda baca nanti.</p>
                <a href="{{ route('member.books.index') }}" class="inline-flex items-center px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl transition-colors shadow-sm shadow-amber-500/30">
                    Mulai Jelajahi
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($wishlists as $wishlist)
                    <div class="group relative flex flex-col bg-white dark:bg-slate-800 rounded-2xl p-3 shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-xl hover:border-amber-200 dark:hover:border-amber-900/50 transition-all duration-300 hover:-translate-y-1">
                        
                        <!-- Remove from Wishlist Button -->
                        <div class="absolute top-4 right-4 z-10">
                            <form action="{{ route('member.wishlist.toggle', $wishlist->book_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-full bg-white/90 dark:bg-slate-800/90 backdrop-blur shadow-md flex items-center justify-center hover:scale-110 transition-transform focus:outline-none" title="Hapus dari Wishlist">
                                    <i class="ti ti-heart-filled text-rose-500 hover:text-rose-600"></i>
                                </button>
                            </form>
                        </div>

                        <a href="{{ route('member.books.show', $wishlist->book->slug) }}" class="block flex-1">
                            <div class="aspect-[2/3] w-full rounded-xl bg-gray-100 dark:bg-slate-700 overflow-hidden mb-3 relative">
                                @if($wishlist->book->cover_image)
                                    <img src="{{ asset('storage/'.$wishlist->book->cover_image) }}" alt="{{ $wishlist->book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="ti ti-photo-off text-4xl text-gray-300 dark:text-slate-500"></i>
                                    </div>
                                @endif
                                
                                @if($wishlist->book->available_stock < 1)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center backdrop-blur-[2px]">
                                        <span class="px-3 py-1 bg-rose-500 text-white text-xs font-bold rounded-full shadow-sm">Habis</span>
                                    </div>
                                @endif
                            </div>
                            <div class="px-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold mb-1 border" style="background-color: {{ $wishlist->book->category->color }}15; color: {{ $wishlist->book->category->color }}; border-color: {{ $wishlist->book->category->color }}30;">
                                    {{ $wishlist->book->category->name }}
                                </span>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2 leading-tight mb-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $wishlist->book->title }}</h3>
                                <p class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1 mb-2">{{ $wishlist->book->author }}</p>
                            </div>
                        </a>
                        
                        <div class="px-1 pt-2 pb-1 border-t border-gray-100 dark:border-slate-700/50 flex items-center justify-between mt-auto">
                            <div class="text-xs text-gray-500 dark:text-slate-400 flex items-center">
                                <i class="ti ti-star-filled text-amber-400 mr-1 text-[10px]"></i>
                                {{ $wishlist->book->reviews()->count() > 0 ? number_format($wishlist->book->reviews()->avg('rating'), 1) : '-' }}
                            </div>
                            <div class="text-xs {{ $wishlist->book->available_stock > 0 ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-rose-500' }}">
                                Stok: {{ $wishlist->book->available_stock }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($wishlists->hasPages())
                <div class="mt-8">
                    {{ $wishlists->links() }}
                </div>
            @endif
        @endif
    </div>
</x-member-layout>
