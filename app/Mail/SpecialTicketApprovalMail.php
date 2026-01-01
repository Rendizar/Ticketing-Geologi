<?php

namespace App\Mail;

use App\Models\SpecialTicketRequest;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SpecialTicketApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $specialRequest;
    public $booking;
    public $ticketPath;

    /**
     * Create a new message instance.
     */
    public function __construct(SpecialTicketRequest $specialRequest, Booking $booking, $ticketPath)
    {
        $this->specialRequest = $specialRequest;
        $this->booking = $booking;
        $this->ticketPath = $ticketPath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🎉 Permintaan Tiket Khusus Disetujui - Museum Geologi Bandung')
                    ->view('email.special-ticket-approval')
                    ->attach($this->ticketPath, [
                        'as' => 'Tiket-' . $this->booking->booking_id . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
