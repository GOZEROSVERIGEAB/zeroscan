<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sammanfattning - Miljörapport</title>
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
            border-bottom: 2px solid #97d700;
        }
        .header h1 {
            font-size: 24px;
            color: #005151;
            margin-bottom: 8px;
        }
        .header p {
            color: #6b7280;
            font-size: 14px;
        }
        .period {
            background: #f3f4f6;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }
        .kpi-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .kpi-row {
            display: table-row;
        }
        .kpi-card {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }
        .kpi-value {
            font-size: 28px;
            font-weight: bold;
            color: #005151;
        }
        .kpi-label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #005151;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        .impact-grid {
            display: table;
            width: 100%;
        }
        .impact-item {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }
        .impact-value {
            font-size: 24px;
            font-weight: bold;
            color: #166534;
        }
        .impact-label {
            font-size: 10px;
            color: #6b7280;
        }
        .categories-table {
            width: 100%;
            border-collapse: collapse;
        }
        .categories-table th,
        .categories-table td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        .categories-table th {
            background: #f9fafb;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            color: #6b7280;
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
        <h1>Miljörapport - Sammanfattning</h1>
        <p>Genererad {{ $generatedAt->format('Y-m-d H:i') }}</p>
    </div>

    <div class="period">
        <strong>Rapportperiod:</strong> {{ $startDate->format('Y-m-d') }} till {{ $endDate->format('Y-m-d') }}
    </div>

    <div class="section">
        <div class="section-title">Nyckeltal</div>
        <div class="kpi-grid">
            <div class="kpi-row">
                <div class="kpi-card">
                    <div class="kpi-value">{{ number_format($kpis['total_items'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="kpi-label">Föremål återbrukade</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-value">{{ number_format($kpis['sessions'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="kpi-label">Besökare</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-value">{{ number_format(($kpis['estimated_value'] ?? 0) / 1000, 0, ',', ' ') }}k</div>
                    <div class="kpi-label">Uppskattat värde (kr)</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-value">{{ number_format($kpis['avg_condition'] ?? 0, 1, ',', ' ') }}</div>
                    <div class="kpi-label">Snittskick (1-5)</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Miljöpåverkan</div>
        <div class="impact-grid">
            <div class="impact-item">
                <div class="impact-value">{{ number_format(($impact['co2_kg'] ?? 0) / 1000, 1, ',', ' ') }}</div>
                <div class="impact-label">TON CO₂ BESPARAT</div>
            </div>
            <div class="impact-item">
                <div class="impact-value">{{ number_format(($impact['water_liters'] ?? 0) / 1000, 0, ',', ' ') }}</div>
                <div class="impact-label">M³ VATTEN SPARAT</div>
            </div>
            <div class="impact-item">
                <div class="impact-value">{{ number_format($impact['energy_kwh'] ?? 0, 0, ',', ' ') }}</div>
                <div class="impact-label">KWH ENERGI SPARAD</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Topp kategorier</div>
        <table class="categories-table">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th style="text-align: right">Antal</th>
                    <th style="text-align: right">CO₂ (kg)</th>
                    <th style="text-align: right">Värde (kr)</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_slice($categories ?? [], 0, 8) as $category)
                <tr>
                    <td>{{ $category['name'] }}</td>
                    <td style="text-align: right">{{ number_format($category['count'], 0, ',', ' ') }}</td>
                    <td style="text-align: right">{{ number_format($category['co2_savings'], 1, ',', ' ') }}</td>
                    <td style="text-align: right">{{ number_format($category['value'], 0, ',', ' ') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section" style="margin-top: 30px;">
        <div class="section-title">Källor & Metodik</div>
        <div style="background: #f9fafb; border-radius: 8px; padding: 15px; font-size: 10px; color: #6b7280;">
            <p style="margin-bottom: 10px;"><strong>AI-analys:</strong> Anthropic Claude (opus-4) - Bildanalys och kategorisering av föremål</p>
            <p style="margin-bottom: 10px;"><strong>CO2-beräkningar:</strong> Baserat på livscykelanalyser (LCA) från EPA, DEFRA och vetenskapliga publikationer</p>
            <p style="margin-bottom: 10px;"><strong>Vattenförbrukning:</strong> Water Footprint Network - produkt-specifika vattenfotavtryck</p>
            <p style="margin-bottom: 10px;"><strong>Energiförbrukning:</strong> IEA (International Energy Agency) och branschstandarder</p>
            <p style="margin-bottom: 10px;"><strong>Miljöekvivalenter:</strong></p>
            <ul style="margin: 5px 0 0 20px; padding: 0;">
                <li>Träd: EPA - 1 träd absorberar ~21 kg CO2/år</li>
                <li>Bilkörning: Naturvårdsverket - genomsnittlig bil ~120g CO2/km</li>
                <li>Duschar: Svenskt Vatten - genomsnittlig dusch ~65 liter</li>
                <li>Mobilladdningar: IEA - ~0.012 kWh per laddning</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>Denna rapport är genererad automatiskt av Scanit med AI-stöd från Anthropic Claude.</p>
        <p>Värden och miljöbesparingar är uppskattningar baserade på AI-analys och vetenskapliga källor. Faktiska värden kan variera.</p>
    </div>
</body>
</html>
