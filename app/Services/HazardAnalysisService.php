<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class HazardAnalysisService
{
    protected const API_VERSION = '2023-06-01';

    protected const MODEL = 'claude-opus-4-7';

    protected const MAX_TOKENS = 8192;

    protected const TIMEOUT = 120;

    protected string $apiKey;

    protected string $baseUrl = 'https://api.anthropic.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.api_key', '');

        if (empty($this->apiKey)) {
            Log::warning('HazardAnalysisService: Anthropic API key is not configured');
        }
    }

    /**
     * Look up a product by EAN/barcode in the demo database.
     */
    public function lookupByBarcode(string $barcode, string $locale = 'en'): ?array
    {
        $products = config('hazard-products.products', []);

        if (! isset($products[$barcode])) {
            return null;
        }

        $product = $products[$barcode];

        return $this->localizeProduct($product, $locale);
    }

    /**
     * Analyze a product label image using AI.
     */
    public function analyzeImage(string $base64Image, string $mimeType, string $locale = 'en'): array
    {
        if (empty($this->apiKey)) {
            throw new RuntimeException('Anthropic API key is not configured');
        }

        $systemPrompt = $this->getSystemPrompt($locale);
        $userPrompt = $locale === 'de'
            ? 'Analysieren Sie dieses Gefahrstoff-Etikett und geben Sie umfassende Sicherheitsinformationen auf Deutsch.'
            : 'Analyze this hazardous material label and provide comprehensive safety information in English.';

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
                            'text' => $systemPrompt,
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
                                    'text' => $userPrompt,
                                ],
                            ],
                        ],
                    ],
                ]);

            if (! $response->successful()) {
                Log::error('HazardAnalysisService: API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new RuntimeException("Anthropic API error: {$response->status()}");
            }

            $responseData = $response->json();
            $usage = $responseData['usage'] ?? [];

            Log::info('HazardAnalysisService: API call successful', [
                'model' => self::MODEL,
                'input_tokens' => $usage['input_tokens'] ?? 0,
                'output_tokens' => $usage['output_tokens'] ?? 0,
                'cache_creation_input_tokens' => $usage['cache_creation_input_tokens'] ?? 0,
                'cache_read_input_tokens' => $usage['cache_read_input_tokens'] ?? 0,
            ]);

            return $this->parseResponse($responseData);

        } catch (RequestException $e) {
            Log::error('HazardAnalysisService: Request exception', [
                'message' => $e->getMessage(),
                'response' => $e->response?->body(),
            ]);
            throw new RuntimeException("Anthropic API request failed: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Get the system prompt for hazard analysis.
     */
    protected function getSystemPrompt(string $locale): string
    {
        $language = $locale === 'de' ? 'German' : 'English';

        return <<<PROMPT
You are a hazardous materials expert for PreZero International waste management.

TASK: Analyze the product label image and provide comprehensive safety information.
RESPOND IN: {$language}

IMPORTANT: Respond ONLY with valid JSON, no other text.

JSON RESPONSE STRUCTURE:
{
    "product_name": "string - product name",
    "manufacturer": "string or null - manufacturer name if visible",
    "un_number": "UN#### or null - UN transport number if applicable",
    "cas_number": "string or null - CAS registry number if visible",
    "hazard_classification": {
        "ghs_class": ["array of GHS hazard classes"],
        "danger_level": "danger|warning|none",
        "signal_word": "DANGER|WARNING|GEFAHR|ACHTUNG|none"
    },
    "ghs_pictograms": ["GHS01", "GHS02", etc. - array of applicable GHS pictogram codes],
    "hazard_statements": [
        {"code": "H###", "text": "hazard statement text"}
    ],
    "precautionary_statements": {
        "prevention": [{"code": "P###", "text": "prevention statement"}],
        "response": [{"code": "P###", "text": "response statement"}],
        "storage": [{"code": "P###", "text": "storage statement"}],
        "disposal": [{"code": "P###", "text": "disposal statement"}]
    },
    "handling_instructions": {
        "ppe_required": ["array of required PPE"],
        "ventilation": "ventilation requirements",
        "temperature": "temperature storage requirements",
        "incompatible_materials": ["array of incompatible materials"]
    },
    "emergency_info": {
        "fire_fighting": "fire fighting measures",
        "spill_response": "spill response procedures",
        "first_aid": {
            "inhalation": "first aid for inhalation",
            "skin_contact": "first aid for skin contact",
            "eye_contact": "first aid for eye contact",
            "ingestion": "first aid for ingestion"
        }
    },
    "disposal": {
        "waste_code": "European waste code or null",
        "method": "disposal method description",
        "special_requirements": "special disposal requirements"
    },
    "transport": {
        "adr_class": "ADR transport class",
        "packing_group": "I|II|III or null",
        "special_provisions": "transport special provisions"
    },
    "confidence": 0.85
}

GHS PICTOGRAM CODES:
- GHS01: Explosive (bomb exploding)
- GHS02: Flammable (flame)
- GHS03: Oxidizer (flame over circle)
- GHS04: Compressed Gas (gas cylinder)
- GHS05: Corrosive (corrosion)
- GHS06: Toxic (skull and crossbones)
- GHS07: Irritant/Harmful (exclamation mark)
- GHS08: Health Hazard (health hazard symbol)
- GHS09: Environmental Hazard (dead tree and fish)

IMPORTANT NOTES:
- If information is not visible on the label, provide reasonable defaults based on the product type
- Always include the most relevant safety information
- Be accurate with H and P statement codes
- If you cannot identify the product, set confidence below 0.5
- All text responses should be in {$language}
PROMPT;
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
            Log::warning('HazardAnalysisService: Failed to parse JSON response', [
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

        return [
            'product_name' => $parsed['product_name'] ?? $defaults['product_name'],
            'manufacturer' => $parsed['manufacturer'] ?? null,
            'un_number' => $parsed['un_number'] ?? null,
            'cas_number' => $parsed['cas_number'] ?? null,
            'hazard_classification' => array_merge(
                $defaults['hazard_classification'],
                $parsed['hazard_classification'] ?? []
            ),
            'ghs_pictograms' => $parsed['ghs_pictograms'] ?? [],
            'hazard_statements' => $parsed['hazard_statements'] ?? [],
            'precautionary_statements' => array_merge(
                $defaults['precautionary_statements'],
                $parsed['precautionary_statements'] ?? []
            ),
            'handling_instructions' => array_merge(
                $defaults['handling_instructions'],
                $parsed['handling_instructions'] ?? []
            ),
            'emergency_info' => array_merge(
                $defaults['emergency_info'],
                $parsed['emergency_info'] ?? []
            ),
            'disposal' => array_merge(
                $defaults['disposal'],
                $parsed['disposal'] ?? []
            ),
            'transport' => array_merge(
                $defaults['transport'],
                $parsed['transport'] ?? []
            ),
            'confidence' => (float) ($parsed['confidence'] ?? 0.5),
        ];
    }

    /**
     * Get the default response structure.
     */
    protected function getDefaultResponse(): array
    {
        return [
            'product_name' => 'Unknown Product',
            'manufacturer' => null,
            'un_number' => null,
            'cas_number' => null,
            'hazard_classification' => [
                'ghs_class' => [],
                'danger_level' => 'none',
                'signal_word' => 'none',
            ],
            'ghs_pictograms' => [],
            'hazard_statements' => [],
            'precautionary_statements' => [
                'prevention' => [],
                'response' => [],
                'storage' => [],
                'disposal' => [],
            ],
            'handling_instructions' => [
                'ppe_required' => [],
                'ventilation' => '',
                'temperature' => '',
                'incompatible_materials' => [],
            ],
            'emergency_info' => [
                'fire_fighting' => '',
                'spill_response' => '',
                'first_aid' => [
                    'inhalation' => '',
                    'skin_contact' => '',
                    'eye_contact' => '',
                    'ingestion' => '',
                ],
            ],
            'disposal' => [
                'waste_code' => null,
                'method' => '',
                'special_requirements' => '',
            ],
            'transport' => [
                'adr_class' => '',
                'packing_group' => null,
                'special_provisions' => '',
            ],
            'confidence' => 0.0,
        ];
    }

    /**
     * Localize a product from the demo database to the requested language.
     */
    protected function localizeProduct(array $product, string $locale): array
    {
        $localized = [];

        foreach ($product as $key => $value) {
            if (is_array($value)) {
                // Check if this is a localized field (has 'en' and 'de' keys)
                if (isset($value['en']) && isset($value['de'])) {
                    $localized[$key] = $value[$locale] ?? $value['en'];
                } else {
                    // Recursively localize nested arrays
                    $localized[$key] = $this->localizeArray($value, $locale);
                }
            } else {
                $localized[$key] = $value;
            }
        }

        return $localized;
    }

    /**
     * Recursively localize an array.
     */
    protected function localizeArray(array $array, string $locale): array
    {
        $localized = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                // Check if this is a localized field
                if (isset($value['en']) && isset($value['de'])) {
                    $localized[$key] = $value[$locale] ?? $value['en'];
                } elseif (isset($value['text']) && is_array($value['text']) && isset($value['text']['en'])) {
                    // Handle statements with localized text
                    $localized[$key] = [
                        'code' => $value['code'] ?? '',
                        'text' => $value['text'][$locale] ?? $value['text']['en'],
                    ];
                } else {
                    // Recursively localize
                    $localized[$key] = $this->localizeArray($value, $locale);
                }
            } else {
                $localized[$key] = $value;
            }
        }

        return $localized;
    }
}
