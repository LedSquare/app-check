<?php

namespace App\Domains\Aspect\database\factories;

use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Models\Aspect;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Aspect>
 */
class AspectFactory extends Factory
{

    /**
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Aspect::class;

    public function definition(): array
    {
        return [
            'aspect_unit' => null
        ];
    }
}
