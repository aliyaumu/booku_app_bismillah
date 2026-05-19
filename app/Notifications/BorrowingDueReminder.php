<?php

namespace App\Notifications;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowingDueReminder extends Notification implements ShouldQueue
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
            ->subject('Pengingat: Tenggat Pengembalian Buku Besok')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Ini adalah pengingat bahwa masa pinjam buku "' . $bookTitle . '" akan habis besok.')
            ->line('Tenggat pengembalian: ' . $dueDate)
            ->line('Silakan segera mengembalikan buku ke perpustakaan untuk menghindari denda keterlambatan.')
            ->action('Lihat Buku Saya', route('member.borrowings.index'))
            ->line('Terima kasih telah menggunakan Booku!');
    }

    public function toArray($notifiable): array
    {
        return [
            'borrowing_id' => $this->borrowing->id,
            'book_title' => $this->borrowing->book->title,
            'message' => 'Pengingat: Tenggat pinjam buku "' . $this->borrowing->book->title . '" akan habis besok (' . \Carbon\Carbon::parse($this->borrowing->due_date)->format('d M Y') . ').',
            'due_date' => $this->borrowing->due_date,
            'action_url' => route('member.borrowings.index'),
        ];
    }
}
