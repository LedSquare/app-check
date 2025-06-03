<?php

namespace Aspect\Actions\AspectUnit;

use Aspect\Enums\Units\BrainSideEnum;
use Aspect\Interfaces\Actions\AspectUnit\AspectActionInterface;
use Aspect\Interfaces\UnitResponses\ResponseInterface;
use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Models\Stages\Color;
use Aspect\Units\DTO\WordAspectObject;
use Aspect\Units\Responses\AspectInertiaResponse;

class SelectColorWordAction implements AspectActionInterface
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
        return new AspectInertiaResponse(
            component: 'Aspect/SelectColorWord',
            data: [
                'aspect_id' => $aspectUnit->aspectId,
                'data' => [
                    'colors' => Color::all(),
                    'words' => $aspectUnit->getWordsFromUnit(),
                ],
                'title' => __('Окраска понятий')
            ]
        );
    }
}
