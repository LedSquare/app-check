<?php

namespace App\Domains\Aspect\database\factories\Word;

use Aspect\Models\Stages\Word\Word;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Word>
 */
class WordFactory extends Factory
{
    /**
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Word::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word();
        $slug = Str::slug($name);

        return [
            'a_word_category_id' => 1,
            'name' => $name,
            'slug' => $slug,
        ];
    }
}
