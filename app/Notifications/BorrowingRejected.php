<?php

namespace App\Notifications;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowingRejected extends Notification implements ShouldQueue
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

        return (new MailMessage)
            ->subject('Permintaan Peminjaman Buku Ditolak')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Mohon maaf, permintaan Anda untuk meminjam buku "' . $bookTitle . '" ditolak.')
            ->line('Silakan hubungi petugas perpustakaan jika ada pertanyaan atau ajukan peminjaman buku lainnya.')
            ->action('Cari Buku Lain', route('member.books.index'))
            ->line('Terima kasih atas pengertian Anda.');
    }

    public function toArray($notifiable): array
    {
        return [
            'borrowing_id' => $this->borrowing->id,
            'book_title' => $this->borrowing->book->title,
            'message' => 'Permintaan pinjam buku "' . $this->borrowing->book->title . '" ditolak.',
            'action_url' => route('member.books.index'),
        ];
    }
}
