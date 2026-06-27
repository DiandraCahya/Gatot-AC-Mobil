<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;

class BookingApproved extends Mailable
{
    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Booking Anda Disetujui')
                    ->view('mails.booking.Bookingstatus');
    }
}