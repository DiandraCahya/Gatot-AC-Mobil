<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EditBooking extends Component
{
    protected $listeners = ['EditBookingModal' => 'openModal'];

    public $showModal = false;
    public $booking;
    public $jenis = '';
    public $tanggal = '';
    public $jam = '';
    public $mobil = '';
    public $tempat = '';
    public $keterangan = '';

    protected function rules()
    {
        return [
            'jenis' => 'required|string|min:3',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required|date_format:H:i',
            'mobil' => 'required|string|min:3',
            'tempat' => 'boolean',
            'keterangan' => 'nullable|string|max:1000'
        ];
    }

    protected $messages = [
        'jenis.required' => 'Jenis layanan harus diisi',
        'jenis.min' => 'Jenis layanan minimal 3 karakter',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini',
        'jam.required' => 'Jam harus diisi',
        'jam.date_format' => 'Format jam tidak valid',
        'mobil.required' => 'Model mobil harus diisi',
        'mobil.min' => 'Model mobil minimal 3 karakter',
        'keterangan.max' => 'Keterangan maksimal 1000 karakter'
    ];

    public function mount()
    {
        // Set default tanggal to today if not editing
        if (!$this->tanggal) {
            $this->tanggal = Carbon::today()->format('Y-m-d');
        }
    }

    public function openModal($bookingId)
    {
        $this->booking = Booking::find($bookingId);

        if (!$this->booking) {
            $this->dispatch('error', message: 'Booking tidak ditemukan');
            return;
        }

        if (!Auth::user()->is_admin && Auth::id() !== $this->booking->user_id) {
            $this->dispatch('error', message: 'Akses ditolak');
            return;
        }

        if ($this->booking->status !== 'pending') {
            $this->dispatch('error', message: 'Booking tidak dapat diubah setelah diproses');
            return;
        }

        $this->jenis = $this->booking->jenis;
        $this->tanggal = $this->booking->tanggal;
        $this->jam = date('H:i', strtotime($this->booking->jam));
        $this->mobil = $this->booking->mobil;
        $this->tempat = $this->booking->tempat;
        $this->keterangan = $this->booking->keterangan;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['jenis', 'tanggal', 'jam', 'mobil', 'tempat', 'keterangan']);
        $this->resetValidation();
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

    public function updateBooking()
    {
        if (!Auth::user()->is_admin && Auth::id() !== $this->booking->user_id) {
            $this->dispatch('error', message: 'Akses ditolak');
            return;
        }

        if ($this->booking->status !== 'pending') {
            $this->dispatch('error', message: 'Booking tidak dapat diubah setelah diproses');
            return;
        }

        try {
            $validatedData = $this->validate();

            if (!$this->validateDateTime()) {
                return;
            }

            $this->booking->update([
                'jenis' => $this->jenis,
                'tanggal' => $this->tanggal,
                'jam' => $this->jam,
                'mobil' => $this->mobil,
                'tempat' => $this->tempat,
                'keterangan' => $this->keterangan
            ]);

            $this->dispatch('success', message: 'Booking berhasil diperbarui');
            $this->closeModal();
            $this->dispatch('booking-updated');
        } catch (\Exception $e) {
            \Log::error('Booking Update Error: ' . $e->getMessage());
            $this->dispatch('error', message: 'Terjadi kesalahan saat memperbarui booking');
        }
    }

    public function render()
    {
        return view('livewire.edit-booking');
    }
}
