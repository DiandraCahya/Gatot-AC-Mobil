<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $fillable = [
        'user_id',
        'nama',
        'jenis',
        'tanggal',
        'jam',
        'mobil',
        'tempat',
        'keterangan',
        'status',
        'pesan'
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function struk()
    {
        return $this->hasOne(Struk::class);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}