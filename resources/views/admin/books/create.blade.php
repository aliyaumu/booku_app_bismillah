<x-admin-layout>
    <x-slot name="header">
        Tambah Buku Baru
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            @csrf
            
            <div class="p-6 sm:p-8 space-y-8">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-600 dark:text-rose-400">
                        <div class="flex items-start">
                            <i class="ti ti-alert-circle w-5 h-5 mr-3 mt-0.5"></i>
                            <div>
                                <h3 class="text-sm font-semibold">Terdapat kesalahan pengisian form:</h3>
                                <ul class="mt-2 text-sm list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Judul -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Judul Buku <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                        <select id="category_id" name="category_id" required class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Penulis -->
                    <div>
                        <label for="author" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Penulis <span class="text-rose-500">*</span></label>
                        <input type="text" name="author" id="author" value="{{ old('author') }}" required class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label for="publisher" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Penerbit</label>
                        <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">ISBN</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label for="published_year" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tahun Terbit</label>
                        <input type="number" name="published_year" id="published_year" value="{{ old('published_year') }}" min="1000" max="{{ date('Y') + 1 }}" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- Total Stok -->
                    <div>
                        <label for="total_stock" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Total Stok <span class="text-rose-500">*</span></label>
                        <input type="number" name="total_stock" id="total_stock" value="{{ old('total_stock', 1) }}" min="1" required class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-slate-400">Jumlah fisik buku yang dimiliki perpustakaan.</p>
                    </div>

                    <!-- Sinopsis -->
                    <div class="md:col-span-2">
                        <label for="synopsis" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Sinopsis</label>
                        <textarea id="synopsis" name="synopsis" rows="4" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">{{ old('synopsis') }}</textarea>
                    </div>

                    <!-- Cover Image URL -->
                    <div class="md:col-span-2">
                        <label for="cover_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Cover URL (Opsional)</label>
                        <input type="url" name="cover_url" id="cover_url" value="{{ old('cover_url') }}" placeholder="https://contoh.com/gambar.jpg" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-slate-400">Masukkan link gambar jika tidak ingin mengupload manual. Upload manual akan diprioritaskan.</p>
                    </div>

                    <!-- Cover Image -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Cover Buku</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-slate-600 border-dashed rounded-xl bg-gray-50 dark:bg-slate-900/50 hover:bg-gray-100 dark:hover:bg-slate-900 transition-colors group">
                            <div class="space-y-1 text-center">
                                <i class="ti ti-photo text-4xl text-gray-400 dark:text-slate-500 group-hover:text-amber-500 transition-colors"></i>
                                <div class="flex text-sm text-gray-600 dark:text-slate-400 justify-center">
                                    <label for="cover_image" class="relative cursor-pointer rounded-md font-medium text-amber-600 dark:text-amber-500 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500 dark:focus-within:ring-offset-slate-900">
                                        <span>Upload file</span>
                                        <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-slate-500">
                                    PNG, JPG, JPEG up to 2MB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 dark:bg-slate-800/50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.books.index') }}" class="inline-flex items-center px-4 py-2.5 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-offset-slate-900 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-offset-slate-900 shadow-amber-500/30 transition-colors">
                    <i class="ti ti-device-floppy mr-2 -ml-1 text-lg"></i>
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
