<?php

namespace Aspect\Units\Responses;

use Aspect\Interfaces\UnitResponses\ResponseInterface;

/**
 * @template T of self
 * @template-implements ResponseInterface<T>
 */
final class AspectInertiaResponse implements ResponseInterface
{
    public function __construct(
        public readonly string $component,
        public readonly array $data,
    ) {
    }

}
