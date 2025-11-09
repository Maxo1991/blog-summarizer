<?php

declare(strict_types=1);

namespace App\DTO;

class SummaryDto
{
    public function __construct(
        public readonly string $url,
        public readonly string $summary,
    ) {}
}
