<?php

namespace App\Domains\Aspect\database\seeders\Shape;

use Aspect\Models\Stages\Shape\ShapeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShapeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShapeCategory::create([
            'name' => 'Треугольники',
            'slug' => 'Triangles',
        ]);

        ShapeCategory::create([
            'name' => 'Окружности',
            'slug' => 'Circles',
        ]);

        ShapeCategory::create([
            'name' => 'Квадраты',
            'slug' => 'Squares',
        ]);

    }
}
