<x-admin-layout>
    <x-slot name="header">
        Laporan Statistik
    </x-slot>

    <div class="space-y-6">
        <!-- Chart Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Peminjaman per Bulan ({{ date('Y') }})</h3>
            <div class="relative h-72 w-full">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Popular Books -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-bold text-gray-900 dark:text-white">Buku Terpopuler</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-slate-700 p-4 space-y-3">
                    @forelse($popularBooks as $index => $item)
                        <div class="flex items-center gap-4 p-2 hover:bg-gray-50 dark:hover:bg-slate-700/50 rounded-xl transition-colors">
                            <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 font-bold flex items-center justify-center shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div class="w-10 h-14 bg-gray-100 dark:bg-slate-700 rounded overflow-hidden shrink-0">
                                @if($item->book->cover_image)
                                    <img src="{{ asset('storage/'.$item->book->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><i class="ti ti-book text-gray-400"></i></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $item->book->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400 truncate">{{ $item->book->author }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->total }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">pinjaman</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 dark:text-slate-400 text-sm">
                            Belum ada data peminjaman buku.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Active Members -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-bold text-gray-900 dark:text-white">Anggota Teraktif</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-slate-700 p-4 space-y-3">
                    @forelse($activeMembers as $index => $item)
                        <div class="flex items-center gap-4 p-2 hover:bg-gray-50 dark:hover:bg-slate-700/50 rounded-xl transition-colors">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 font-bold flex items-center justify-center shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div class="w-10 h-10 rounded-full border border-gray-200 dark:border-slate-600 shrink-0 overflow-hidden">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&color=4F46E5&background=EEF2FF" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $item->user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400 truncate">{{ $item->user->student_id ?: '-' }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->total }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400">transaksi</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 dark:text-slate-400 text-sm">
                            Belum ada data aktivitas anggota.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#94a3b8' : '#64748b';
            const gridColor = isDark ? '#334155' : '#f1f5f9';
            
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyData = @json($monthlyData);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Total Peminjaman',
                        data: monthlyData,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: isDark ? '#1e293b' : '#ffffff',
                            titleColor: isDark ? '#ffffff' : '#0f172a',
                            bodyColor: isDark ? '#cbd5e1' : '#475569',
                            borderColor: isDark ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 4,
                            usePointStyle: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: textColor,
                                stepSize: 1,
                                precision: 0
                            },
                            grid: {
                                color: gridColor,
                                drawBorder: false,
                            }
                        },
                        x: {
                            ticks: {
                                color: textColor
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
</x-admin-layout>
