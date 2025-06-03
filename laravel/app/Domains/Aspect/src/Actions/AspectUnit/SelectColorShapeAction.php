<?php

namespace Aspect\Actions\AspectUnit;

use Aspect\Enums\Units\BrainSideEnum;
use Aspect\Interfaces\Actions\AspectUnit\AspectActionInterface;
use Aspect\Interfaces\UnitResponses\ResponseInterface;
use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Models\Stages\Color;
use Aspect\Models\Stages\Shape\Shape;
use Aspect\Units\DTO\WordAspectObject;
use Aspect\Units\Responses\AspectInertiaResponse;

class SelectColorShapeAction implements AspectActionInterface
{
    public BrainSideEnum $side = BrainSideEnum::right;

    public function action(array $data, AspectUnitInterface $aspectUnit): mixed
    {
        $collection = collect();
        foreach ($data['aspect_data'] as $index => $word) {
            $collection->push(
                WordAspectObject::make($word, $index)
            );
        }
        $aspectUnit->words[$aspectUnit->currentStep] = $collection;

        return $aspectUnit;
    }

    public function getParameters(AspectUnitInterface $aspectUnit): ResponseInterface
    {
        $words = $aspectUnit->getWordsFromUnit();

        return new AspectInertiaResponse(
            component: 'Aspect/SelectColorShape',
            data: [
                'aspect_id' => $aspectUnit->aspectId,
                'data' => [
                    'colors' => Color::all(),
                    'words' => $words,
                    'shapes' => Shape::whereIn('id', $words->pluck('shapeId'))->get(),
                ],
                'title' => __('Окраска символов')
            ],
        );
    }
}
