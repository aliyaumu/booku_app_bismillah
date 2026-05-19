<x-admin-layout>
    <x-slot name="header">
        Kelola Buku
    </x-slot>

    <div class="space-y-6">
        <!-- Top Actions & Search -->
        <div class="flex flex-col sm:flex-row justify-between gap-4">
            <div class="flex-1 max-w-md">
                <form action="{{ route('admin.books.index') }}" method="GET" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ti ti-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-sm placeholder-gray-500 focus:ring-amber-500 focus:border-amber-500 dark:text-gray-200 transition-colors shadow-sm" placeholder="Cari judul atau penulis...">
                </form>
            </div>
            <div>
                <a href="{{ route('admin.books.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors dark:focus:ring-offset-slate-900 shadow-amber-500/30">
                    <i class="ti ti-plus mr-2 -ml-1 text-lg"></i>
                    Tambah Buku Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-start shadow-sm">
                <i class="ti ti-check w-5 h-5 mr-3 mt-0.5"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Judul Buku</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Stok (Tersedia/Total)</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                        @forelse($books as $book)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-12 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center overflow-hidden border border-gray-200 dark:border-slate-600 shadow-sm">
                                        @if($book->cover_image)
                                            <img class="h-full w-full object-cover" src="{{ asset('storage/'.$book->cover_image) }}" alt="{{ $book->title }}">
                                        @else
                                            <i class="ti ti-photo-off text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ Str::limit($book->title, 40) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">{{ $book->author }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border" style="background-color: {{ $book->category->color }}15; color: {{ $book->category->color }}; border-color: {{ $book->category->color }}30;">
                                    {{ $book->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-1.5 bg-gray-50 dark:bg-slate-900/50 py-1.5 px-3 rounded-lg border border-gray-100 dark:border-slate-700 w-fit mx-auto">
                                    <span class="text-sm font-bold {{ $book->available_stock > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                        {{ $book->available_stock }}
                                    </span>
                                    <span class="text-gray-300 dark:text-slate-600">/</span>
                                    <span class="text-sm font-medium text-gray-500 dark:text-slate-400">{{ $book->total_stock }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.books.qr', $book->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors" title="QR Code">
                                        <i class="ti ti-qrcode text-xl"></i>
                                    </a>
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-colors" title="Edit">
                                        <i class="ti ti-edit text-xl"></i>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Hapus">
                                            <i class="ti ti-trash text-xl"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-gray-500 dark:text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-50 dark:bg-slate-800/80 rounded-full flex items-center justify-center mb-4 border border-gray-100 dark:border-slate-700">
                                        <i class="ti ti-books text-4xl text-gray-400 dark:text-slate-500"></i>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Tidak ada buku ditemukan</p>
                                    <p class="text-sm">Silakan tambah buku baru atau ubah kata kunci pencarian.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($books->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                {{ $books->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
