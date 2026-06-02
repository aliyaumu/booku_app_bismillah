<x-admin-layout>
    <x-slot name="header">
        Detail Buku
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden p-6 sm:p-8">
            <div class="flex flex-col md:flex-row gap-8">
                
                <!-- Cover Image -->
                <div class="flex-shrink-0 w-full md:w-64 flex flex-col items-center">
                    <div class="w-48 md:w-full aspect-[2/3] bg-gray-100 dark:bg-slate-700 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-slate-600 mb-4 flex items-center justify-center">
                        @if($book->cover_image)
                            <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <i class="ti ti-photo-off text-6xl text-gray-300 dark:text-slate-500"></i>
                        @endif
                    </div>
                    <div class="flex flex-col w-full gap-2">
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="flex items-center justify-center w-full px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors text-center">
                            <i class="ti ti-edit mr-2 text-lg"></i> Edit Buku
                        </a>
                        <a href="{{ route('admin.books.qr', $book->id) }}" class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                            <i class="ti ti-qrcode mr-2 text-lg"></i> QR Code
                        </a>
                    </div>
                </div>

                <!-- Book Details -->
                <div class="flex-1 space-y-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border" style="background-color: {{ $book->category->color }}15; color: {{ $book->category->color }}; border-color: {{ $book->category->color }}30;">
                                {{ $book->category->name }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-slate-400">Ditambahkan pada {{ $book->created_at->format('d M Y') }}</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white heading-font">{{ $book->title }}</h1>
                        <p class="text-lg text-gray-600 dark:text-slate-300 mt-1">{{ $book->author }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-slate-900/50 p-4 rounded-xl border border-gray-100 dark:border-slate-700">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Penerbit</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $book->publisher ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tahun Terbit</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $book->published_year ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">ISBN</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $book->isbn ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Dipinjam</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $book->borrow_count }} kali</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-2">Status Stok</p>
                        <div class="flex items-center gap-4">
                            <div class="flex-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-3 text-center shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-slate-400 mb-1">Tersedia</p>
                                <p class="text-2xl font-bold {{ $book->available_stock > 0 ? 'text-emerald-500' : 'text-rose-500' }}">{{ $book->available_stock }}</p>
                            </div>
                            <div class="flex-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-3 text-center shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-slate-400 mb-1">Total</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $book->total_stock }}</p>
                            </div>
                        </div>
                    </div>

                    @if($book->synopsis)
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-2">Sinopsis</p>
                            <div class="prose prose-sm dark:prose-invert text-gray-700 dark:text-gray-300">
                                {{ $book->synopsis }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end">
                <a href="{{ route('admin.books.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                    <i class="ti ti-arrow-left mr-2 text-lg"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
