<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Livewire\WithPagination;

class BookingTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $date = '';
    public $jenis = '';
    public $payment_status = '';
    public $booking_status = '';
    public $sortBy = 'terbaru';

    // Add queryString to persist filters in URL but prevent page refresh
    protected $queryString = [
        'search' => ['except' => ''],
        'date' => ['except' => ''],
        'jenis' => ['except' => ''],
        'payment_status' => ['except' => ''],
        'booking_status' => ['except' => ''],
        'sortBy' => ['except' => 'terbaru'],
    ];

    protected function getListeners()
    {
        return [
            'filterChanged' => 'resetPage',
            'tracking-created' => '$refresh',
            'strukCreated' => '$refresh',
            'strukUpdated' => '$refresh',
        ];
    }

    // Use wire:model.live.debounce for search to prevent immediate updates
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDate()
    {
        $this->resetPage();
    }

    public function updatedJenis()
    {
        $this->resetPage();
    }

    public function updatedPaymentStatus()
    {
        $this->resetPage();
    }

    public function updatedBookingStatus()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'date', 'jenis', 'payment_status', 'booking_status', 'sortBy']);
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'vendor.livewire.custom-pagination';
    }

    public function render()
    {
        $bookings = Booking::with(['user', 'struk'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    })
                        ->orWhere('mobil', 'like', "%{$this->search}%")
                        ->orWhere('jenis', 'like', "%{$this->search}%");
                });
            })
            ->when($this->date, function ($query) {
                $query->whereDate('tanggal', $this->date);
            })
            ->when($this->jenis, function ($query) {
                $query->where('jenis', $this->jenis);
            })
            ->when($this->booking_status, function ($query) {
                $query->where('status', $this->booking_status);
            })
            ->when($this->payment_status, function ($query) {
                $query->whereHas('struk', function ($q) {
                    $q->where('payment_status', $this->payment_status);
                });
            })
            ->when($this->sortBy, function ($query) {
                switch ($this->sortBy) {
                    case 'terlama':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'mobil_asc':
                        $query->orderBy('mobil', 'asc');
                        break;
                    case 'mobil_desc':
                        $query->orderBy('mobil', 'desc');
                        break;
                    default:
                        $query->orderBy('created_at', 'desc');
                }
            })
            ->paginate(5);

        return view('livewire.booking-table', [
            'bookings' => $bookings
        ]);
    }
}