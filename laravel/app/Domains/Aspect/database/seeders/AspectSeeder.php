<?php

namespace App\Domains\Aspect\database\seeders;

use App\Domains\Aspect\database\factories\AspectFactory;
use App\Domains\Aspect\database\factories\AspectUnitFactory;
use App\Models\User;
use Illuminate\Database\Seeder;

class AspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $testUser = User::first();
        // $aspects = AspectFactory::new()->count(5)->create([
        //     'user_id' => $testUser->id,
        // ]);

        // foreach ($aspects as $aspect) {
        //     $unit = AspectUnitFactory::fake($aspect);
        //     dd(
        //         $unit->words[0],
        //         $unit->words[2],
        //         $unit->words[3],
        //         $unit->words[4],
        //         $unit->words[5],
        //     );
        //     $unit->saveUnit($unit);
        // }

    }
}
