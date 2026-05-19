<x-admin-layout>
    <x-slot name="header">
        QR Code: {{ $book->title }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden text-center p-8 print:shadow-none print:border-0 print:p-0">
            
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 print:text-black">{{ $book->title }}</h2>
            <p class="text-gray-500 dark:text-slate-400 mb-8 print:text-gray-800">{{ $book->author }}</p>

            <div class="bg-white p-4 inline-block rounded-xl border border-gray-200 shadow-sm mx-auto mb-8 print:shadow-none print:border">
                {!! QrCode::size(250)->margin(2)->generate(route('books.show', $book->slug)) !!}
            </div>

            <div class="flex justify-center gap-4 print:hidden">
                <a href="{{ route('admin.books.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-offset-slate-900 transition-colors">
                    <i class="ti ti-arrow-left mr-2 -ml-1 text-lg"></i>
                    Kembali
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-offset-slate-900 shadow-amber-500/30 transition-colors">
                    <i class="ti ti-printer mr-2 -ml-1 text-lg"></i>
                    Print QR Code
                </button>
            </div>
        </div>
    </div>
</x-admin-layout>
