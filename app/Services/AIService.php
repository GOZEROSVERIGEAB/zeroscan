<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class AIService
{
    protected const API_VERSION = '2023-06-01';
    protected const MODEL = 'claude-opus-4-7';
    protected const MAX_TOKENS = 4096;
    protected const TIMEOUT = 120;

    protected string $apiKey;
    protected string $baseUrl = 'https://api.anthropic.com/v1';

    protected string $systemPrompt = 'Du är en expert på miljöanalys specialiserad på hållbar konsumtion och cirkulär ekonomi.

UPPGIFT: Analysera bilden av ett återanvänt/begagnat föremål och uppskatta miljöbesparingen från att återanvända detta föremål jämfört med att köpa nytt.

SVARA ENDAST I DETTA JSON-FORMAT:
{
    "name": "Namn på föremålet på svenska",
    "description": "Kort beskrivning av föremålet",
    "category": "Kategori (Möbler/Elektronik/Kläder/Sport/Hushåll/Leksaker/Böcker/Övrigt)",
    "subcategory": "Underkategori om tillämpligt",
    "brand": "Märke om identifierbart, annars null",
    "model": "Modell om identifierbar, annars null",
    "materials": "Huvudmaterial (trä/metall/plast/tyg/glas/blandat)",
    "colors": "Huvudfärger",
    "weight_kg": 0.0,
    "dimensions": {
        "height_cm": 0,
        "width_cm": 0,
        "depth_cm": 0
    },
    "estimated_value_sek": 0,
    "condition": {
        "rating": 8,
        "description": "Beskrivning av skick"
    },
    "co2_savings": {
        "kg": 0.0,
        "source": "Källa för beräkning",
        "calculation": "Hur CO2-besparingen beräknades"
    },
    "water_savings_liters": 0.0,
    "energy_savings_kwh": 0.0,
    "reuse_potential": {
        "score": 8,
        "description": "Bedömning av hur lämpligt föremålet är för återbruk"
    },
    "environmental_facts": [
        "Intressant miljöfakta om att återanvända denna typ av föremål",
        "Ytterligare relevant hållbarhetsfakta"
    ],
    "confidence": 0.85
}

RIKTLINJER FÖR MILJÖBERÄKNINGAR:
- Möbler (trä): 20-80 kg CO2-besparing, 500-2000L vattenbesparing
- Möbler (metall): 30-120 kg CO2-besparing, 1000-5000L vattenbesparing
- Elektronik (liten): 15-50 kg CO2-besparing, 200-800L vattenbesparing
- Elektronik (stor): 100-400 kg CO2-besparing, 2000-10000L vattenbesparing
- Kläder: 5-25 kg CO2-besparing per plagg, 2000-8000L vattenbesparing
- Sportutrustning: 10-80 kg CO2-besparing, 500-3000L vattenbesparing
- Leksaker (plast): 2-10 kg CO2-besparing, 100-500L vattenbesparing
- Böcker: 1-3 kg CO2-besparing, 50-200L vattenbesparing
- Hushållsartiklar: 2-30 kg CO2-besparing beroende på material

SKICK (rating 1-10):
- 10: Perfekt skick, som nytt
- 7-9: Mycket bra skick, mindre slitage
- 4-6: Bra skick, synligt slitage men fullt funktionellt
- 1-3: Dåligt skick, behöver reparation

VIKTIGT:
- Svara ENDAST med giltig JSON, ingen annan text
- Basera uppskattningar på vetenskaplig livscykelanalys
- Om bilden är otydlig, gör bästa möjliga bedömning med lägre confidence
- Alla texter ska vara på svenska';

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.api_key', '');

        if (empty($this->apiKey)) {
            Log::warning('AIService: Anthropic API key is not configured');
        }
    }

    /**
     * Analyze an image for environmental impact assessment.
     *
     * @param string $base64Image Base64 encoded image data
     * @param string $mimeType Image MIME type
     * @return AIResponse Structured environmental analysis data
     * @throws RuntimeException If API call fails
     */
    public function analyzeImage(string $base64Image, string $mimeType): AIResponse
    {
        if (empty($this->apiKey)) {
            throw new RuntimeException('Anthropic API key is not configured');
        }

        return $this->callAnthropicApi($base64Image, $mimeType);
    }

    /**
     * Analyze an image from a storage path.
     *
     * @param string $storagePath Path relative to public disk
     * @return AIResponse Structured environmental analysis data
     */
    public function analyzeImageFromPath(string $storagePath): AIResponse
    {
        $fullPath = Storage::disk('public')->path($storagePath);
        
        if (!file_exists($fullPath)) {
            throw new RuntimeException("Image file not found: {$storagePath}");
        }

        $imageContent = file_get_contents($fullPath);
        if ($imageContent === false) {
            throw new RuntimeException("Failed to read image file: {$storagePath}");
        }

        $base64Image = base64_encode($imageContent);
        $mimeType = Storage::disk('public')->mimeType($storagePath) ?? 'image/jpeg';

        return $this->analyzeImage($base64Image, $mimeType);
    }

    /**
     * Call the Anthropic API with prompt caching enabled.
     */
    protected function callAnthropicApi(string $base64Image, string $mimeType): AIResponse
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
                                    'text' => 'Analysera detta återanvända föremål och ge en miljöpåverkansbedömning på svenska.',
                                ],
                            ],
                        ],
                    ],
                ]);

            if (!$response->successful()) {
                Log::error('AIService: API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new RuntimeException("Anthropic API error: {$response->status()} - {$response->body()}");
            }

            $responseData = $response->json();
            $usage = $responseData['usage'] ?? [];

            Log::info('AIService: API call successful', [
                'model' => self::MODEL,
                'input_tokens' => $usage['input_tokens'] ?? 0,
                'output_tokens' => $usage['output_tokens'] ?? 0,
                'cache_creation_input_tokens' => $usage['cache_creation_input_tokens'] ?? 0,
                'cache_read_input_tokens' => $usage['cache_read_input_tokens'] ?? 0,
            ]);

            $content = $this->parseResponse($responseData);

            return new AIResponse(
                provider: 'anthropic',
                model: self::MODEL,
                inputTokens: $usage['input_tokens'] ?? 0,
                outputTokens: $usage['output_tokens'] ?? 0,
                cacheCreationTokens: $usage['cache_creation_input_tokens'] ?? 0,
                cacheReadTokens: $usage['cache_read_input_tokens'] ?? 0,
                content: $content,
            );

        } catch (RequestException $e) {
            Log::error('AIService: Request exception', [
                'message' => $e->getMessage(),
                'response' => $e->response?->body(),
            ]);
            throw new RuntimeException("Anthropic API request failed: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Parse the API response and extract structured data.
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

        // Remove markdown code blocks if present
        $textContent = preg_replace('/^```json\s*/i', '', $textContent);
        $textContent = preg_replace('/```\s*$/', '', $textContent);
        $textContent = trim($textContent);

        $parsed = json_decode($textContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('AIService: Failed to parse JSON response', [
                'error' => json_last_error_msg(),
                'content' => substr($textContent, 0, 500),
            ]);

            return $this->getDefaultResponse();
        }

        return $this->normalizeResponse($parsed);
    }

    /**
     * Normalize the response to ensure all expected fields are present.
     */
    protected function normalizeResponse(array $parsed): array
    {
        $defaults = $this->getDefaultResponse();

        return array_merge($defaults, [
            'name' => $parsed['name'] ?? $defaults['name'],
            'description' => $parsed['description'] ?? $defaults['description'],
            'category' => $parsed['category'] ?? $defaults['category'],
            'subcategory' => $parsed['subcategory'] ?? null,
            'brand' => $parsed['brand'] ?? null,
            'model' => $parsed['model'] ?? null,
            'materials' => $parsed['materials'] ?? $defaults['materials'],
            'colors' => $parsed['colors'] ?? null,
            'weight_kg' => (float) ($parsed['weight_kg'] ?? 0),
            'dimensions' => $parsed['dimensions'] ?? $defaults['dimensions'],
            'estimated_value_sek' => (int) ($parsed['estimated_value_sek'] ?? 0),
            'condition' => $parsed['condition'] ?? $defaults['condition'],
            'co2_savings' => array_merge($defaults['co2_savings'], $parsed['co2_savings'] ?? []),
            'water_savings_liters' => (float) ($parsed['water_savings_liters'] ?? 0),
            'energy_savings_kwh' => (float) ($parsed['energy_savings_kwh'] ?? 0),
            'reuse_potential' => $parsed['reuse_potential'] ?? $defaults['reuse_potential'],
            'environmental_facts' => $parsed['environmental_facts'] ?? [],
            'confidence' => (float) ($parsed['confidence'] ?? 0.5),
        ]);
    }

    /**
     * Get the default response structure.
     */
    protected function getDefaultResponse(): array
    {
        return [
            'name' => 'Okänt föremål',
            'description' => '',
            'category' => 'Övrigt',
            'subcategory' => null,
            'brand' => null,
            'model' => null,
            'materials' => 'okänt',
            'colors' => null,
            'weight_kg' => 0.0,
            'dimensions' => [
                'height_cm' => 0,
                'width_cm' => 0,
                'depth_cm' => 0,
            ],
            'estimated_value_sek' => 0,
            'condition' => [
                'rating' => 5,
                'description' => 'Kunde inte bedöma skick',
            ],
            'co2_savings' => [
                'kg' => 0.0,
                'source' => 'Uppskattning',
                'calculation' => 'Kunde inte beräkna',
            ],
            'water_savings_liters' => 0.0,
            'energy_savings_kwh' => 0.0,
            'reuse_potential' => [
                'score' => 5,
                'description' => 'Kunde inte bedöma',
            ],
            'environmental_facts' => [],
            'confidence' => 0.0,
        ];
    }
}
