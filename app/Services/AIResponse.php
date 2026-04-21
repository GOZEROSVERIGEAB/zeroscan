<?php

namespace App\Services;

class AIResponse
{
    public function __construct(
        public string $provider,
        public string $model,
        public string $content,
        public int $inputTokens = 0,
        public int $outputTokens = 0,
    ) {}

    public function totalTokens(): int
    {
        return $this->inputTokens + $this->outputTokens;
    }

    /**
     * Parse the content as JSON and return as array.
     *
     * @return array<string, mixed>
     */
    public function getJsonContent(): array
    {
        $content = $this->content;

        $content = preg_replace('/^```json\s*/i', '', $content);
        $content = preg_replace('/```\s*$/', '', $content);
        $content = trim($content);

        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        return $decoded ?? [];
    }

    public function isSuccessful(): bool
    {
        return !empty($this->content) && !empty($this->getJsonContent());
    }
}
