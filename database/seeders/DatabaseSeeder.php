<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Struk;
use App\Models\StrukItem;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            JasaSeeder::class,
        ]);

    }
}
