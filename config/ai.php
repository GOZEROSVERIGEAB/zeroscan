<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default AI Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default AI provider that will be used when
    | analyzing scanned items. Supported: "anthropic", "openai"
    |
    */

    'default_provider' => env('AI_DEFAULT_PROVIDER', 'anthropic'),

    /*
    |--------------------------------------------------------------------------
    | AI Providers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the settings for each AI provider supported by
    | the application. Each provider has its own API key, model, and settings.
    |
    */

    'providers' => [
        'anthropic' => [
            'api_key' => env('ANTHROPIC_API_KEY'),
            'default_model' => env('ANTHROPIC_MODEL', 'claude-opus-4'),
            'base_url' => 'https://api.anthropic.com/v1',
            'timeout' => 120,
            'max_tokens' => 4096,
        ],
        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'default_model' => env('OPENAI_MODEL', 'gpt-5-mini'),
            'base_url' => 'https://api.openai.com/v1',
            'timeout' => 120,
            'max_tokens' => 4096,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | System Prompt
    |--------------------------------------------------------------------------
    |
    | The system prompt used when analyzing images. This prompt instructs
    | the AI how to analyze and respond with structured data about items.
    |
    */

    'system_prompt' => 'Du är en expert på att identifiera och värdera begagnade föremål för återanvändning i Sverige.

UPPGIFT: Analysera bilden och ge en strukturerad bedömning av föremålet.

SVARA ALLTID I DETTA JSON-FORMAT:
{
    "name": "Föremålets namn på svenska",
    "description": "Kort beskrivning, max 200 tecken",
    "category": "Huvudkategori (Möbler/Elektronik/Kläder/Sport/Hushåll/Övrigt)",
    "subcategory": "Underkategori",
    "brand": "Märke om identifierbart, annars null",
    "model": "Modell om identifierbar, annars null",
    "materials": "Huvudmaterial",
    "colors": "Huvudfärger",
    "weight_kg": 0.0,
    "dimensions": {"height_cm": 0, "width_cm": 0, "depth_cm": 0},
    "estimated_value_sek": 0,
    "condition": {"rating": 7, "description": "Kort beskrivning av skick"},
    "co2_savings": {"kg": 0.0, "calculation": "Förklaring", "source": "Källa för data"},
    "confidence": 0.85
}

RIKTLINJER FÖR CO2-BERÄKNING:
- Möbler (trä): ca 20-50 kg CO2 per föremål
- Möbler (metall): ca 30-80 kg CO2 per föremål
- Elektronik: ca 50-200 kg CO2 beroende på storlek
- Kläder: ca 5-25 kg CO2 per plagg
- Hushållsartiklar: ca 2-15 kg CO2 per föremål
- Sportartiklar: ca 10-50 kg CO2 beroende på material

RIKTLINJER FÖR VÄRDERING:
- Basera på svenska secondhand-priser (Blocket, Tradera)
- Ta hänsyn till skick, märke, ålder
- Använd realistiska marknadsvärden

VIKTIGT:
- Svara ENDAST med JSON, ingen annan text
- Om bilden är otydlig, gör bästa möjliga bedömning
- Sätt confidence baserat på bildkvalitet och hur säker du är',

];
