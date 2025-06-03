<?php

namespace Aspect\Actions\AspectUnit;

use Aspect\Interfaces\Actions\AspectUnit\AspectActionInterface;
use Aspect\Interfaces\UnitResponses\ResponseInterface;
use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Units\Responses\AspectInertiaResponse;

class MoodLevelAction implements AspectActionInterface
{
    public function action(array $data, AspectUnitInterface $aspectUnit): mixed
    {
        $aspectUnit->moodLevels[$aspectUnit->currentStep] = $data['aspect_data'];
        return $aspectUnit;
    }

    public function getParameters(AspectUnitInterface $aspectUnit): ResponseInterface
    {
        return new AspectInertiaResponse(
            component: 'Aspect/MoodLevel',
            data: [
                'data' => [],
                'aspect_id' => $aspectUnit->aspectId,
                'title' => __('Определение уровня психосоматического состояния')
            ]
        );
    }
}
