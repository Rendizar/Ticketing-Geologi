<?php

namespace App\Mail;

use App\Models\SpecialTicketRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SpecialTicketRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $specialRequest;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(SpecialTicketRequest $specialRequest)
    {
        $this->specialRequest = $specialRequest;
        $this->reason = $specialRequest->admin_note;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Permintaan Tiket Khusus Ditolak - Museum Geologi Bandung')
                    ->view('email.special-ticket-rejection');
    }
}
