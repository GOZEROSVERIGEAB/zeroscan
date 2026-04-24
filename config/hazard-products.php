<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Demo Hazardous Products Database
    |--------------------------------------------------------------------------
    |
    | Pre-configured demo products for the PreZero Germany Hazard Scanner demo.
    | These products are used for instant lookup when a matching EAN is scanned.
    |
    */

    'products' => [

        // Brake Cleaner - Flammable Aerosol
        '4027816000160' => [
            'product_name' => [
                'en' => 'Brake Cleaner Professional',
                'de' => 'Bremsenreiniger Professional',
            ],
            'manufacturer' => 'Würth GmbH',
            'un_number' => 'UN1950',
            'cas_number' => '64742-49-0',
            'hazard_classification' => [
                'ghs_class' => ['Flammable Aerosol Category 1', 'Aspiration Hazard Category 1'],
                'danger_level' => 'danger',
                'signal_word' => [
                    'en' => 'DANGER',
                    'de' => 'GEFAHR',
                ],
            ],
            'ghs_pictograms' => ['GHS02', 'GHS08'],
            'hazard_statements' => [
                ['code' => 'H222', 'text' => ['en' => 'Extremely flammable aerosol', 'de' => 'Extrem entzündbares Aerosol']],
                ['code' => 'H229', 'text' => ['en' => 'Pressurised container: May burst if heated', 'de' => 'Behälter steht unter Druck: Kann bei Erwärmung bersten']],
                ['code' => 'H304', 'text' => ['en' => 'May be fatal if swallowed and enters airways', 'de' => 'Kann bei Verschlucken und Eindringen in die Atemwege tödlich sein']],
                ['code' => 'H315', 'text' => ['en' => 'Causes skin irritation', 'de' => 'Verursacht Hautreizungen']],
                ['code' => 'H336', 'text' => ['en' => 'May cause drowsiness or dizziness', 'de' => 'Kann Schläfrigkeit und Benommenheit verursachen']],
            ],
            'precautionary_statements' => [
                'prevention' => [
                    ['code' => 'P210', 'text' => ['en' => 'Keep away from heat, sparks, open flames, hot surfaces', 'de' => 'Von Hitze, heißen Oberflächen, Funken, offenen Flammen fernhalten']],
                    ['code' => 'P211', 'text' => ['en' => 'Do not spray on an open flame or other ignition source', 'de' => 'Nicht gegen offene Flamme oder andere Zündquelle sprühen']],
                    ['code' => 'P251', 'text' => ['en' => 'Do not pierce or burn, even after use', 'de' => 'Nicht durchstechen oder verbrennen, auch nicht nach Gebrauch']],
                ],
                'response' => [
                    ['code' => 'P301+P310', 'text' => ['en' => 'IF SWALLOWED: Immediately call a POISON CENTER', 'de' => 'BEI VERSCHLUCKEN: Sofort GIFTINFORMATIONSZENTRUM anrufen']],
                    ['code' => 'P331', 'text' => ['en' => 'Do NOT induce vomiting', 'de' => 'KEIN Erbrechen herbeiführen']],
                ],
                'storage' => [
                    ['code' => 'P410+P412', 'text' => ['en' => 'Protect from sunlight. Do not expose to temperatures exceeding 50°C', 'de' => 'Vor Sonnenbestrahlung schützen. Nicht Temperaturen über 50°C aussetzen']],
                ],
                'disposal' => [
                    ['code' => 'P501', 'text' => ['en' => 'Dispose of contents/container to hazardous waste collection point', 'de' => 'Inhalt/Behälter einer Problemabfallentsorgung zuführen']],
                ],
            ],
            'handling_instructions' => [
                'ppe_required' => [
                    'en' => ['Safety glasses', 'Chemical-resistant gloves', 'Respiratory protection in poorly ventilated areas'],
                    'de' => ['Schutzbrille', 'Chemikalienbeständige Handschuhe', 'Atemschutz bei unzureichender Belüftung'],
                ],
                'ventilation' => [
                    'en' => 'Use only in well-ventilated areas',
                    'de' => 'Nur in gut belüfteten Bereichen verwenden',
                ],
                'temperature' => [
                    'en' => 'Store at 5-25°C, do not exceed 50°C',
                    'de' => 'Bei 5-25°C lagern, nicht über 50°C',
                ],
                'incompatible_materials' => [
                    'en' => ['Strong oxidizers', 'Strong acids', 'Strong alkalis'],
                    'de' => ['Starke Oxidationsmittel', 'Starke Säuren', 'Starke Laugen'],
                ],
            ],
            'emergency_info' => [
                'fire_fighting' => [
                    'en' => 'Use CO2, foam, or dry powder. Cool containers with water spray. Aerosol cans may explode when heated.',
                    'de' => 'CO2, Schaum oder Trockenpulver verwenden. Behälter mit Wassersprühstrahl kühlen. Aerosolbehälter können bei Erhitzung explodieren.',
                ],
                'spill_response' => [
                    'en' => 'Eliminate ignition sources. Ventilate area. Absorb with inert material. Dispose as hazardous waste.',
                    'de' => 'Zündquellen beseitigen. Bereich belüften. Mit inertem Material aufnehmen. Als Sondermüll entsorgen.',
                ],
                'first_aid' => [
                    'inhalation' => [
                        'en' => 'Move to fresh air. If symptoms persist, seek medical attention.',
                        'de' => 'An die frische Luft bringen. Bei anhaltenden Symptomen ärztlichen Rat einholen.',
                    ],
                    'skin_contact' => [
                        'en' => 'Wash thoroughly with soap and water. Remove contaminated clothing.',
                        'de' => 'Gründlich mit Seife und Wasser waschen. Kontaminierte Kleidung ausziehen.',
                    ],
                    'eye_contact' => [
                        'en' => 'Rinse cautiously with water for several minutes. Seek medical attention if irritation persists.',
                        'de' => 'Einige Minuten lang vorsichtig mit Wasser spülen. Bei anhaltender Reizung ärztlichen Rat einholen.',
                    ],
                    'ingestion' => [
                        'en' => 'Do NOT induce vomiting. Rinse mouth. Immediately call a poison center.',
                        'de' => 'KEIN Erbrechen herbeiführen. Mund ausspülen. Sofort Giftinformationszentrum anrufen.',
                    ],
                ],
            ],
            'disposal' => [
                'waste_code' => '16 05 04*',
                'method' => [
                    'en' => 'Dispose of completely emptied cans in metal recycling. Partially filled cans must be disposed as hazardous waste.',
                    'de' => 'Vollständig entleerte Dosen im Metallrecycling entsorgen. Teilweise gefüllte Dosen als Sondermüll entsorgen.',
                ],
                'special_requirements' => [
                    'en' => 'Do not puncture or incinerate. Must be collected by licensed hazardous waste contractor.',
                    'de' => 'Nicht durchstechen oder verbrennen. Muss von zugelassenem Sondermüllentsorger abgeholt werden.',
                ],
            ],
            'transport' => [
                'adr_class' => '2.1',
                'packing_group' => null,
                'special_provisions' => [
                    'en' => 'Limited quantities exemption available for containers ≤1L. Tunnel restriction code (D).',
                    'de' => 'Freistellung für begrenzte Mengen für Behälter ≤1L verfügbar. Tunnelbeschränkungscode (D).',
                ],
            ],
            'confidence' => 0.95,
        ],

        // Motor Oil - Environmental Hazard
        '5010667000128' => [
            'product_name' => [
                'en' => 'Motor Oil 5W-30 Synthetic',
                'de' => 'Motoröl 5W-30 Synthetisch',
            ],
            'manufacturer' => 'Castrol Ltd.',
            'un_number' => 'UN3082',
            'cas_number' => '64742-65-0',
            'hazard_classification' => [
                'ghs_class' => ['Hazardous to the aquatic environment, chronic Category 2'],
                'danger_level' => 'warning',
                'signal_word' => [
                    'en' => 'WARNING',
                    'de' => 'ACHTUNG',
                ],
            ],
            'ghs_pictograms' => ['GHS09'],
            'hazard_statements' => [
                ['code' => 'H411', 'text' => ['en' => 'Toxic to aquatic life with long lasting effects', 'de' => 'Giftig für Wasserorganismen mit langfristiger Wirkung']],
            ],
            'precautionary_statements' => [
                'prevention' => [
                    ['code' => 'P273', 'text' => ['en' => 'Avoid release to the environment', 'de' => 'Freisetzung in die Umwelt vermeiden']],
                ],
                'response' => [
                    ['code' => 'P391', 'text' => ['en' => 'Collect spillage', 'de' => 'Verschüttete Mengen aufnehmen']],
                ],
                'storage' => [],
                'disposal' => [
                    ['code' => 'P501', 'text' => ['en' => 'Dispose of contents/container as hazardous waste', 'de' => 'Inhalt/Behälter als Sondermüll entsorgen']],
                ],
            ],
            'handling_instructions' => [
                'ppe_required' => [
                    'en' => ['Oil-resistant gloves', 'Safety glasses', 'Protective clothing'],
                    'de' => ['Ölbeständige Handschuhe', 'Schutzbrille', 'Schutzkleidung'],
                ],
                'ventilation' => [
                    'en' => 'Good general ventilation should be sufficient',
                    'de' => 'Gute allgemeine Belüftung sollte ausreichend sein',
                ],
                'temperature' => [
                    'en' => 'Store at ambient temperature. Keep away from heat sources.',
                    'de' => 'Bei Umgebungstemperatur lagern. Von Wärmequellen fernhalten.',
                ],
                'incompatible_materials' => [
                    'en' => ['Strong oxidizers'],
                    'de' => ['Starke Oxidationsmittel'],
                ],
            ],
            'emergency_info' => [
                'fire_fighting' => [
                    'en' => 'Use foam, CO2, or dry chemical. Water spray may be used to cool closed containers.',
                    'de' => 'Schaum, CO2 oder Trockenlöschmittel verwenden. Wassersprühstrahl kann zum Kühlen geschlossener Behälter verwendet werden.',
                ],
                'spill_response' => [
                    'en' => 'Contain spill. Absorb with sand or vermiculite. Prevent entry into drains and water courses.',
                    'de' => 'Verschüttetes Material eindämmen. Mit Sand oder Vermiculit aufnehmen. Eindringen in Abflüsse und Gewässer verhindern.',
                ],
                'first_aid' => [
                    'inhalation' => [
                        'en' => 'Move to fresh air. Seek medical attention if symptoms occur.',
                        'de' => 'An die frische Luft bringen. Bei Symptomen ärztlichen Rat einholen.',
                    ],
                    'skin_contact' => [
                        'en' => 'Wash skin with soap and water. Remove contaminated clothing and wash before reuse.',
                        'de' => 'Haut mit Seife und Wasser waschen. Kontaminierte Kleidung ausziehen und vor erneutem Tragen waschen.',
                    ],
                    'eye_contact' => [
                        'en' => 'Rinse with water for at least 15 minutes. Seek medical attention if irritation persists.',
                        'de' => 'Mindestens 15 Minuten mit Wasser spülen. Bei anhaltender Reizung ärztlichen Rat einholen.',
                    ],
                    'ingestion' => [
                        'en' => 'Do not induce vomiting. Rinse mouth. Seek medical attention.',
                        'de' => 'Kein Erbrechen herbeiführen. Mund ausspülen. Ärztlichen Rat einholen.',
                    ],
                ],
            ],
            'disposal' => [
                'waste_code' => '13 02 05*',
                'method' => [
                    'en' => 'Collect used oil for recycling. Do not mix with other waste or substances.',
                    'de' => 'Altöl zum Recycling sammeln. Nicht mit anderen Abfällen oder Stoffen vermischen.',
                ],
                'special_requirements' => [
                    'en' => 'Used motor oil is classified as hazardous waste. Must be collected by licensed waste oil collector.',
                    'de' => 'Altmotoröl ist als Sondermüll eingestuft. Muss von zugelassenem Altölentsorger abgeholt werden.',
                ],
            ],
            'transport' => [
                'adr_class' => '9',
                'packing_group' => 'III',
                'special_provisions' => [
                    'en' => 'Marine pollutant. Special provision 274, 335, 601.',
                    'de' => 'Meeresschadstoff. Sondervorschrift 274, 335, 601.',
                ],
            ],
            'confidence' => 0.95,
        ],

        // Battery Acid - Corrosive
        '4006381333085' => [
            'product_name' => [
                'en' => 'Battery Acid (Sulfuric Acid 37%)',
                'de' => 'Batteriesäure (Schwefelsäure 37%)',
            ],
            'manufacturer' => 'Banner GmbH',
            'un_number' => 'UN2796',
            'cas_number' => '7664-93-9',
            'hazard_classification' => [
                'ghs_class' => ['Corrosive to metals Category 1', 'Skin corrosion Category 1A'],
                'danger_level' => 'danger',
                'signal_word' => [
                    'en' => 'DANGER',
                    'de' => 'GEFAHR',
                ],
            ],
            'ghs_pictograms' => ['GHS05', 'GHS07'],
            'hazard_statements' => [
                ['code' => 'H290', 'text' => ['en' => 'May be corrosive to metals', 'de' => 'Kann gegenüber Metallen korrosiv sein']],
                ['code' => 'H314', 'text' => ['en' => 'Causes severe skin burns and eye damage', 'de' => 'Verursacht schwere Verätzungen der Haut und schwere Augenschäden']],
            ],
            'precautionary_statements' => [
                'prevention' => [
                    ['code' => 'P260', 'text' => ['en' => 'Do not breathe mist/vapours', 'de' => 'Nebel/Dämpfe nicht einatmen']],
                    ['code' => 'P264', 'text' => ['en' => 'Wash hands thoroughly after handling', 'de' => 'Nach Gebrauch Hände gründlich waschen']],
                    ['code' => 'P280', 'text' => ['en' => 'Wear protective gloves/protective clothing/eye protection/face protection', 'de' => 'Schutzhandschuhe/Schutzkleidung/Augenschutz/Gesichtsschutz tragen']],
                ],
                'response' => [
                    ['code' => 'P301+P330+P331', 'text' => ['en' => 'IF SWALLOWED: Rinse mouth. Do NOT induce vomiting', 'de' => 'BEI VERSCHLUCKEN: Mund ausspülen. KEIN Erbrechen herbeiführen']],
                    ['code' => 'P303+P361+P353', 'text' => ['en' => 'IF ON SKIN: Take off immediately all contaminated clothing. Rinse skin with water', 'de' => 'BEI BERÜHRUNG MIT DER HAUT: Sofort alle kontaminierten Kleidungsstücke ausziehen. Haut mit Wasser abwaschen']],
                    ['code' => 'P305+P351+P338', 'text' => ['en' => 'IF IN EYES: Rinse cautiously with water for several minutes. Remove contact lenses if present and easy to do. Continue rinsing', 'de' => 'BEI KONTAKT MIT DEN AUGEN: Einige Minuten lang behutsam mit Wasser spülen. Kontaktlinsen entfernen, falls vorhanden und leicht möglich. Weiter spülen']],
                    ['code' => 'P310', 'text' => ['en' => 'Immediately call a POISON CENTER/doctor', 'de' => 'Sofort GIFTINFORMATIONSZENTRUM/Arzt anrufen']],
                ],
                'storage' => [
                    ['code' => 'P406', 'text' => ['en' => 'Store in corrosive resistant container with a resistant inner liner', 'de' => 'In korrosionsbeständigem Behälter mit widerstandsfähiger Innenauskleidung lagern']],
                ],
                'disposal' => [
                    ['code' => 'P501', 'text' => ['en' => 'Dispose of contents/container to hazardous waste facility', 'de' => 'Inhalt/Behälter einer Sondermüllentsorgungsanlage zuführen']],
                ],
            ],
            'handling_instructions' => [
                'ppe_required' => [
                    'en' => ['Face shield', 'Acid-resistant gloves (neoprene or PVC)', 'Chemical-resistant apron', 'Safety boots'],
                    'de' => ['Gesichtsschutz', 'Säurebeständige Handschuhe (Neopren oder PVC)', 'Chemikalienbeständige Schürze', 'Sicherheitsschuhe'],
                ],
                'ventilation' => [
                    'en' => 'Use with adequate ventilation. Local exhaust recommended.',
                    'de' => 'Bei ausreichender Belüftung verwenden. Lokale Absaugung empfohlen.',
                ],
                'temperature' => [
                    'en' => 'Store at 10-25°C in a cool, dry, well-ventilated area.',
                    'de' => 'Bei 10-25°C in einem kühlen, trockenen, gut belüfteten Bereich lagern.',
                ],
                'incompatible_materials' => [
                    'en' => ['Water (violent reaction when adding acid to water)', 'Metals', 'Organic materials', 'Bases', 'Oxidizers'],
                    'de' => ['Wasser (heftige Reaktion beim Zugeben von Säure zu Wasser)', 'Metalle', 'Organische Materialien', 'Basen', 'Oxidationsmittel'],
                ],
            ],
            'emergency_info' => [
                'fire_fighting' => [
                    'en' => 'Non-flammable but releases hydrogen gas on contact with metals. Use water spray to cool containers. Do not use direct water stream.',
                    'de' => 'Nicht brennbar, setzt aber bei Kontakt mit Metallen Wasserstoffgas frei. Behälter mit Wassersprühstrahl kühlen. Keinen direkten Wasserstrahl verwenden.',
                ],
                'spill_response' => [
                    'en' => 'Evacuate area. Neutralize with lime or soda ash. Absorb with inert material. Rinse area with large amounts of water.',
                    'de' => 'Bereich räumen. Mit Kite oder Soda neutralisieren. Mit inertem Material aufnehmen. Bereich mit viel Wasser spülen.',
                ],
                'first_aid' => [
                    'inhalation' => [
                        'en' => 'Remove to fresh air immediately. Give oxygen if breathing is difficult. Seek immediate medical attention.',
                        'de' => 'Sofort an die frische Luft bringen. Bei Atembeschwerden Sauerstoff geben. Sofort ärztliche Hilfe suchen.',
                    ],
                    'skin_contact' => [
                        'en' => 'Immediately flush with plenty of water for at least 20 minutes. Remove contaminated clothing while rinsing. Seek immediate medical attention.',
                        'de' => 'Sofort mit viel Wasser mindestens 20 Minuten lang spülen. Kontaminierte Kleidung beim Spülen entfernen. Sofort ärztliche Hilfe suchen.',
                    ],
                    'eye_contact' => [
                        'en' => 'Immediately rinse with water for at least 30 minutes, holding eyelids apart. Seek immediate medical attention.',
                        'de' => 'Sofort mindestens 30 Minuten mit Wasser spülen, dabei die Augenlider auseinanderhalten. Sofort ärztliche Hilfe suchen.',
                    ],
                    'ingestion' => [
                        'en' => 'Do NOT induce vomiting. Rinse mouth with water. Give small sips of water if conscious. Seek immediate medical attention.',
                        'de' => 'KEIN Erbrechen herbeiführen. Mund mit Wasser spülen. Bei Bewusstsein kleine Schlucke Wasser geben. Sofort ärztliche Hilfe suchen.',
                    ],
                ],
            ],
            'disposal' => [
                'waste_code' => '16 06 06*',
                'method' => [
                    'en' => 'Must be neutralized before disposal. Neutralized solution can be disposed through wastewater treatment. Concentrated acid requires hazardous waste disposal.',
                    'de' => 'Muss vor der Entsorgung neutralisiert werden. Neutralisierte Lösung kann über Abwasserbehandlung entsorgt werden. Konzentrierte Säure erfordert Sondermüllentsorgung.',
                ],
                'special_requirements' => [
                    'en' => 'Lead-acid batteries must be collected separately and recycled. Never dispose of battery acid in regular waste.',
                    'de' => 'Blei-Säure-Batterien müssen getrennt gesammelt und recycelt werden. Batteriesäure niemals im normalen Abfall entsorgen.',
                ],
            ],
            'transport' => [
                'adr_class' => '8',
                'packing_group' => 'II',
                'special_provisions' => [
                    'en' => 'Corrosive liquid, acidic, inorganic. Must be transported in acid-resistant containers.',
                    'de' => 'Ätzende Flüssigkeit, sauer, anorganisch. Muss in säurebeständigen Behältern transportiert werden.',
                ],
            ],
            'confidence' => 0.95,
        ],

        // Paint Thinner - Flammable Liquid
        '4007591904001' => [
            'product_name' => [
                'en' => 'Nitro Thinner / Paint Thinner',
                'de' => 'Nitro-Verdünnung / Lackverdünner',
            ],
            'manufacturer' => 'Clou GmbH',
            'un_number' => 'UN1263',
            'cas_number' => '64742-95-6',
            'hazard_classification' => [
                'ghs_class' => ['Flammable liquid Category 2', 'Aspiration hazard Category 1', 'Skin irritation Category 2', 'STOT SE Category 3'],
                'danger_level' => 'danger',
                'signal_word' => [
                    'en' => 'DANGER',
                    'de' => 'GEFAHR',
                ],
            ],
            'ghs_pictograms' => ['GHS02', 'GHS07', 'GHS08'],
            'hazard_statements' => [
                ['code' => 'H225', 'text' => ['en' => 'Highly flammable liquid and vapour', 'de' => 'Flüssigkeit und Dampf leicht entzündbar']],
                ['code' => 'H304', 'text' => ['en' => 'May be fatal if swallowed and enters airways', 'de' => 'Kann bei Verschlucken und Eindringen in die Atemwege tödlich sein']],
                ['code' => 'H315', 'text' => ['en' => 'Causes skin irritation', 'de' => 'Verursacht Hautreizungen']],
                ['code' => 'H336', 'text' => ['en' => 'May cause drowsiness or dizziness', 'de' => 'Kann Schläfrigkeit und Benommenheit verursachen']],
                ['code' => 'H361d', 'text' => ['en' => 'Suspected of damaging the unborn child', 'de' => 'Kann vermutlich das Kind im Mutterleib schädigen']],
            ],
            'precautionary_statements' => [
                'prevention' => [
                    ['code' => 'P210', 'text' => ['en' => 'Keep away from heat, sparks, open flames, hot surfaces. No smoking', 'de' => 'Von Hitze, Funken, offenen Flammen, heißen Oberflächen fernhalten. Nicht rauchen']],
                    ['code' => 'P233', 'text' => ['en' => 'Keep container tightly closed', 'de' => 'Behälter dicht geschlossen halten']],
                    ['code' => 'P240', 'text' => ['en' => 'Ground and bond container and receiving equipment', 'de' => 'Behälter und Auffanganlage erden']],
                    ['code' => 'P241', 'text' => ['en' => 'Use explosion-proof equipment', 'de' => 'Explosionsgeschützte Geräte verwenden']],
                ],
                'response' => [
                    ['code' => 'P301+P310', 'text' => ['en' => 'IF SWALLOWED: Immediately call a POISON CENTER', 'de' => 'BEI VERSCHLUCKEN: Sofort GIFTINFORMATIONSZENTRUM anrufen']],
                    ['code' => 'P331', 'text' => ['en' => 'Do NOT induce vomiting', 'de' => 'KEIN Erbrechen herbeiführen']],
                    ['code' => 'P370+P378', 'text' => ['en' => 'In case of fire: Use foam, CO2 or dry powder to extinguish', 'de' => 'Bei Brand: Schaum, CO2 oder Trockenpulver zum Löschen verwenden']],
                ],
                'storage' => [
                    ['code' => 'P403+P235', 'text' => ['en' => 'Store in a well-ventilated place. Keep cool', 'de' => 'An einem gut belüfteten Ort aufbewahren. Kühl halten']],
                    ['code' => 'P405', 'text' => ['en' => 'Store locked up', 'de' => 'Unter Verschluss aufbewahren']],
                ],
                'disposal' => [
                    ['code' => 'P501', 'text' => ['en' => 'Dispose of contents/container to hazardous waste collection point', 'de' => 'Inhalt/Behälter einer Sondermüllsammelstelle zuführen']],
                ],
            ],
            'handling_instructions' => [
                'ppe_required' => [
                    'en' => ['Safety glasses', 'Solvent-resistant gloves (nitrile)', 'Respiratory protection with organic vapor filter', 'Anti-static clothing'],
                    'de' => ['Schutzbrille', 'Lösungsmittelbeständige Handschuhe (Nitril)', 'Atemschutz mit Organikdampffilter', 'Antistatische Kleidung'],
                ],
                'ventilation' => [
                    'en' => 'Use only with adequate ventilation. Use local exhaust at point of vapor generation.',
                    'de' => 'Nur bei ausreichender Belüftung verwenden. Lokale Absaugung am Entstehungsort der Dämpfe verwenden.',
                ],
                'temperature' => [
                    'en' => 'Store between 10-25°C. Keep away from heat sources. Flash point: -4°C',
                    'de' => 'Zwischen 10-25°C lagern. Von Wärmequellen fernhalten. Flammpunkt: -4°C',
                ],
                'incompatible_materials' => [
                    'en' => ['Strong oxidizers', 'Strong acids', 'Halogens', 'Peroxides'],
                    'de' => ['Starke Oxidationsmittel', 'Starke Säuren', 'Halogene', 'Peroxide'],
                ],
            ],
            'emergency_info' => [
                'fire_fighting' => [
                    'en' => 'Use foam, CO2, dry chemical or water fog. Do not use water jet. Vapors are heavier than air and may travel to ignition sources.',
                    'de' => 'Schaum, CO2, Trockenlöschmittel oder Wassernebel verwenden. Keinen Wasserstrahl verwenden. Dämpfe sind schwerer als Luft und können zu Zündquellen wandern.',
                ],
                'spill_response' => [
                    'en' => 'Eliminate all ignition sources. Evacuate area. Ventilate. Absorb with inert material (sand, vermiculite). Collect in closed containers for disposal.',
                    'de' => 'Alle Zündquellen beseitigen. Bereich räumen. Belüften. Mit inertem Material (Sand, Vermiculit) aufnehmen. In geschlossenen Behältern zur Entsorgung sammeln.',
                ],
                'first_aid' => [
                    'inhalation' => [
                        'en' => 'Move to fresh air. If not breathing, give artificial respiration. Seek immediate medical attention.',
                        'de' => 'An die frische Luft bringen. Bei Atemstillstand künstliche Beatmung durchführen. Sofort ärztliche Hilfe suchen.',
                    ],
                    'skin_contact' => [
                        'en' => 'Remove contaminated clothing. Wash skin with soap and water. If irritation persists, seek medical attention.',
                        'de' => 'Kontaminierte Kleidung ausziehen. Haut mit Seife und Wasser waschen. Bei anhaltender Reizung ärztlichen Rat einholen.',
                    ],
                    'eye_contact' => [
                        'en' => 'Rinse immediately with plenty of water for at least 15 minutes. Seek medical attention.',
                        'de' => 'Sofort mit viel Wasser mindestens 15 Minuten spülen. Ärztlichen Rat einholen.',
                    ],
                    'ingestion' => [
                        'en' => 'Do NOT induce vomiting - aspiration hazard. Rinse mouth. Immediately call a poison center.',
                        'de' => 'KEIN Erbrechen herbeiführen - Aspirationsgefahr. Mund ausspülen. Sofort Giftinformationszentrum anrufen.',
                    ],
                ],
            ],
            'disposal' => [
                'waste_code' => '14 06 03*',
                'method' => [
                    'en' => 'Collect in closed containers. Do not empty into drains. Hand over to licensed hazardous waste disposal facility.',
                    'de' => 'In geschlossenen Behältern sammeln. Nicht in Abflüsse entleeren. An zugelassene Sondermüllentsorgungsanlage übergeben.',
                ],
                'special_requirements' => [
                    'en' => 'Waste solvent may be recyclable. Contact licensed solvent recycler. Empty containers may still contain vapors.',
                    'de' => 'Altlösungsmittel kann recycelbar sein. Zugelassenen Lösungsmittel-Recycler kontaktieren. Leere Behälter können noch Dämpfe enthalten.',
                ],
            ],
            'transport' => [
                'adr_class' => '3',
                'packing_group' => 'II',
                'special_provisions' => [
                    'en' => 'Flash point below 23°C. Tunnel restriction code (D/E). Must not be transported with food.',
                    'de' => 'Flammpunkt unter 23°C. Tunnelbeschränkungscode (D/E). Darf nicht mit Lebensmitteln transportiert werden.',
                ],
            ],
            'confidence' => 0.95,
        ],

        // Industrial Degreaser - Irritant
        '4031142011016' => [
            'product_name' => [
                'en' => 'Industrial Degreaser Concentrate',
                'de' => 'Industrie-Entfetter Konzentrat',
            ],
            'manufacturer' => 'Dr. Wack GmbH',
            'un_number' => null,
            'cas_number' => '111-76-2',
            'hazard_classification' => [
                'ghs_class' => ['Acute toxicity Category 4 (oral)', 'Skin irritation Category 2', 'Eye irritation Category 2'],
                'danger_level' => 'warning',
                'signal_word' => [
                    'en' => 'WARNING',
                    'de' => 'ACHTUNG',
                ],
            ],
            'ghs_pictograms' => ['GHS07'],
            'hazard_statements' => [
                ['code' => 'H302', 'text' => ['en' => 'Harmful if swallowed', 'de' => 'Gesundheitsschädlich bei Verschlucken']],
                ['code' => 'H315', 'text' => ['en' => 'Causes skin irritation', 'de' => 'Verursacht Hautreizungen']],
                ['code' => 'H319', 'text' => ['en' => 'Causes serious eye irritation', 'de' => 'Verursacht schwere Augenreizung']],
            ],
            'precautionary_statements' => [
                'prevention' => [
                    ['code' => 'P264', 'text' => ['en' => 'Wash hands thoroughly after handling', 'de' => 'Nach Gebrauch Hände gründlich waschen']],
                    ['code' => 'P280', 'text' => ['en' => 'Wear protective gloves/eye protection', 'de' => 'Schutzhandschuhe/Augenschutz tragen']],
                ],
                'response' => [
                    ['code' => 'P301+P312', 'text' => ['en' => 'IF SWALLOWED: Call a POISON CENTER if you feel unwell', 'de' => 'BEI VERSCHLUCKEN: Bei Unwohlsein GIFTINFORMATIONSZENTRUM anrufen']],
                    ['code' => 'P302+P352', 'text' => ['en' => 'IF ON SKIN: Wash with plenty of water', 'de' => 'BEI BERÜHRUNG MIT DER HAUT: Mit viel Wasser waschen']],
                    ['code' => 'P305+P351+P338', 'text' => ['en' => 'IF IN EYES: Rinse cautiously with water for several minutes', 'de' => 'BEI KONTAKT MIT DEN AUGEN: Einige Minuten lang behutsam mit Wasser spülen']],
                ],
                'storage' => [
                    ['code' => 'P402', 'text' => ['en' => 'Store in a dry place', 'de' => 'An einem trockenen Ort aufbewahren']],
                ],
                'disposal' => [
                    ['code' => 'P501', 'text' => ['en' => 'Dispose of contents/container in accordance with local regulations', 'de' => 'Inhalt/Behälter gemäß örtlichen Vorschriften entsorgen']],
                ],
            ],
            'handling_instructions' => [
                'ppe_required' => [
                    'en' => ['Safety glasses', 'Chemical-resistant gloves', 'Protective apron'],
                    'de' => ['Schutzbrille', 'Chemikalienbeständige Handschuhe', 'Schutzschürze'],
                ],
                'ventilation' => [
                    'en' => 'Use with adequate ventilation to minimize exposure',
                    'de' => 'Bei ausreichender Belüftung verwenden, um Exposition zu minimieren',
                ],
                'temperature' => [
                    'en' => 'Store at room temperature (15-25°C). Protect from frost.',
                    'de' => 'Bei Raumtemperatur (15-25°C) lagern. Vor Frost schützen.',
                ],
                'incompatible_materials' => [
                    'en' => ['Strong acids', 'Strong oxidizers', 'Chlorine bleach'],
                    'de' => ['Starke Säuren', 'Starke Oxidationsmittel', 'Chlorbleiche'],
                ],
            ],
            'emergency_info' => [
                'fire_fighting' => [
                    'en' => 'Water-based product. Use water spray, foam, dry powder or CO2. No special fire hazard.',
                    'de' => 'Wasserbasiertes Produkt. Wassersprühstrahl, Schaum, Trockenpulver oder CO2 verwenden. Keine besondere Brandgefahr.',
                ],
                'spill_response' => [
                    'en' => 'Absorb with inert material. Prevent from entering drains. Rinse area with water.',
                    'de' => 'Mit inertem Material aufnehmen. Eindringen in Abflüsse verhindern. Bereich mit Wasser spülen.',
                ],
                'first_aid' => [
                    'inhalation' => [
                        'en' => 'Move to fresh air. Seek medical attention if symptoms persist.',
                        'de' => 'An die frische Luft bringen. Bei anhaltenden Symptomen ärztlichen Rat einholen.',
                    ],
                    'skin_contact' => [
                        'en' => 'Wash with plenty of water and soap. Remove contaminated clothing.',
                        'de' => 'Mit viel Wasser und Seife waschen. Kontaminierte Kleidung ausziehen.',
                    ],
                    'eye_contact' => [
                        'en' => 'Rinse with water for at least 15 minutes. If irritation persists, seek medical attention.',
                        'de' => 'Mindestens 15 Minuten mit Wasser spülen. Bei anhaltender Reizung ärztlichen Rat einholen.',
                    ],
                    'ingestion' => [
                        'en' => 'Rinse mouth with water. Do not induce vomiting. Seek medical attention if symptoms occur.',
                        'de' => 'Mund mit Wasser spülen. Kein Erbrechen herbeiführen. Bei Symptomen ärztlichen Rat einholen.',
                    ],
                ],
            ],
            'disposal' => [
                'waste_code' => '20 01 29*',
                'method' => [
                    'en' => 'Concentrated product should be disposed as hazardous waste. Diluted cleaning solutions may be disposed via wastewater (check local regulations).',
                    'de' => 'Konzentriertes Produkt als Sondermüll entsorgen. Verdünnte Reinigungslösungen können über Abwasser entsorgt werden (örtliche Vorschriften beachten).',
                ],
                'special_requirements' => [
                    'en' => 'Empty containers can be recycled. Ensure containers are completely empty and rinsed.',
                    'de' => 'Leere Behälter können recycelt werden. Sicherstellen, dass Behälter vollständig leer und gespült sind.',
                ],
            ],
            'transport' => [
                'adr_class' => 'Not classified as dangerous goods for transport',
                'packing_group' => null,
                'special_provisions' => [
                    'en' => 'Not subject to ADR regulations for transport in concentrated form below certain thresholds.',
                    'de' => 'Unterliegt nicht den ADR-Vorschriften für den Transport in konzentrierter Form unter bestimmten Schwellenwerten.',
                ],
            ],
            'confidence' => 0.95,
        ],

    ],

];
