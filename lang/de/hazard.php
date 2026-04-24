<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Hazard Scanner German Translations
    |--------------------------------------------------------------------------
    */

    'title' => 'Gefahrstoff-Scanner',
    'demo_badge' => 'DEMO',
    'subtitle' => 'Scannen Sie Gefahrstoff-Etiketten für Sicherheitsinformationen',

    // Actions
    'scan_barcode' => 'Barcode scannen',
    'take_photo' => 'Foto aufnehmen',
    'upload_image' => 'Bild hochladen',
    'scan_another' => 'Weiteres Produkt scannen',
    'reset' => 'Zurücksetzen',

    // Camera & Scanner
    'camera_permission' => 'Kameraberechtigung erforderlich zum Scannen von Barcodes',
    'camera_not_available' => 'Kamera auf diesem Gerät nicht verfügbar',
    'scanning_barcode' => 'Kamera auf Barcode richten...',
    'processing' => 'Produkt wird analysiert...',
    'initializing_camera' => 'Kamera wird initialisiert...',

    // Result sections
    'product_info' => 'Produktinformationen',
    'manufacturer' => 'Hersteller',
    'un_number' => 'UN-Nummer',
    'cas_number' => 'CAS-Nummer',
    'hazard_class' => 'Gefahrenklassifizierung',
    'ghs_pictograms' => 'GHS-Piktogramme',
    'hazard_statements' => 'Gefahrenhinweise (H)',
    'precautionary_statements' => 'Sicherheitshinweise (P)',
    'prevention' => 'Prävention',
    'response' => 'Reaktion',
    'storage' => 'Lagerung',
    'disposal' => 'Entsorgung',
    'handling' => 'Handhabungshinweise',
    'ppe_required' => 'Erforderliche PSA',
    'ventilation' => 'Belüftung',
    'temperature' => 'Temperaturanforderungen',
    'incompatible' => 'Unverträgliche Materialien',
    'emergency' => 'Notfallinformationen',
    'fire_fighting' => 'Brandbekämpfung',
    'spill_response' => 'Maßnahmen bei Verschütten',
    'first_aid' => 'Erste Hilfe',
    'inhalation' => 'Einatmen',
    'skin_contact' => 'Hautkontakt',
    'eye_contact' => 'Augenkontakt',
    'ingestion' => 'Verschlucken',
    'disposal_info' => 'Entsorgungsinformationen',
    'waste_code' => 'Abfallschlüssel',
    'disposal_method' => 'Entsorgungsmethode',
    'special_requirements' => 'Besondere Anforderungen',
    'transport' => 'Transportinformationen',
    'adr_class' => 'ADR-Klasse',
    'packing_group' => 'Verpackungsgruppe',
    'transport_provisions' => 'Sondervorschriften',

    // Signal words
    'danger' => 'GEFAHR',
    'warning' => 'ACHTUNG',

    // GHS pictogram names
    'ghs01' => 'Explosiv',
    'ghs02' => 'Entzündbar',
    'ghs03' => 'Oxidierend',
    'ghs04' => 'Komprimiertes Gas',
    'ghs05' => 'Ätzend',
    'ghs06' => 'Giftig',
    'ghs07' => 'Reizend',
    'ghs08' => 'Gesundheitsgefahr',
    'ghs09' => 'Umweltgefahr',

    // Errors
    'error_title' => 'Analysefehler',
    'error_not_found' => 'Produkt nicht in Datenbank gefunden. Versuchen Sie, ein Foto des Etiketts aufzunehmen.',
    'error_analysis_failed' => 'Produktetikett konnte nicht analysiert werden. Bitte versuchen Sie es mit einem klareren Bild.',
    'error_no_image' => 'Kein Bild für die Analyse bereitgestellt.',

    // Footer
    'ai_disclaimer' => 'KI-gestützte Analyse. Beziehen Sie sich immer auf das offizielle Sicherheitsdatenblatt (SDB) für vollständige Informationen.',
    'powered_by' => 'Bereitgestellt von',

    // Instructions
    'instructions_title' => 'Anleitung',
    'instruction_1' => 'Scannen Sie den Barcode auf dem Produkt für sofortige Abfrage',
    'instruction_2' => 'Oder fotografieren Sie das Produktetikett für KI-Analyse',
    'instruction_3' => 'Sehen Sie vollständige Sicherheits- und Handhabungsinformationen',

    // Confidence
    'confidence' => 'Konfidenz',
    'high_confidence' => 'Hohe Konfidenz',
    'medium_confidence' => 'Mittlere Konfidenz',
    'low_confidence' => 'Niedrige Konfidenz - mit SDB verifizieren',

    // Analysis steps
    'step_detecting' => 'Produkt wird erkannt...',
    'step_analyzing' => 'Gefahren werden analysiert...',
    'step_extracting' => 'Sicherheitsdaten werden extrahiert...',
    'step_complete' => 'Analyse abgeschlossen!',
    'step_detecting_short' => 'Erkennen',
    'step_analyzing_short' => 'Analysieren',
    'step_extracting_short' => 'Extrahieren',
    'step_complete_short' => 'Fertig',

    // Actions
    'cancel' => 'Abbrechen',

];
