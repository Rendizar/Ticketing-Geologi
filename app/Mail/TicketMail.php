<?php
// app/Mail/TicketMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $pdfPath;

    public function __construct($booking, $pdfPath)
    {
        $this->booking = $booking;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Tiket Kunjungan Museum Geologi Bandung')
                    ->view('email.ticket-notification')
                    ->attach($this->pdfPath, [
                        'as' => 'Tiket_' . $this->booking->booking_id . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}