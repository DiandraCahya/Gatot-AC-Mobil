<?php

namespace App\Livewire;

use App\Models\Struk;
use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EditStruk extends Component
{
    public $showModal = false;
    public $booking;
    public $struk;
    public $items = [];
    public $description = '';
    public $payment_status = 'unpaid';
    public $is_garansi = false;
    public $garansi_date;
    public $garansi_desc;
    public $strukId;

    protected $listeners = ['editStrukModal' => 'showEditStrukModal'];

    protected $rules = [
        'items.*.name' => 'required|string|min:3',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.price' => 'required|numeric|min:0',
        'description' => 'required|string|min:10',
        'payment_status' => 'required|in:paid,unpaid,cek',
        'garansi_date' => 'required_if:is_garansi,true|date|after:today|nullable',
        'garansi_desc' => 'required_if:is_garansi,true|string|min:10|nullable',
    ];

    protected $validationAttributes = [
        'items.*.name' => 'nama item',
        'items.*.quantity' => 'jumlah',
        'items.*.unit_price' => 'harga satuan',
        'items.*.price' => 'total harga',
        'description' => 'deskripsi',
        'payment_status' => 'status pembayaran',
        'garansi_date' => 'tanggal garansi',
        'garansi_desc' => 'deskripsi garansi',
    ];

    public function mount()
    {
        // Initialize struk as a new empty model to prevent null access
        $this->struk = new Struk();
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'items.')) {
            $parts = explode('.', $propertyName);
            if (count($parts) === 3) {
                $index = $parts[1];
                $field = $parts[2];

                if ($field === 'unit_price') {
                    $this->validateOnly("items.{$index}.unit_price", [
                        "items.{$index}.unit_price" => 'required|numeric|min:0'
                    ]);
                    $this->calculateItemTotal($index);
                }

                if ($field === 'quantity') {
                    $this->validateOnly("items.{$index}.quantity", [
                        "items.{$index}.quantity" => 'required|integer|min:1'
                    ]);
                    $this->calculateItemTotal($index);
                }

                if ($field === 'name') {
                    $this->validateOnly("items.{$index}.name", [
                        "items.{$index}.name" => 'required|string|min:3'
                    ]);
                }
            }
        } elseif ($propertyName === 'description') {
            $this->validateOnly('description', [
                'description' => 'required|string|min:10'
            ]);
        } elseif ($propertyName === 'garansi_date' && $this->is_garansi) {
            $this->validateOnly('garansi_date', [
                'garansi_date' => 'required|date|after:today'
            ]);
        } elseif ($propertyName === 'garansi_desc' && $this->is_garansi) {
            $this->validateOnly('garansi_desc', [
                'garansi_desc' => 'required|string|min:10'
            ]);
        }
    }

    protected function authorizeAdmin()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }
    }

    public function showEditStrukModal($strukId)
    {
        $this->authorizeAdmin();
        try {
            $this->reset();
            $this->strukId = $strukId;

            // Re-initialize struk after reset
            $this->struk = new Struk();

            // Load the actual struk data
            $loadedStruk = Struk::with(['booking', 'items'])->find($strukId);

            if (!$loadedStruk) {
                session()->flash('error', 'Struk tidak ditemukan');
                return;
            }

            $this->struk = $loadedStruk;
            $this->booking = $this->struk->booking;
            $this->description = $this->struk->description;
            $this->payment_status = $this->struk->payment_status;
            $this->is_garansi = $this->struk->is_garansi;
            $this->garansi_date = $this->struk->garansi_date;
            $this->garansi_desc = $this->struk->garansi_desc;

            // Load items
            $this->items = $this->struk->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'price' => $item->price
                ];
            })->toArray();

            $this->showModal = true;
        } catch (\Exception $e) {
            \Log::error('Error in showEditStrukModal: ' . $e->getMessage());
            session()->flash('error', 'Gagal membuka modal edit struk');
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }

    public function addItem()
    {
        $this->items[] = [
            'name' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'price' => 0
        ];
    }

    public function removeItem($index)
    {
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        } else {
            session()->flash('error', 'Minimal harus ada satu item');
        }
    }

    public function calculateItemTotal($index)
    {
        $quantity = max(1, $this->items[$index]['quantity'] ?? 1);
        $unit_price = max(0, $this->items[$index]['unit_price'] ?? 0);

        $this->items[$index]['quantity'] = $quantity;
        $this->items[$index]['unit_price'] = $unit_price;
        $this->items[$index]['price'] = $quantity * $unit_price;
    }

    public function calculateTotal()
    {
        return collect($this->items)->sum('price');
    }

    public function updatedIsGaransi()
    {
        if (!$this->is_garansi) {
            $this->garansi_date = null;
            $this->garansi_desc = null;
        }
    }

    public function save()
    {
        $this->validate();

        // Check if struk is already paid
        if ($this->struk->payment_status === 'paid') {
            session()->flash('error', 'Struk yang sudah dibayar tidak dapat diedit');
            return;
        }

        try {
            // Check again if struk is already paid (double check)
            if ($this->struk->payment_status === 'paid') {
                session()->flash('error', 'Struk yang sudah dibayar tidak dapat diedit');
                $this->closeModal();
                return;
            }

            DB::beginTransaction();

            $this->struk->update([
                'payment_status' => $this->payment_status,
                'total_amount' => $this->calculateTotal(),
                'description' => $this->description,
                'is_garansi' => $this->is_garansi,
                'garansi_date' => $this->is_garansi ? $this->garansi_date : null,
                'garansi_desc' => $this->is_garansi ? $this->garansi_desc : null,
            ]);

            // Delete existing items
            $this->struk->items()->delete();

            // Create new items
            foreach ($this->items as $item) {
                $this->struk->items()->create([
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();
            $this->closeModal();
            $this->dispatch('strukUpdated');
            session()->flash('success', 'Struk berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating struk: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat mengupdate struk');
        }
    }

    public function render()
    {
        return view('livewire.edit-struk', [
            'totalAmount' => $this->calculateTotal()
        ]);
    }
}