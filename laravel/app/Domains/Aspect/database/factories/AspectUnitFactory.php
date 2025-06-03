<?php

namespace App\Domains\Aspect\database\factories;

use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Models\Aspect;
use Aspect\Models\Stages\Color;
use Aspect\Models\Stages\Shape\Shape;
use Aspect\Models\Stages\Word\Word;
use Aspect\Units\DTO\WordAspectObject;

final class AspectUnitFactory
{

    /**
     * @return AspectUnitInterface
     */
    public static function fake(Aspect $aspect): AspectUnitInterface
    {
        $unit = $aspect->getUnit();

        $words = Word::inRandomOrder()->take(8)->get();
        $shapes = Shape::inRandomOrder()->take(8)->get();
        $colors = Color::all();

        $collection = collect();
        foreach ($words as $index => $word) {
            $collection->push(
                new WordAspectObject(
                    id: $word->id,
                    order: $index,
                    name: $word->name,
                )
            );
        }

        $unit->words[$unit->currentStep] = $collection;

        $unit->currentStep++;

        $unit->moodLevels[$unit->currentStep] = (string) \random_int(0, 100);

        $unit->currentStep++;

        foreach ($shapes as $key => $shape) {
            $collection[$key]->shapeId = $shape->id;
        }
        $unit->words[$unit->currentStep] = $collection;

        $unit->currentStep++;

        $collection = $collection->shuffle();
        foreach ($collection as $key => $value) {
            $value->order = $key;
        }
        $unit->words[$unit->currentStep] = $collection;

        $unit->currentStep++;

        $colors = $colors->shuffle();
        foreach ($colors as $key => $color) {
            $collection[$key]->colorCode = $color->hex_code;
        }
        $unit->words[$unit->currentStep] = $collection;

        $unit->currentStep++;

        $collection = $collection->shuffle();
        $unit->words[$unit->currentStep] = $collection;

        $unit->currentStep++;

        $colors = $colors->shuffle();
        foreach ($colors as $key => $color) {
            $collection[$key]->shapeColorCode = $color->hex_code;
        }
        $unit->words[$unit->currentStep] = $collection;

        $unit->currentStep++;

        $collection = $collection->shuffle();
        $unit->words[$unit->currentStep] = $collection;

        return $unit;
    }


}
