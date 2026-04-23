<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRD ESRS E5 Rapport</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #1f2937;
            padding: 40px;
        }
        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3b82f6;
        }
        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 14px;
            color: #6b7280;
            font-weight: normal;
        }
        .compliance-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .meta-info {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .meta-info table {
            width: 100%;
        }
        .meta-info td {
            padding: 5px 0;
        }
        .meta-info .label {
            color: #6b7280;
            width: 150px;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        .metrics-grid {
            display: table;
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .metrics-row {
            display: table-row;
        }
        .metrics-row:nth-child(even) {
            background: #f9fafb;
        }
        .metric-cell {
            display: table-cell;
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        .metric-code {
            font-size: 10px;
            font-weight: bold;
            color: #3b82f6;
            background: #dbeafe;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .metric-name {
            font-weight: 500;
        }
        .metric-value {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            text-align: right;
        }
        .metric-unit {
            font-size: 11px;
            color: #6b7280;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th,
        .data-table td {
            padding: 10px 12px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }
        .data-table th {
            background: #1e40af;
            color: white;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
        }
        .data-table tr:nth-child(even) {
            background: #f9fafb;
        }
        .comparison-grid {
            display: table;
            width: 100%;
            background: #f9fafb;
            border-radius: 8px;
            padding: 15px;
        }
        .comparison-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 10px;
        }
        .comparison-item .change {
            font-size: 20px;
            font-weight: bold;
        }
        .comparison-item .change.positive {
            color: #16a34a;
        }
        .comparison-item .change.negative {
            color: #dc2626;
        }
        .comparison-item .label {
            font-size: 10px;
            color: #6b7280;
        }
        .notes {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 15px;
            font-size: 10px;
        }
        .notes h4 {
            color: #92400e;
            margin-bottom: 8px;
        }
        .notes ul {
            margin-left: 15px;
            color: #78350f;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CSRD Hållbarhetsrapport</h1>
        <h2>ESRS E5 - Resursanvändning & Cirkulär Ekonomi</h2>
    </div>

    <div class="compliance-badge">ESRS E5 COMPLIANCE</div>

    <div class="meta-info">
        <table>
            <tr>
                <td class="label">Rapportperiod:</td>
                <td><strong>{{ $startDate->format('Y-m-d') }} - {{ $endDate->format('Y-m-d') }}</strong></td>
            </tr>
            <tr>
                <td class="label">Genererad:</td>
                <td>{{ $generatedAt->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Standard:</td>
                <td>European Sustainability Reporting Standards (ESRS)</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">ESRS E5 Nyckeltal</div>
        <div class="metrics-grid">
            <div class="metrics-row">
                <div class="metric-cell" style="width: 80px">
                    <span class="metric-code">E5-4</span>
                </div>
                <div class="metric-cell" style="width: 200px">
                    <span class="metric-name">Materialinflöden</span>
                </div>
                <div class="metric-cell metric-value">
                    {{ number_format($metrics['material_inflows'] ?? 0, 0, ',', ' ') }}
                    <span class="metric-unit">kg</span>
                </div>
            </div>
            <div class="metrics-row">
                <div class="metric-cell">
                    <span class="metric-code">E5-2</span>
                </div>
                <div class="metric-cell">
                    <span class="metric-name">Återbruksgrad</span>
                </div>
                <div class="metric-cell metric-value">
                    {{ number_format($metrics['reuse_rate'] ?? 0, 1, ',', ' ') }}
                    <span class="metric-unit">%</span>
                </div>
            </div>
            <div class="metrics-row">
                <div class="metric-cell">
                    <span class="metric-code">E5-3</span>
                </div>
                <div class="metric-cell">
                    <span class="metric-name">Genomsnittlig produktkvalitet</span>
                </div>
                <div class="metric-cell metric-value">
                    {{ number_format($metrics['avg_condition'] ?? 0, 2, ',', ' ') }}
                    <span class="metric-unit">/5</span>
                </div>
            </div>
            <div class="metrics-row">
                <div class="metric-cell">
                    <span class="metric-code">E5-4</span>
                </div>
                <div class="metric-cell">
                    <span class="metric-name">Avfall förhindrat</span>
                </div>
                <div class="metric-cell metric-value">
                    {{ number_format($metrics['waste_prevented'] ?? 0, 0, ',', ' ') }}
                    <span class="metric-unit">kg</span>
                </div>
            </div>
            <div class="metrics-row">
                <div class="metric-cell">
                    <span class="metric-code">E5-5</span>
                </div>
                <div class="metric-cell">
                    <span class="metric-name">Cirkulärt ekonomiskt värde</span>
                </div>
                <div class="metric-cell metric-value">
                    {{ number_format($metrics['circular_value'] ?? 0, 0, ',', ' ') }}
                    <span class="metric-unit">SEK</span>
                </div>
            </div>
            <div class="metrics-row">
                <div class="metric-cell">
                    <span class="metric-code">KPI</span>
                </div>
                <div class="metric-cell">
                    <span class="metric-name">Antal föremål behandlade</span>
                </div>
                <div class="metric-cell metric-value">
                    {{ number_format($metrics['items_count'] ?? 0, 0, ',', ' ') }}
                    <span class="metric-unit">st</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Periodjämförelse</div>
        <div class="comparison-grid">
            <div class="comparison-item">
                <div class="change {{ ($comparison['items_change'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($comparison['items_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($comparison['items_change'] ?? 0, 1) }}%
                </div>
                <div class="label">Föremål</div>
            </div>
            <div class="comparison-item">
                <div class="change {{ ($comparison['co2_change'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($comparison['co2_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($comparison['co2_change'] ?? 0, 1) }}%
                </div>
                <div class="label">CO₂-besparing</div>
            </div>
            <div class="comparison-item">
                <div class="change {{ ($comparison['value_change'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($comparison['value_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($comparison['value_change'] ?? 0, 1) }}%
                </div>
                <div class="label">Ekonomiskt värde</div>
            </div>
            <div class="comparison-item">
                <div class="change {{ ($comparison['weight_change'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($comparison['weight_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($comparison['weight_change'] ?? 0, 1) }}%
                </div>
                <div class="label">Materialvikt</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Fördelning per kategori</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th style="text-align: right">Antal</th>
                    <th style="text-align: right">Andel</th>
                    <th style="text-align: right">Vikt (kg)</th>
                    <th style="text-align: right">CO₂ (kg)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories ?? [] as $category)
                <tr>
                    <td>{{ $category['name'] }}</td>
                    <td style="text-align: right">{{ number_format($category['count'], 0, ',', ' ') }}</td>
                    <td style="text-align: right">{{ number_format($category['percentage'], 1) }}%</td>
                    <td style="text-align: right">{{ number_format($category['weight'] ?? 0, 1, ',', ' ') }}</td>
                    <td style="text-align: right">{{ number_format($category['co2_savings'], 1, ',', ' ') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(count($facilities ?? []) > 1)
    <div class="section">
        <div class="section-title">Fördelning per anläggning</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Anläggning</th>
                    <th style="text-align: right">Föremål</th>
                    <th style="text-align: right">CO₂ (kg)</th>
                    <th style="text-align: right">Värde (kr)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facilities as $facility)
                <tr>
                    <td>{{ $facility['name'] }}</td>
                    <td style="text-align: right">{{ number_format($facility['items'], 0, ',', ' ') }}</td>
                    <td style="text-align: right">{{ number_format($facility['co2'], 1, ',', ' ') }}</td>
                    <td style="text-align: right">{{ number_format($facility['value'], 0, ',', ' ') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="notes">
        <h4>Metodologiska noter</h4>
        <ul>
            <li>Materialinflöden beräknas baserat på genomsnittsvikter per produktkategori.</li>
            <li>Återbruksgrad estimeras genom att jämföra registrerade föremål med uppskattad avfallsvolym.</li>
            <li>CO₂-besparingar baseras på livscykelanalyser och branschdata.</li>
            <li>Ekonomiskt värde är AI-baserade uppskattningar av marknadsvärde.</li>
        </ul>
    </div>

    <div class="section" style="margin-top: 20px; page-break-inside: avoid;">
        <div class="section-title">Källor & AI-metodik</div>
        <div style="background: #f3f4f6; border-radius: 8px; padding: 15px; font-size: 9px; color: #6b7280;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 50%; vertical-align: top; padding-right: 15px;">
                        <p style="margin-bottom: 6px;"><strong style="color: #1e40af;">AI-analys & Bildbearbetning</strong></p>
                        <ul style="margin: 0 0 10px 15px; padding: 0; line-height: 1.5;">
                            <li>Modell: Anthropic Claude (opus-4)</li>
                            <li>Leverantör: Anthropic</li>
                            <li>Användning: Bildanalys, kategorisering, värdering, skickbedömning</li>
                        </ul>

                        <p style="margin-bottom: 6px;"><strong style="color: #1e40af;">ESRS E5 Standarder</strong></p>
                        <ul style="margin: 0 0 0 15px; padding: 0; line-height: 1.5;">
                            <li>E5-1: Policyer för resursanvändning</li>
                            <li>E5-2: Åtgärder och resurser</li>
                            <li>E5-3: Mål för resursanvändning</li>
                            <li>E5-4: Resursflöden (in/ut)</li>
                            <li>E5-5: Avfallshantering</li>
                        </ul>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding-left: 15px; border-left: 1px solid #e5e7eb;">
                        <p style="margin-bottom: 6px;"><strong style="color: #1e40af;">Datakällor för beräkningar</strong></p>
                        <ul style="margin: 0 0 10px 15px; padding: 0; line-height: 1.5;">
                            <li>EPA - Environmental Protection Agency (USA)</li>
                            <li>DEFRA - UK Department for Environment</li>
                            <li>Naturvårdsverket (Sverige)</li>
                            <li>IPCC - Intergovernmental Panel on Climate Change</li>
                            <li>ISO 14040/14044 - Livscykelanalys</li>
                        </ul>

                        <p style="margin-bottom: 6px;"><strong style="color: #1e40af;">Beräkningsmetoder</strong></p>
                        <ul style="margin: 0 0 0 15px; padding: 0; line-height: 1.5;">
                            <li>CO₂: LCA per produktkategori och material</li>
                            <li>Vikt: Kategoribaserade genomsnittsvärden</li>
                            <li>Värde: AI-estimering baserad på skick och marknad</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p><strong>CSRD-kompatibel rapport enligt ESRS E5</strong></p>
        <p>Genererad av Scanit med AI-stöd från Anthropic Claude - {{ $generatedAt->format('Y-m-d H:i') }}</p>
        <p>Denna rapport är avsedd som underlag för hållbarhetsredovisning. Verifiera data med revisor vid extern rapportering.</p>
        <p style="margin-top: 5px; font-size: 8px;">Alla värden är uppskattningar baserade på AI-analys och vetenskapliga källor enligt ISO 14040/14044.</p>
    </div>
</body>
</html>
