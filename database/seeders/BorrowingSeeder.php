<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BorrowingSeeder extends Seeder
{
    public function run(): void
    {
        $members = User::where('role', 'member')->get();
        $books = Book::all();

        if ($members->count() < 5 || $books->count() < 10) {
            return;
        }

        // Data Peminjaman Sample
        $data = [
            // 1. Pending (User Budi, Buku Clean Code)
            [
                'user_index' => 0,
                'book_index' => 0,
                'status' => 'pending',
                'duration_days' => 7,
                'borrowed_date' => null,
                'due_date' => null,
                'returned_date' => null,
            ],
            // 2. Pending (User Siti, Buku Sapiens)
            [
                'user_index' => 1,
                'book_index' => 2,
                'status' => 'pending',
                'duration_days' => 7,
                'borrowed_date' => null,
                'due_date' => null,
                'returned_date' => null,
            ],
            // 3. Approved (User Ahmad, Buku Bumi Manusia)
            [
                'user_index' => 2,
                'book_index' => 3,
                'status' => 'approved',
                'duration_days' => 7,
                'borrowed_date' => Carbon::now()->toDateString(),
                'due_date' => Carbon::now()->addDays(7)->toDateString(),
                'returned_date' => null,
                'admin_note' => 'Silakan ambil buku di loket utama perpustakaan.',
            ],
            // 4. Borrowed - Sedang dipinjam (User Dewi, Buku Laskar Pelangi)
            [
                'user_index' => 3,
                'book_index' => 5,
                'status' => 'borrowed',
                'duration_days' => 7,
                'borrowed_date' => Carbon::now()->subDays(3)->toDateString(),
                'due_date' => Carbon::now()->addDays(4)->toDateString(),
                'returned_date' => null,
                'admin_note' => 'Buku diserahkan dalam kondisi baik.',
            ],
            // 5. Borrowed - Sedang dipinjam (User Rian, Buku Cosmos)
            [
                'user_index' => 4,
                'book_index' => 7,
                'status' => 'borrowed',
                'duration_days' => 7,
                'borrowed_date' => Carbon::now()->subDays(5)->toDateString(),
                'due_date' => Carbon::now()->addDays(2)->toDateString(),
                'returned_date' => null,
            ],
            // 6. Overdue - Telat (User Budi, Buku Atomic Habits)
            [
                'user_index' => 0,
                'book_index' => 10,
                'status' => 'overdue',
                'duration_days' => 7,
                'borrowed_date' => Carbon::now()->subDays(12)->toDateString(),
                'due_date' => Carbon::now()->subDays(5)->toDateString(), // Jatuh tempo 5 hari lalu
                'returned_date' => null,
            ],
            // 7. Overdue - Telat (User Siti, Buku Steve Jobs)
            [
                'user_index' => 1,
                'book_index' => 8,
                'status' => 'overdue',
                'duration_days' => 7,
                'borrowed_date' => Carbon::now()->subDays(15)->toDateString(),
                'due_date' => Carbon::now()->subDays(8)->toDateString(), // Jatuh tempo 8 hari lalu
                'returned_date' => null,
            ],
            // 8. Return Requested - Ajukan pengembalian (User Ahmad, Buku Detective Conan)
            [
                'user_index' => 2,
                'book_index' => 12,
                'status' => 'return_requested',
                'duration_days' => 7,
                'borrowed_date' => Carbon::now()->subDays(6)->toDateString(),
                'due_date' => Carbon::now()->addDays(1)->toDateString(),
                'returned_date' => null,
            ],
            // 9. Returned - Sudah kembali (User Dewi, Buku Thinking Fast and Slow)
            [
                'user_index' => 3,
                'book_index' => 11,
                'status' => 'returned',
                'duration_days' => 7,
                'borrowed_date' => Carbon::now()->subDays(8)->toDateString(),
                'due_date' => Carbon::now()->subDays(1)->toDateString(),
                'returned_date' => Carbon::now()->subDays(1)->toDateString(),
                'admin_note' => 'Buku dipinjam tanggal ' . Carbon::now()->subDays(8)->toDateString(),
                'return_note' => 'Kembali lengkap dan mulus.',
            ],
            // 10. Returned - Sudah kembali lewat jatuh tempo & denda lunas (User Rian, Buku La Tahzan)
            [
                'user_index' => 4,
                'book_index' => 13,
                'status' => 'returned',
                'duration_days' => 7,
                'borrowed_date' => Carbon::now()->subDays(15)->toDateString(),
                'due_date' => Carbon::now()->subDays(8)->toDateString(),
                'returned_date' => Carbon::now()->subDays(4)->toDateString(), // Telat 4 hari
                'admin_note' => 'Buku diserahkan.',
                'return_note' => 'Ada coretan sedikit di cover belakang.',
                'fine' => [
                    'overdue_days' => 4,
                    'amount_per_day' => 1000,
                    'total_amount' => 4000,
                    'status' => 'paid',
                    'paid_at' => Carbon::now()->subDays(4)->toDateTimeString(),
                    'note' => 'Denda keterlambatan 4 hari dibayar lunas via kasir.',
                ]
            ],
        ];

        foreach ($data as $item) {
            $user = $members[$item['user_index']];
            $book = $books[$item['book_index']];

            $borrowing = Borrowing::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrowed_date' => $item['borrowed_date'],
                'due_date' => $item['due_date'],
                'returned_date' => $item['returned_date'],
                'duration_days' => $item['duration_days'],
                'status' => $item['status'],
                'admin_note' => $item['admin_note'] ?? null,
                'return_note' => $item['return_note'] ?? null,
            ]);

            // update stok buku jika status aktif (approved, borrowed, overdue, return_requested)
            if (in_array($item['status'], ['approved', 'borrowed', 'overdue', 'return_requested'])) {
                $book->decrement('available_stock');
            }

            // Jika ada denda (seperti peminjaman ke-10 yang sudah kembali tapi telat)
            if (isset($item['fine'])) {
                Fine::create([
                    'borrowing_id' => $borrowing->id,
                    'user_id' => $user->id,
                    'overdue_days' => $item['fine']['overdue_days'],
                    'amount_per_day' => $item['fine']['amount_per_day'],
                    'total_amount' => $item['fine']['total_amount'],
                    'status' => $item['fine']['status'],
                    'paid_at' => $item['fine']['paid_at'],
                    'note' => $item['fine']['note'],
                ]);
            }

            // Jika statusnya overdue aktif, buat denda yang belum dibayar (unpaid)
            if ($item['status'] === 'overdue') {
                // hitung selisih hari dari due_date ke hari ini
                $dueDate = Carbon::parse($item['due_date']);
                $overdueDays = Carbon::now()->diffInDays($dueDate);
                if ($overdueDays > 0) {
                    Fine::create([
                        'borrowing_id' => $borrowing->id,
                        'user_id' => $user->id,
                        'overdue_days' => $overdueDays,
                        'amount_per_day' => 1000,
                        'total_amount' => $overdueDays * 1000,
                        'status' => 'unpaid',
                        'note' => 'Denda otomatis terhitung seeder.',
                    ]);
                }
            }
        }
    }
}
