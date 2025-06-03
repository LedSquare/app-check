<?php

namespace App\Domains\Aspect\database\seeders;

use App\Domains\Aspect\database\factories\MoodLevelFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoodLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $procent = 0;
        while ($procent <= 100) {
            MoodLevelFactory::new()->create([
                'procent' => $procent,
            ]);
            $procent += 10;
        }
    }
}
