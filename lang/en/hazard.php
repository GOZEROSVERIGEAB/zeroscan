<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Hazard Scanner English Translations
    |--------------------------------------------------------------------------
    */

    'title' => 'Hazard Scanner',
    'demo_badge' => 'DEMO',
    'subtitle' => 'Scan hazardous product labels for safety information',

    // Actions
    'scan_barcode' => 'Scan Barcode',
    'take_photo' => 'Take Photo',
    'upload_image' => 'Upload Image',
    'scan_another' => 'Scan Another Product',
    'reset' => 'Reset',

    // Camera & Scanner
    'camera_permission' => 'Camera permission is required to scan barcodes',
    'camera_not_available' => 'Camera not available on this device',
    'scanning_barcode' => 'Point camera at barcode...',
    'processing' => 'Analyzing product...',
    'initializing_camera' => 'Initializing camera...',

    // Result sections
    'product_info' => 'Product Information',
    'manufacturer' => 'Manufacturer',
    'un_number' => 'UN Number',
    'cas_number' => 'CAS Number',
    'hazard_class' => 'Hazard Classification',
    'ghs_pictograms' => 'GHS Pictograms',
    'hazard_statements' => 'Hazard Statements (H)',
    'precautionary_statements' => 'Precautionary Statements (P)',
    'prevention' => 'Prevention',
    'response' => 'Response',
    'storage' => 'Storage',
    'disposal' => 'Disposal',
    'handling' => 'Handling Instructions',
    'ppe_required' => 'PPE Required',
    'ventilation' => 'Ventilation',
    'temperature' => 'Temperature Requirements',
    'incompatible' => 'Incompatible Materials',
    'emergency' => 'Emergency Information',
    'fire_fighting' => 'Fire Fighting',
    'spill_response' => 'Spill Response',
    'first_aid' => 'First Aid',
    'inhalation' => 'Inhalation',
    'skin_contact' => 'Skin Contact',
    'eye_contact' => 'Eye Contact',
    'ingestion' => 'Ingestion',
    'disposal_info' => 'Disposal Information',
    'waste_code' => 'Waste Code',
    'disposal_method' => 'Disposal Method',
    'special_requirements' => 'Special Requirements',
    'transport' => 'Transport Information',
    'adr_class' => 'ADR Class',
    'packing_group' => 'Packing Group',
    'transport_provisions' => 'Special Provisions',

    // Signal words
    'danger' => 'DANGER',
    'warning' => 'WARNING',

    // GHS pictogram names
    'ghs01' => 'Explosive',
    'ghs02' => 'Flammable',
    'ghs03' => 'Oxidizer',
    'ghs04' => 'Compressed Gas',
    'ghs05' => 'Corrosive',
    'ghs06' => 'Toxic',
    'ghs07' => 'Irritant',
    'ghs08' => 'Health Hazard',
    'ghs09' => 'Environmental Hazard',

    // Errors
    'error_title' => 'Analysis Error',
    'error_not_found' => 'Product not found in database. Try taking a photo of the label.',
    'error_analysis_failed' => 'Could not analyze the product label. Please try again with a clearer image.',
    'error_no_image' => 'No image provided for analysis.',

    // Footer
    'ai_disclaimer' => 'AI-assisted analysis. Always refer to official Safety Data Sheet (SDS) for complete information.',
    'powered_by' => 'Powered by',

    // Instructions
    'instructions_title' => 'How to Use',
    'instruction_1' => 'Scan the barcode on the product for instant lookup',
    'instruction_2' => 'Or take a photo of the product label for AI analysis',
    'instruction_3' => 'View complete safety and handling information',

    // Confidence
    'confidence' => 'Confidence',
    'high_confidence' => 'High confidence',
    'medium_confidence' => 'Medium confidence',
    'low_confidence' => 'Low confidence - verify with SDS',

    // Analysis steps
    'step_detecting' => 'Detecting product...',
    'step_analyzing' => 'Analyzing hazards...',
    'step_extracting' => 'Extracting safety data...',
    'step_complete' => 'Analysis complete!',
    'step_detecting_short' => 'Detect',
    'step_analyzing_short' => 'Analyze',
    'step_extracting_short' => 'Extract',
    'step_complete_short' => 'Done',

    // Actions
    'cancel' => 'Cancel',

];
