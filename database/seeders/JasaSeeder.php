<?php

namespace Database\Seeders;

use App\Models\Jasa;
use Illuminate\Database\Seeder;

class JasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jasas = [
            [
                'name' => 'Isi Freon AC Single',
                'description' => 'Layanan pengisian freon berkualitas untuk AC mobil Anda (sistem single)',
                'price' => "200K"
            ],
            [
                'name' => 'Isi Freon AC Double',
                'description' => 'Layanan pengisian freon berkualitas untuk AC mobil Anda (sistem double)',
                'price' => "300K"
            ],
            [
                'name' => 'Pasang AC Baru ',
                'description' => 'Pemasangan unit AC mobil baru dengan garansi. Harga sudah termasuk sparepart dan jasa pasang',
                'price' => "6jt - 7,5jt"
            ],
            [
                'name' => 'Service AC Mobil',
                'description' => 'Perbaikan dan perawatan sistem AC mobil Anda (belum termasuk sparepart)',
                'price' => "350K - 750K"
            ],
            [
                'name' => 'Konsultasi dan Cek Kondisi AC',
                'description' => 'Pemeriksaan awal untuk mendiagnosa kondisi AC mobil Anda',
                'price' => "Gratis"
            ],
        ];

        foreach ($jasas as $jasa) {
            Jasa::create($jasa);
        }
    }
}