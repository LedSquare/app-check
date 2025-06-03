<?php

namespace Aspect\Actions\AspectUnit;

use Aspect\Enums\Units\BrainSideEnum;
use Aspect\Interfaces\Actions\AspectUnit\AspectActionInterface;
use Aspect\Interfaces\UnitResponses\ResponseInterface;
use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Models\Stages\Word\Word;
use Aspect\Units\DTO\WordAspectObject;
use Aspect\Units\Responses\AspectInertiaResponse;

class SelectWordsAction implements AspectActionInterface
{
    public BrainSideEnum $side = BrainSideEnum::left;

    public function action(array $data, AspectUnitInterface $aspectUnit): mixed
    {
        /** @var \Illuminate\Support\Collection<WordAspectObject> */
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
        /** @var \Illuminate\Support\Collection<WordAspectObject> */
        $words = collect();
        foreach (Word::all()->toArray() as $index => $word) {
            $words->push(
                WordAspectObject::make($word, $index),
            );
        }
        return new AspectInertiaResponse(
            component: 'Aspect/SelectWords',
            data: [
                'data' => $words,
                'aspect_id' => $aspectUnit->aspectId,
                'title' => __('Выбор понятий'),
            ]
        );
    }
}
