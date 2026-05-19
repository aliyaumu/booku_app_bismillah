<x-public-layout>
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-slate-900 text-white pt-16 pb-20 lg:pt-24 lg:pb-28">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(245,158,11,0.1),transparent_50%)]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-amber-500/10 to-transparent pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-6">
                        <i class="ti ti-sparkles text-sm animate-pulse"></i> Manajemen Perpustakaan Digital Modern
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black heading-font tracking-tight leading-none">
                        Membaca dan Mengelola Buku <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Lebih Mudah</span>.
                    </h1>
                    <p class="mt-4 text-base sm:text-lg text-slate-300 leading-relaxed">
                        Booku adalah perpustakaan digital terintegrasi yang menghadirkan katalog buku modern, pencatatan otomatis, pelacakan denda, dan QR Code untuk pengalaman membaca tanpa hambatan.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4 sm:justify-center lg:justify-start">
                        <a href="{{ route('books.catalog') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-semibold text-slate-950 bg-amber-500 hover:bg-amber-400 rounded-xl transition-all shadow-lg shadow-amber-500/20 hover:-translate-y-0.5">
                            Telusuri Katalog <i class="ti ti-arrow-narrow-right ml-2 text-lg"></i>
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-semibold text-white bg-slate-800 hover:bg-slate-700 rounded-xl transition-all border border-slate-700 hover:-translate-y-0.5">
                                Gabung Jadi Anggota
                            </a>
                        @endguest
                    </div>
                </div>
                
                <!-- Hero Stats / Cards Side -->
                <div class="mt-12 lg:mt-0 lg:col-span-6">
                    <div class="grid grid-cols-2 gap-4 max-w-lg mx-auto lg:max-w-none">
                        <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 flex flex-col justify-between hover:border-amber-500/30 transition-all hover:translate-y-[-4px]">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-4">
                                <i class="ti ti-books text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-3xl font-black heading-font tracking-tight">{{ number_format($totalBooks) }}</p>
                                <p class="text-sm text-slate-400">Total Koleksi Buku</p>
                            </div>
                        </div>

                        <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 flex flex-col justify-between hover:border-amber-500/30 transition-all hover:translate-y-[-4px] mt-4 sm:mt-0">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-4">
                                <i class="ti ti-users text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-3xl font-black heading-font tracking-tight">{{ number_format($totalMembers) }}</p>
                                <p class="text-sm text-slate-400">Anggota Terdaftar</p>
                            </div>
                        </div>

                        <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 flex flex-col justify-between hover:border-amber-500/30 transition-all hover:translate-y-[-4px] col-span-2">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center">
                                    <i class="ti ti-rotate text-2xl"></i>
                                </div>
                                <span class="text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-full">Realtime</span>
                            </div>
                            <div>
                                <p class="text-3xl font-black heading-font tracking-tight">{{ number_format($totalBorrowings) }}</p>
                                <p class="text-sm text-slate-400">Transaksi Sirkulasi Buku</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Books Section -->
    <div class="bg-white dark:bg-slate-900 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-black heading-font text-gray-900 dark:text-white">Buku Baru Terpopuler</h2>
                    <p class="mt-2 text-slate-500 dark:text-slate-400">Koleksi buku terbaru yang siap dipinjam hari ini.</p>
                </div>
                <a href="{{ route('books.catalog') }}" class="mt-4 md:mt-0 inline-flex items-center gap-1 text-sm font-bold text-amber-600 dark:text-amber-500 hover:text-amber-700 dark:hover:text-amber-400 transition-colors">
                    Lihat Semua Buku <i class="ti ti-arrow-narrow-right text-base"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4">
                @forelse($featuredBooks as $book)
                    <a href="{{ route('books.show', $book->slug) }}" class="group block bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700/50 rounded-2xl p-3 hover:shadow-xl hover:shadow-gray-200/50 dark:hover:shadow-none hover:border-amber-500/30 transition-all hover:-translate-y-1">
                        <!-- Cover Wrapper -->
                        <div class="aspect-[3/4] bg-gray-100 dark:bg-slate-700 rounded-xl overflow-hidden mb-3 relative">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/'.$book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-slate-500 gap-1">
                                    <i class="ti ti-book text-3xl"></i>
                                    <span class="text-[10px]">No Cover</span>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold text-white shrink-0 shadow-sm" style="background-color: {{ $book->category->color ?? '#3B82F6' }}">
                                    {{ $book->category->name ?? 'Umum' }}
                                </span>
                            </div>
                        </div>
                        <!-- Book Meta -->
                        <h3 class="text-xs font-bold text-gray-900 dark:text-white line-clamp-2 leading-snug group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $book->title }}</h3>
                        <p class="text-[10px] text-gray-500 dark:text-slate-400 truncate mt-1">{{ $book->author }}</p>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="ti ti-book-off text-4xl text-gray-300 dark:text-slate-600 mb-3"></i>
                        <p class="text-sm text-gray-500 dark:text-slate-400">Belum ada buku terdaftar dalam katalog.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- App Features Section -->
    <div class="bg-gray-50 dark:bg-slate-800/40 py-20 border-y border-gray-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-black heading-font text-gray-900 dark:text-white">Mengapa Memilih Booku?</h2>
                <p class="mt-2 text-slate-500 dark:text-slate-400">Fitur unggulan untuk menunjang produktivitas dan kepuasan pembaca maupun admin.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700/50 rounded-3xl p-8 hover:shadow-lg hover:border-amber-500/30 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center mb-6">
                        <i class="ti ti-qrcode text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">QR Code Integrasi</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 leading-relaxed">
                        Setiap buku dilengkapi dengan QR Code unik yang dapat dicetak dan dipindai untuk menuju halaman detail buku secara instan.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700/50 rounded-3xl p-8 hover:shadow-lg hover:border-amber-500/30 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center mb-6">
                        <i class="ti ti-search text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Realtime Search</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 leading-relaxed">
                        Temukan judul, kategori, atau penulis buku favorit dengan mudah menggunakan fitur pencarian responsif yang cepat.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700/50 rounded-3xl p-8 hover:shadow-lg hover:border-amber-500/30 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center mb-6">
                        <i class="ti ti-bell-ringing text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Notifikasi Overdue Otomatis</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 leading-relaxed">
                        Sistem pelacakan denda keterlambatan berjalan secara otomatis dengan pemberitahuan badge pada dashboard pengguna.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-white dark:bg-slate-900 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-black heading-font text-gray-900 dark:text-white">Alur Peminjaman Buku</h2>
                <p class="mt-2 text-slate-500 dark:text-slate-400">Hanya perlu 3 langkah mudah untuk mulai membaca buku favorit Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Step 1 -->
                <div class="text-center flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-slate-900 dark:bg-amber-500 text-white font-bold flex items-center justify-center text-xl shadow-lg mb-6 relative">
                        1
                        <div class="hidden md:block absolute top-1/2 left-full w-full h-[2px] bg-gray-200 dark:bg-slate-800 -translate-y-1/2 z-[-1]"></div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Registrasi / Login</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 max-w-xs">
                        Buat akun anggota baru atau masuk menggunakan akun terdaftar di sistem perpustakaan.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-slate-900 dark:bg-amber-500 text-white font-bold flex items-center justify-center text-xl shadow-lg mb-6 relative">
                        2
                        <div class="hidden md:block absolute top-1/2 left-full w-full h-[2px] bg-gray-200 dark:bg-slate-800 -translate-y-1/2 z-[-1]"></div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Pilih & Ajukan</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 max-w-xs">
                        Cari buku di katalog, lalu klik pinjam. Admin akan memverifikasi permintaan peminjaman Anda.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-slate-900 dark:bg-amber-500 text-white font-bold flex items-center justify-center text-xl shadow-lg mb-6">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Ambil & Baca</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 max-w-xs">
                        Setelah disetujui, ambil buku di perpustakaan fisik dan nikmati bacaan Anda dengan aman.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
