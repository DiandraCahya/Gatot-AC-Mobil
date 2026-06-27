<?php

namespace App\Models;

use App\Models\StrukItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Struk extends Model
{
    protected $fillable = [
        'booking_id',
        'payment_status',
        'total_amount',
        'description',
        'is_garansi',
        'garansi_date',
        'garansi_desc',
        'snap_token',
        'order_id',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(StrukItem::class);
    }
}