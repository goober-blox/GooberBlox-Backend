<?php

namespace GooberBlox\FloodCheckers;

class FloodCheckerStatus
{
    public function __construct(
        public readonly bool $isFlooded,
        public readonly int $limit,
        public readonly int $count, 
        public readonly string $name
    ) {}
}