<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class AnthropicService
{
    protected const API_VERSION = '2023-06-01';

    protected const MODEL = 'claude-opus-4-7';

    protected const MAX_TOKENS = 4096;

    protected const TIMEOUT = 120;

    protected string $apiKey;

    protected string $baseUrl = 'https://api.anthropic.com/v1';

    /**
     * The system prompt for environmental analysis.
     * This is cached using Anthropic's prompt caching feature.
     */
    protected string $systemPrompt = 'You are an expert environmental analyst specializing in sustainable consumption and circular economy.

TASK: Analyze the image of a reused/secondhand item and estimate the environmental savings from reusing this item versus buying new.

RESPOND ONLY IN THIS JSON FORMAT:
{
    "item_name": "Name of the item in English",
    "item_category": "Category (Furniture/Electronics/Clothing/Sports/Household/Toys/Books/Other)",
    "estimated_weight_kg": 0.0,
    "co2_savings": {
        "kg": 0.0,
        "explanation": "How the CO2 savings were calculated",
        "comparison": "Equivalent comparison (e.g., \'equivalent to X km driven\')"
    },
    "water_savings_liters": 0.0,
    "energy_savings_kwh": 0.0,
    "material_type": "Primary material (wood/metal/plastic/fabric/glass/mixed)",
    "condition": "excellent/good/fair/poor",
    "reuse_potential": {
        "score": 0,
        "description": "Assessment of how suitable this item is for reuse"
    },
    "environmental_facts": [
        "Interesting environmental fact about reusing this type of item",
        "Another relevant sustainability fact"
    ]
}

ENVIRONMENTAL CALCULATION GUIDELINES:
- Furniture (wood): 20-80 kg CO2 savings, 500-2000L water savings
- Furniture (metal): 30-120 kg CO2 savings, 1000-5000L water savings
- Electronics (small): 15-50 kg CO2 savings, 200-800L water savings
- Electronics (large): 100-400 kg CO2 savings, 2000-10000L water savings
- Clothing: 5-25 kg CO2 savings per item, 2000-8000L water savings
- Sports equipment: 10-80 kg CO2 savings, 500-3000L water savings
- Toys (plastic): 2-10 kg CO2 savings, 100-500L water savings
- Books: 1-3 kg CO2 savings, 50-200L water savings
- Household items: 2-30 kg CO2 savings depending on material

ENERGY SAVINGS GUIDELINES (manufacturing energy avoided):
- Small items: 5-50 kWh
- Medium items: 50-200 kWh
- Large items: 200-1000 kWh
- Electronics: 100-500 kWh

REUSE POTENTIAL SCORE (1-10):
- 10: Perfect condition, high demand, long lifespan remaining
- 7-9: Good condition, moderate demand, significant lifespan
- 4-6: Fair condition, some wear, limited but viable reuse
- 1-3: Poor condition, limited reuse potential, may need repair

IMPORTANT:
- Respond ONLY with valid JSON, no other text
- Base estimates on scientific lifecycle assessment data
- If image is unclear, make best possible assessment with lower confidence
- Consider both direct and indirect environmental impacts
- Include meaningful comparisons to help users understand the impact';

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.api_key', '');

        if (empty($this->apiKey)) {
            Log::warning('AnthropicService: API key is not configured');
        }
    }

    /**
     * Analyze an image for environmental impact assessment.
     *
     * @param  string  $imagePath  Absolute path to the image file
     * @return array<string, mixed> Structured environmental analysis data
     *
     * @throws RuntimeException If the image cannot be read or API call fails
     */
    public function analyzeImage(string $imagePath): array
    {
        if (empty($this->apiKey)) {
            throw new RuntimeException('Anthropic API key is not configured');
        }

        if (! file_exists($imagePath)) {
            throw new RuntimeException("Image file not found: {$imagePath}");
        }

        $imageContent = file_get_contents($imagePath);
        if ($imageContent === false) {
            throw new RuntimeException("Failed to read image file: {$imagePath}");
        }

        $base64Image = base64_encode($imageContent);
        $mimeType = $this->getMimeType($imagePath);

        return $this->callAnthropicApi($base64Image, $mimeType);
    }

    /**
     * Call the Anthropic API with prompt caching enabled.
     *
     * @param  string  $base64Image  Base64 encoded image data
     * @param  string  $mimeType  Image MIME type
     * @return array<string, mixed> Parsed analysis response
     *
     * @throws RuntimeException If API call fails
     */
    protected function callAnthropicApi(string $base64Image, string $mimeType): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'anthropic-version' => self::API_VERSION,
                'anthropic-beta' => 'prompt-caching-2024-07-31',
                'Content-Type' => 'application/json',
            ])
                ->timeout(self::TIMEOUT)
                ->post("{$this->baseUrl}/messages", [
                    'model' => self::MODEL,
                    'max_tokens' => self::MAX_TOKENS,
                    'system' => [
                        [
                            'type' => 'text',
                            'text' => $this->systemPrompt,
                            'cache_control' => [
                                'type' => 'ephemeral',
                            ],
                        ],
                    ],
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
                                    'text' => 'Analyze this reused item and provide environmental impact assessment.',
                                ],
                            ],
                        ],
                    ],
                ]);

            if (! $response->successful()) {
                Log::error('AnthropicService: API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new RuntimeException("Anthropic API error: {$response->status()} - {$response->body()}");
            }

            $responseData = $response->json();

            Log::info('AnthropicService: API call successful', [
                'model' => self::MODEL,
                'input_tokens' => $responseData['usage']['input_tokens'] ?? 0,
                'output_tokens' => $responseData['usage']['output_tokens'] ?? 0,
                'cache_creation_input_tokens' => $responseData['usage']['cache_creation_input_tokens'] ?? 0,
                'cache_read_input_tokens' => $responseData['usage']['cache_read_input_tokens'] ?? 0,
            ]);

            return $this->parseResponse($responseData);

        } catch (RequestException $e) {
            Log::error('AnthropicService: Request exception', [
                'message' => $e->getMessage(),
                'response' => $e->response?->body(),
            ]);
            throw new RuntimeException("Anthropic API request failed: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Parse the API response and extract structured data.
     *
     * @param  array<string, mixed>  $responseData  Raw API response
     * @return array<string, mixed> Parsed analysis data
     */
    protected function parseResponse(array $responseData): array
    {
        $textContent = '';

        $contentArray = $responseData['content'] ?? [];
        foreach ($contentArray as $block) {
            if (($block['type'] ?? '') === 'text') {
                $textContent .= $block['text'] ?? '';
            }
        }

        $textContent = preg_replace('/^```json\s*/i', '', $textContent);
        $textContent = preg_replace('/```\s*$/', '', $textContent);
        $textContent = trim($textContent);

        $parsed = json_decode($textContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('AnthropicService: Failed to parse JSON response', [
                'error' => json_last_error_msg(),
                'content' => substr($textContent, 0, 500),
            ]);

            return $this->getDefaultResponse();
        }

        return $this->normalizeResponse($parsed);
    }

    /**
     * Normalize the response to ensure all expected fields are present.
     *
     * @param  array<string, mixed>  $parsed  Parsed JSON response
     * @return array<string, mixed> Normalized response
     */
    protected function normalizeResponse(array $parsed): array
    {
        $defaults = $this->getDefaultResponse();

        return [
            'item_name' => $parsed['item_name'] ?? $defaults['item_name'],
            'item_category' => $parsed['item_category'] ?? $defaults['item_category'],
            'estimated_weight_kg' => (float) ($parsed['estimated_weight_kg'] ?? $defaults['estimated_weight_kg']),
            'co2_savings' => array_merge($defaults['co2_savings'], $parsed['co2_savings'] ?? []),
            'water_savings_liters' => (float) ($parsed['water_savings_liters'] ?? $defaults['water_savings_liters']),
            'energy_savings_kwh' => (float) ($parsed['energy_savings_kwh'] ?? $defaults['energy_savings_kwh']),
            'material_type' => $parsed['material_type'] ?? $defaults['material_type'],
            'condition' => $parsed['condition'] ?? $defaults['condition'],
            'reuse_potential' => array_merge($defaults['reuse_potential'], $parsed['reuse_potential'] ?? []),
            'environmental_facts' => $parsed['environmental_facts'] ?? $defaults['environmental_facts'],
        ];
    }

    /**
     * Get the default response structure.
     *
     * @return array<string, mixed>
     */
    protected function getDefaultResponse(): array
    {
        return [
            'item_name' => 'Unknown item',
            'item_category' => 'Other',
            'estimated_weight_kg' => 0.0,
            'co2_savings' => [
                'kg' => 0.0,
                'explanation' => 'Unable to calculate',
                'comparison' => '',
            ],
            'water_savings_liters' => 0.0,
            'energy_savings_kwh' => 0.0,
            'material_type' => 'unknown',
            'condition' => 'unknown',
            'reuse_potential' => [
                'score' => 0,
                'description' => 'Unable to assess',
            ],
            'environmental_facts' => [],
        ];
    }

    /**
     * Determine the MIME type of an image file.
     *
     * @param  string  $imagePath  Path to the image file
     * @return string MIME type
     */
    protected function getMimeType(string $imagePath): string
    {
        $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

        return match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };
    }
}
