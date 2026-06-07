<?php

namespace Database\Seeders;

use App\Models\BurialSpot;
use Illuminate\Database\Seeder;

class BurialSpotSeeder extends Seeder
{
    public function run(): void
    {
        if (BurialSpot::count() === 0) {
            BurialSpot::insert([
                ['name' => 'Maria Santos',  'plot_number' => 'A-01', 'section' => 'Block 1', 'birth_year' => 1935, 'death_year' => 2010, 'status' => 'occupied', 'map_x' => 110, 'map_y' => 90],
                ['name' => 'Jose Reyes',    'plot_number' => 'A-02', 'section' => 'Block 1', 'birth_year' => 1942, 'death_year' => 2015, 'status' => 'occupied', 'map_x' => 170, 'map_y' => 90],
                ['name' => 'Plot B-01',     'plot_number' => 'B-01', 'section' => 'Block 2', 'birth_year' => null,  'death_year' => null,  'status' => 'available','map_x' => 110, 'map_y' => 160],
            ]);
        }
    }
}
