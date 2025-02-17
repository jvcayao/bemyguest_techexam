<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\ConversionRates\Models\ExchangeRate;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ExchangeRate::create(['rate' => 2.96]); 
    }
}
