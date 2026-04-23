<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miljörapport</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #1f2937;
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #97d700;
        }
        .header h1 {
            font-size: 28px;
            color: #005151;
            margin-bottom: 8px;
        }
        .header p {
            color: #6b7280;
            font-size: 14px;
        }
        .period-box {
            background: linear-gradient(135deg, #005151 0%, #007070 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
        }
        .period-box .label {
            font-size: 11px;
            opacity: 0.8;
            text-transform: uppercase;
        }
        .period-box .dates {
            font-size: 18px;
            font-weight: bold;
        }
        .impact-cards {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .impact-card {
            display: table-cell;
            width: 33.33%;
            padding: 20px;
            text-align: center;
            vertical-align: top;
        }
        .impact-card.co2 {
            background: #dcfce7;
            border: 2px solid #86efac;
        }
        .impact-card.water {
            background: #dbeafe;
            border: 2px solid #93c5fd;
        }
        .impact-card.energy {
            background: #fef3c7;
            border: 2px solid #fcd34d;
        }
        .impact-card .icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .impact-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #1f2937;
        }
        .impact-card .unit {
            font-size: 14px;
            color: #6b7280;
        }
        .impact-card .label {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #005151;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }
        .equivalents-grid {
            display: table;
            width: 100%;
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
        }
        .equivalent-item {
            display: table-cell;
            width: 20%;
            text-align: center;
            padding: 10px;
        }
        .equivalent-item .emoji {
            font-size: 28px;
        }
        .equivalent-item .value {
            font-size: 20px;
            font-weight: bold;
            color: #005151;
        }
        .equivalent-item .label {
            font-size: 9px;
            color: #6b7280;
        }
        .categories-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .categories-table th,
        .categories-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        .categories-table th {
            background: #005151;
            color: white;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
        }
        .categories-table tr:nth-child(even) {
            background: #f9fafb;
        }
        .bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }
        .bar-fill {
            height: 100%;
            background: #97d700;
            border-radius: 4px;
        }
        .lifetime-section {
            background: linear-gradient(135deg, #005151 0%, #007070 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
        }
        .lifetime-section h3 {
            font-size: 20px;
            margin-bottom: 20px;
        }
        .lifetime-grid {
            display: table;
            width: 100%;
        }
        .lifetime-item {
            display: table-cell;
            width: 25%;
            padding: 10px;
        }
        .lifetime-item .value {
            font-size: 24px;
            font-weight: bold;
        }
        .lifetime-item .label {
            font-size: 10px;
            opacity: 0.8;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Miljörapport</h1>
        <p>Detaljerad analys av miljöpåverkan</p>
    </div>

    <div class="period-box">
        <div class="label">Rapportperiod</div>
        <div class="dates">{{ $startDate->format('Y-m-d') }} - {{ $endDate->format('Y-m-d') }}</div>
    </div>

    <div class="impact-cards">
        <div class="impact-card co2">
            <div class="value">{{ number_format(($impact['co2_kg'] ?? 0) / 1000, 1, ',', ' ') }}</div>
            <div class="unit">ton</div>
            <div class="label">CO₂ besparat</div>
        </div>
        <div class="impact-card water">
            <div class="value">{{ number_format(($impact['water_liters'] ?? 0) / 1000, 0, ',', ' ') }}</div>
            <div class="unit">m³</div>
            <div class="label">Vatten sparat</div>
        </div>
        <div class="impact-card energy">
            <div class="value">{{ number_format($impact['energy_kwh'] ?? 0, 0, ',', ' ') }}</div>
            <div class="unit">kWh</div>
            <div class="label">Energi sparad</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Vad motsvarar det?</div>
        <div class="equivalents-grid">
            <div class="equivalent-item">
                <div class="emoji">&#127794;</div>
                <div class="value">{{ number_format($impact['equivalents']['trees'] ?? 0, 0, ',', ' ') }}</div>
                <div class="label">träds årliga CO₂-upptag</div>
            </div>
            <div class="equivalent-item">
                <div class="emoji">&#128663;</div>
                <div class="value">{{ number_format($impact['equivalents']['car_km'] ?? 0, 0, ',', ' ') }}</div>
                <div class="label">km bilkörning</div>
            </div>
            <div class="equivalent-item">
                <div class="emoji">&#128703;</div>
                <div class="value">{{ number_format($impact['equivalents']['showers'] ?? 0, 0, ',', ' ') }}</div>
                <div class="label">duschar sparade</div>
            </div>
            <div class="equivalent-item">
                <div class="emoji">&#128241;</div>
                <div class="value">{{ number_format($impact['equivalents']['phone_charges'] ?? 0, 0, ',', ' ') }}</div>
                <div class="label">mobilladdningar</div>
            </div>
            <div class="equivalent-item">
                <div class="emoji">&#9992;&#65039;</div>
                <div class="value">{{ number_format($impact['equivalents']['flights_nyc'] ?? 0, 1, ',', ' ') }}</div>
                <div class="label">Sthlm-NYC flyg</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Besparing per kategori</div>
        <table class="categories-table">
            <thead>
                <tr>
                    <th style="width: 30%">Kategori</th>
                    <th style="width: 15%; text-align: right">Antal</th>
                    <th style="width: 20%">Andel</th>
                    <th style="width: 15%; text-align: right">CO₂ (kg)</th>
                    <th style="width: 20%; text-align: right">Värde (kr)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories ?? [] as $category)
                <tr>
                    <td>{{ $category['name'] }}</td>
                    <td style="text-align: right">{{ number_format($category['count'], 0, ',', ' ') }}</td>
                    <td>
                        <div class="bar">
                            <div class="bar-fill" style="width: {{ $category['percentage'] }}%"></div>
                        </div>
                    </td>
                    <td style="text-align: right">{{ number_format($category['co2_savings'], 1, ',', ' ') }}</td>
                    <td style="text-align: right">{{ number_format($category['value'], 0, ',', ' ') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($lifetime ?? false)
    <div class="section">
        <div class="lifetime-section">
            <h3>Livstidsstatistik</h3>
            <div class="lifetime-grid">
                <div class="lifetime-item">
                    <div class="value">{{ number_format($lifetime['total_items'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="label">föremål totalt</div>
                </div>
                <div class="lifetime-item">
                    <div class="value">{{ number_format(($lifetime['co2_kg'] ?? 0) / 1000, 1, ',', ' ') }} ton</div>
                    <div class="label">CO₂ totalt</div>
                </div>
                <div class="lifetime-item">
                    <div class="value">{{ number_format(($lifetime['water_liters'] ?? 0) / 1000, 0, ',', ' ') }} m³</div>
                    <div class="label">vatten totalt</div>
                </div>
                <div class="lifetime-item">
                    <div class="value">{{ number_format(($lifetime['value_sek'] ?? 0) / 1000, 0, ',', ' ') }}k kr</div>
                    <div class="label">värde totalt</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="section" style="page-break-inside: avoid;">
        <div class="section-title">Källor & Metodik</div>
        <div style="background: #f9fafb; border-radius: 8px; padding: 15px; font-size: 10px; color: #6b7280;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 50%; vertical-align: top; padding-right: 15px;">
                        <p style="margin-bottom: 8px;"><strong>AI-analys</strong></p>
                        <p style="margin-bottom: 5px;">Modell: Anthropic Claude (opus-4)</p>
                        <p style="margin-bottom: 5px;">Användning: Bildanalys, kategorisering, värdering</p>
                        <p style="margin-bottom: 12px;">Leverantör: Anthropic</p>

                        <p style="margin-bottom: 8px;"><strong>Datakällor</strong></p>
                        <ul style="margin: 0 0 0 15px; padding: 0; line-height: 1.6;">
                            <li>EPA - Environmental Protection Agency</li>
                            <li>DEFRA - UK Department for Environment</li>
                            <li>Water Footprint Network</li>
                            <li>IEA - International Energy Agency</li>
                            <li>Naturvårdsverket</li>
                            <li>Svenskt Vatten</li>
                        </ul>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding-left: 15px; border-left: 1px solid #e5e7eb;">
                        <p style="margin-bottom: 8px;"><strong>Beräkningsmetoder</strong></p>
                        <ul style="margin: 0 0 0 15px; padding: 0; line-height: 1.6;">
                            <li>CO2: Livscykelanalys (LCA) per produktkategori</li>
                            <li>Vatten: Produktspecifika vattenfotavtryck</li>
                            <li>Energi: Tillverkningsenergi per materialtyp</li>
                        </ul>

                        <p style="margin-top: 12px; margin-bottom: 8px;"><strong>Miljöekvivalenter</strong></p>
                        <ul style="margin: 0 0 0 15px; padding: 0; line-height: 1.6;">
                            <li>1 träd = 21 kg CO2/år (EPA)</li>
                            <li>1 km bil = 0.12 kg CO2 (Naturvårdsverket)</li>
                            <li>1 dusch = 65 liter (Svenskt Vatten)</li>
                            <li>1 mobilladdning = 0.012 kWh (IEA)</li>
                            <li>Stockholm-NYC = 1000 kg CO2 (ICAO)</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Genererad {{ $generatedAt->format('Y-m-d H:i') }} av Scanit med AI-stöd från Anthropic Claude</p>
        <p>Miljöberäkningar baseras på livscykelanalyser och vetenskapliga källor. Faktiska värden kan variera beroende på produktens ursprung.</p>
    </div>
</body>
</html>
