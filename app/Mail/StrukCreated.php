<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Struk;
use App\Models\Booking;

class StrukCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $struk;
    public $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Struk $struk, Booking $booking)
    {
        $this->struk = $struk;
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.struk.created')
                    ->subject('Struk Pembayaran Telah Dibuat');
    }
}