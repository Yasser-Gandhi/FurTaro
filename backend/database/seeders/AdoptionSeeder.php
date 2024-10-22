<?php

namespace Database\Seeders;

use App\Models\Adoption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdoptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Adoption::factory()->count(9)->create();
    }
}
