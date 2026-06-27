<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Struk;
use App\Models\Booking;

class StrukPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $struk;
    public $booking;

    public function __construct(Struk $struk, Booking $booking)
    {
        $this->struk = $struk;
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->view('mails.struk.status')
                    ->with([
                        'status' => 'paid',
                        'statusText' => 'Pembayaran Berhasil'
                    ])
                    ->subject('Konfirmasi Pembayaran Struk');
    }
}