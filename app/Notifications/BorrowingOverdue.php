<?php

namespace App\Notifications;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowingOverdue extends Notification implements ShouldQueue
{
    use Queueable;

    protected $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $bookTitle = $this->borrowing->book->title;
        $dueDate = \Carbon\Carbon::parse($this->borrowing->due_date)->format('d M Y');

        return (new MailMessage)
            ->subject('Pemberitahuan: Keterlambatan Pengembalian Buku')
            ->error()
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Masa pengembalian buku "' . $bookTitle . '" telah terlampaui.')
            ->line('Tenggat pengembalian adalah: ' . $dueDate)
            ->line('Denda keterlambatan berjalan sebesar Rp 1.000 per hari.')
            ->line('Mohon segera mengembalikan buku ke perpustakaan untuk menghentikan akumulasi denda.')
            ->action('Lihat Detail Denda', route('member.dashboard'))
            ->line('Terima kasih atas kerja samanya.');
    }

    public function toArray($notifiable): array
    {
        return [
            'borrowing_id' => $this->borrowing->id,
            'book_title' => $this->borrowing->book->title,
            'message' => 'Pemberitahuan: Anda terlambat mengembalikan buku "' . $this->borrowing->book->title . '". Denda berjalan Rp 1.000/hari.',
            'due_date' => $this->borrowing->due_date,
            'action_url' => route('member.dashboard'),
        ];
    }
}
