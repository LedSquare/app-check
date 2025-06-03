<?php

namespace Aspect\Units\DTO;

final class WordAspectObject
{

    public function __construct(
        public int $id,
        public int $order,
        public string $name,
        public ?string $colorCode = null,
        public ?int $shapeId = null,
        public ?string $shapeColorCode = null,
    ) {
    }

    public static function make(array $wordData, int $index): self
    {
        return new WordAspectObject(
            $wordData['id'],
            $index,
            $wordData['name'],
            $wordData['colorCode'] ?? null,
            $wordData['shapeId'] ?? null,
            $wordData['shapeColorCode'] ?? null,
        );
    }

}
