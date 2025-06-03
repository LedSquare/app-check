<?php

namespace App\Domains\Aspect\database\seeders\Shape;

use Aspect\Models\Stages\Shape\Shape;
use Aspect\Models\Stages\Shape\ShapeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ShapeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private static int $number = 5;

    public function run(): void
    {
        $triangleCategory = ShapeCategory::firstWhere('slug', 'Triangles');
        $circleCategory = ShapeCategory::firstWhere('slug', 'Circles');
        $squareCategory = ShapeCategory::firstWhere('slug', 'Squares');

        $categories = [$triangleCategory, $circleCategory, $squareCategory];


        foreach ($categories as $category) {

            $i = self::$number;
            while ($i > 0) {
                $category->shapes()->create([
                    'filepath' => "images/shapes/" . strtolower($category->slug) . "/$i.png"
                ]);
                $i--;
            }
        }
    }
}
