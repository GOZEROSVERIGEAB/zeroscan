<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class AIService
{
    protected string $provider;

    /** @var array<string, mixed> */
    protected array $config;

    public function __construct(?string $provider = null)
    {
        $this->provider = $provider ?? config('ai.default_provider');
        $this->config = config("ai.providers.{$this->provider}");

        if (empty($this->config)) {
            throw new InvalidArgumentException("Unknown AI provider: {$this->provider}");
        }
    }

    public function analyzeImage(string $base64Image, string $mimeType): AIResponse
    {
        return match ($this->provider) {
            'anthropic' => $this->analyzeWithAnthropic($base64Image, $mimeType),
            'openai' => $this->analyzeWithOpenAI($base64Image, $mimeType),
            default => throw new InvalidArgumentException("Unknown provider: {$this->provider}"),
        };
    }

    protected function analyzeWithAnthropic(string $base64Image, string $mimeType): AIResponse
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->config['api_key'],
            'anthropic-version' => '2023-06-01',
            'Content-Type' => 'application/json',
        ])
            ->timeout($this->config['timeout'])
            ->post($this->config['base_url'] . '/messages', [
                'model' => $this->config['default_model'],
                'max_tokens' => $this->config['max_tokens'],
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'image',
                                'source' => [
                                    'type' => 'base64',
                                    'media_type' => $mimeType,
                                    'data' => $base64Image,
                                ],
                            ],
                            [
                                'type' => 'text',
                                'text' => config('ai.system_prompt'),
                            ],
                        ],
                    ],
                ],
            ]);

        if (!$response->successful()) {
            Log::error('Anthropic API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new RequestException($response);
        }

        $textContent = '';
        $contentArray = $response->json('content', []);
        foreach ($contentArray as $block) {
            if (($block['type'] ?? '') === 'text') {
                $textContent .= $block['text'] ?? '';
            }
        }

        return new AIResponse(
            provider: 'anthropic',
            model: $this->config['default_model'],
            content: $textContent,
            inputTokens: $response->json('usage.input_tokens', 0),
            outputTokens: $response->json('usage.output_tokens', 0),
        );
    }

    protected function analyzeWithOpenAI(string $base64Image, string $mimeType): AIResponse
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->config['api_key']}",
            'Content-Type' => 'application/json',
        ])
            ->timeout($this->config['timeout'])
            ->post($this->config['base_url'] . '/chat/completions', [
                'model' => $this->config['default_model'],
                'max_tokens' => $this->config['max_tokens'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => config('ai.system_prompt'),
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => "data:{$mimeType};base64,{$base64Image}",
                                ],
                            ],
                            [
                                'type' => 'text',
                                'text' => 'Analysera denna bild av ett begagnat föremål.',
                            ],
                        ],
                    ],
                ],
            ]);

        if (!$response->successful()) {
            Log::error('OpenAI API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new RequestException($response);
        }

        return new AIResponse(
            provider: 'openai',
            model: $this->config['default_model'],
            content: $response->json('choices.0.message.content', ''),
            inputTokens: $response->json('usage.prompt_tokens', 0),
            outputTokens: $response->json('usage.completion_tokens', 0),
        );
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function getModel(): string
    {
        return $this->config['default_model'];
    }
}
