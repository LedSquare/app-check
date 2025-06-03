<?php

namespace Aspect\Interfaces\Actions\AspectUnit;

use Aspect\Interfaces\UnitResponses\ResponseInterface;
use Aspect\Interfaces\Units\AspectUnitInterface;

/**
 *
 * @property \Aspect\Enums\Units\BrainSideEnum $side
 */
interface AspectActionInterface
{
    public function action(array $data, AspectUnitInterface $aspectUnit): mixed;

    public function getParameters(AspectUnitInterface $aspectUnit): ResponseInterface;

}
