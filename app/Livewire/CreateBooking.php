<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Struk;
use App\Models\Booking;
use Livewire\Component;
use App\Mail\BookingMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateBooking extends Component
{
    protected $listeners = ['CreateBookingModal' => 'openModal'];
    public $showModal = false;
    public $jenis = '';
    public $tanggal = '';
    public $jam = '';
    public $mobil = '';
    public $tempat;
    public $keterangan = '';
    public $jasa = [];

    protected $rules = [
        'jenis' => 'required|string',
        'tanggal' => 'required|date|after_or_equal:today',
        'jam' => 'required|date_format:H:i',
        'mobil' => 'required|string',
        'tempat' => 'required|boolean',
        'keterangan' => 'nullable|string|max:1000'
    ];

    protected $messages = [
        'tanggal.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu',
        'jam.date_format' => 'Format jam tidak valid',
        'jenis.required' => 'Jenis layanan harus dipilih',
        'mobil.required' => 'Jenis mobil harus diisi'
    ];

    public function mount()
    {
        $this->jasa = \App\Models\Jasa::all();
        $this->tanggal = Carbon::today()->format('Y-m-d');
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['jenis', 'tanggal', 'jam', 'mobil', 'tempat', 'keterangan']);
        $this->tanggal = Carbon::today()->format('Y-m-d');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updatedTanggal($value)
    {
        // Validate if selected date is not in the past
        $selectedDate = Carbon::parse($value);
        $today = Carbon::today();

        if ($selectedDate->lt($today)) {
            $this->addError('tanggal', 'Tanggal tidak boleh di masa lalu');
            $this->tanggal = $today->format('Y-m-d');
            return;
        }

        // If there's a time selected, validate the complete datetime
        if ($this->jam) {
            $this->validateDateTime();
        }
    }

    public function updatedJam($value)
    {
        if ($this->tanggal) {
            $this->validateDateTime();
        }
    }

    private function validateDateTime()
    {
        $selectedDateTime = Carbon::parse($this->tanggal . ' ' . $this->jam);
        $now = Carbon::now();

        // If datetime is in the past
        if ($selectedDateTime->lt($now)) {
            $this->addError('jam', 'Waktu yang dipilih sudah lewat');
            return false;
        }

        // Validate business hours (8 AM - 5 PM)
        $hour = (int) explode(':', $this->jam)[0];
        if ($hour < 8 || $hour >= 17) {
            $this->addError('jam', 'Jam operasional kami adalah 08:00 - 17:00');
            return false;
        }

        return true;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // Additional validation for jam based on tanggal
        if ($propertyName === 'jam' && $this->tanggal) {
            $selectedDateTime = Carbon::parse($this->tanggal . ' ' . $this->jam);
            $now = Carbon::now();

            if ($this->tanggal === $now->format('Y-m-d') && $selectedDateTime->isPast()) {
                $this->addError('jam', 'Jam yang dipilih sudah lewat untuk hari ini');
            }
        }

        // Validate business hours (8 AM - 5 PM)
        if ($propertyName === 'jam') {
            $hour = (int) explode(':', $this->jam)[0];
            if ($hour < 8 || $hour >= 17) {
                $this->addError('jam', 'Jam operasional kami adalah 08:00 - 17:00');
            }
        }
    }

    public function store()
    {
        $validatedData = $this->validate();

        //jika jenis bukan cek maka jalankan code di bawah
        if ($validatedData['jenis'] != 'Konsultasi dan Cek Kondisi AC') {
            $unpaidBookings = DB::table('struks')
                ->join('booking', 'struks.booking_id', '=', 'booking.id')
                ->where('booking.user_id', Auth::id())
                ->where('struks.payment_status', 'unpaid')
                ->count();

            if ($unpaidBookings >= 2) {
                session()->flash('error', 'Anda sudah memiliki 2 struk yang belum dibayar');
                return redirect()->back()->withErrors(['payment' => 'Anda sudah memiliki 2 struk yang belum dibayar. Harap selesaikan pembayaran terlebih dahulu.']);
            }
        }

        if (!$this->validateDateTime()) {
            return;
        }

        try {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'nama' => Auth::user()->name,
                'jenis' => $validatedData['jenis'],
                'tanggal' => $validatedData['tanggal'],
                'jam' => $validatedData['jam'],
                'mobil' => $validatedData['mobil'],
                'tempat' => $validatedData['tempat'],
                'keterangan' => $validatedData['keterangan'],
                'status' => 'pending'
            ]);

            // Send email to admin users
            User::where('is_admin', true)->each(function ($admin) use ($booking) {
                Mail::to($admin->email)->send(new BookingMail($booking, 'created'));
            });

            $this->closeModal();
            session()->flash('success', 'Booking berhasil dibuat dan menunggu persetujuan');
            $this->dispatch('booking-stored');

        } catch (\Exception $e) {
            \Log::error('Booking Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            session()->flash('error', 'Terjadi kesalahan saat membuat booking: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.create-booking');
    }
}