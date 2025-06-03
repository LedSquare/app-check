<?php

namespace App\Domains\Aspect\database\seeders\Color;

use Aspect\Models\Stages\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'purple', 'hex_code' => '#e866ff'],
            ['name' => 'blue', 'hex_code' => '#6c66ff'],
            ['name' => 'green', 'hex_code' => '#66ff71'],
            ['name' => 'yellow', 'hex_code' => '#f6ff66'],
            ['name' => 'red', 'hex_code' => '#ff7766'],
            ['name' => 'brown', 'hex_code' => '#ff994d'],
            ['name' => 'gray', 'hex_code' => '#c8c8c8'],
            ['name' => 'black', 'hex_code' => '#434343'],
        ];

        foreach ($colors as $color) {
            Color::create([
                'name' => $color['name'],
                'hex_code' => $color['hex_code'],
            ]);
        }
    }
}
