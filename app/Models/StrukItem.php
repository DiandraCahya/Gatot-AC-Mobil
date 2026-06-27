<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukItem extends Model
{
    protected $fillable = [
        'struk_id',
        'name',
        'quantity',
        'unit_price',
        'price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function struk()
    {
        return $this->belongsTo(Struk::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($item) {
            // Automatically calculate total price before saving
            $item->price = $item->quantity * $item->unit_price;
        });
    }
}