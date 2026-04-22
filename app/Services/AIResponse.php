<?php

namespace App\Services;

class AIResponse
{
    public function __construct(
        public string $provider,
        public string $model,
        public int $inputTokens = 0,
        public int $outputTokens = 0,
        public int $cacheCreationTokens = 0,
        public int $cacheReadTokens = 0,
        protected array $content = [],
    ) {}

    public function getJsonContent(): array
    {
        return $this->content;
    }

    public function totalTokens(): int
    {
        return $this->inputTokens + $this->outputTokens;
    }
}
