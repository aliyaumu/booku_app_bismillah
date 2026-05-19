<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;

class UpdateOverdueStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booku:update-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update borrowings that passed their due date to overdue and calculate fines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->startOfDay();

        // 1. Update status to overdue for borrowings that are borrowed and passed their due_date
        $updatedCount = Borrowing::where('status', 'borrowed')
            ->whereDate('due_date', '<', $today)
            ->update(['status' => 'overdue']);

        $this->info("Updated {$updatedCount} borrowing(s) to overdue status.");

        // 2. Calculate or update fines for all overdue borrowings
        $overdueBorrowings = Borrowing::where('status', 'overdue')
            ->whereNull('returned_date')
            ->get();

        $finesUpdated = 0;
        $finesCreated = 0;

        foreach ($overdueBorrowings as $borrowing) {
            $dueDate = Carbon::parse($borrowing->due_date)->startOfDay();
            $daysLate = (int) abs($today->diffInDays($dueDate));

            if ($daysLate > 0) {
                $amountPerDay = 1000;
                $totalFine = $daysLate * $amountPerDay;

                $fine = Fine::where('borrowing_id', $borrowing->id)->first();

                if ($fine) {
                    if ($fine->status !== 'paid') {
                        $fine->update([
                            'overdue_days' => $daysLate,
                            'total_amount' => $totalFine,
                        ]);
                        $finesUpdated++;
                    }
                } else {
                    Fine::create([
                        'borrowing_id' => $borrowing->id,
                        'user_id' => $borrowing->user_id,
                        'overdue_days' => $daysLate,
                        'amount_per_day' => $amountPerDay,
                        'total_amount' => $totalFine,
                        'status' => 'unpaid',
                    ]);
                    $finesCreated++;
                }
            }
        }

        $this->info("Fines calculation complete: {$finesCreated} created, {$finesUpdated} updated.");
    }
}
