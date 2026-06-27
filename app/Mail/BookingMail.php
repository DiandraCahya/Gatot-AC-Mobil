<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $action;

    public function __construct(Booking $booking, string $action)
    {
        $this->booking = $booking;
        $this->action = $action;
    }

    public function build()
    {
        return $this->subject($this->action === 'created' ? 'Booking Baru Dibuat' : 'Booking Diperbarui')
                    ->view('mails.booking.booking');
    }
}