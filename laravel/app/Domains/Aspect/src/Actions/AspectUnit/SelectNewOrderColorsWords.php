<?php

namespace Aspect\Actions\AspectUnit;

use Aspect\Enums\Units\BrainSideEnum;
use Aspect\Interfaces\Actions\AspectUnit\AspectActionInterface;
use Aspect\Interfaces\UnitResponses\ResponseInterface;
use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Units\DTO\WordAspectObject;
use Aspect\Units\Responses\AspectInertiaResponse;

class SelectNewOrderColorsWords implements AspectActionInterface
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
            component: 'Aspect/SelectNewOrderColorsWords',
            data: [
                'aspect_id' => $aspectUnit->aspectId,
                'data' => [
                    'words' => $words,
                ],
                'title' => __('Мозаика полушарий')
            ]
        );
    }
}
