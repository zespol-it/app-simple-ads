<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;

class DemoAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ad::create([
            'name' => 'Test ogłoszenie 1',
            'description' => 'Opis testowego ogłoszenia 1',
            'price' => 123.45,
            'images' => ['ads/logo_small.png'],
        ]);
        Ad::create([
            'name' => 'Test ogłoszenie 2',
            'description' => 'Opis testowego ogłoszenia 2',
            'price' => 678.90,
            'images' => ['ads/logo.png'],
        ]);
    }
}
