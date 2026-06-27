<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Tracking;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Tracker extends Component
{
    protected $listeners = ['CreateTracking' => 'openModal'];
    public $showModal = false;

    #[Rule('required|string|min:3', message: 'Nama minimal 3 karakter')]
    public $nama = '';

    #[Rule('required|string|min:3', message: 'Silakan pilih jenis layanan')]
    public $jenis = '';

    #[Rule('required|date|after_or_equal:today', message: 'Tanggal harus diisi dan tidak boleh kurang dari hari ini')]
    public $tanggal = '';

    #[Rule('required|date_format:H:i', message: 'Format jam tidak valid')]
    public $jam = '';

    #[Rule('required|string|min:5', message: 'Detail mobil minimal 5 karakter')]
    public $mobil = '';

    #[Rule('required|boolean', message: 'Silakan pilih lokasi servis')]
    public $tempat;

    #[Rule('nullable|string|min:10|max:1000', message: 'Keterangan minimal 10 karakter')]
    public $keterangan = '';

    public function mount()
    {
        // Set default tanggal to today
        $this->tanggal = Carbon::today()->format('Y-m-d');
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['nama', 'jenis', 'jam', 'mobil', 'tempat', 'keterangan']);
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

    public function save()
    {
        $this->validate();

        if (!$this->validateDateTime()) {
            return;
        }

        try {
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'nama' => $this->nama,
                'jenis' => $this->jenis,
                'tanggal' => $this->tanggal,
                'jam' => $this->jam,
                'mobil' => $this->mobil,
                'tempat' => $this->tempat,
                'keterangan' => $this->keterangan,
                'status' => 'approved'
            ]);

            $this->closeModal();
            $this->dispatch('tracking-created');
            session()->flash('message', 'Tracking berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error("Gagal membuat booking: " . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membuat tracking.');
        }
    }

    public function render()
    {
        return view('livewire.tracker', [
            'jasa' => \App\Models\Jasa::all()
        ]);
    }
}