<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miljöcertifikat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: linear-gradient(135deg, #005151 0%, #007070 50%, #97d700 100%);
            padding: 30px;
        }
        .certificate {
            background: white;
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .badge {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #97d700 0%, #7ab300 100%);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .badge-inner {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        .title {
            font-size: 32px;
            color: #005151;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 30px;
        }
        .impact-showcase {
            display: table;
            width: 100%;
            margin: 30px 0;
        }
        .impact-item {
            display: table-cell;
            width: 33.33%;
            padding: 20px;
            vertical-align: top;
        }
        .impact-item .emoji {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .impact-item .value {
            font-size: 36px;
            font-weight: bold;
            color: #005151;
        }
        .impact-item .unit {
            font-size: 16px;
            color: #6b7280;
        }
        .impact-item .label {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 5px;
        }
        .divider {
            width: 60%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #97d700, transparent);
            margin: 30px auto;
        }
        .equivalents {
            display: table;
            width: 100%;
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
        }
        .equivalent {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 10px;
        }
        .equivalent .emoji {
            font-size: 28px;
        }
        .equivalent .value {
            font-size: 18px;
            font-weight: bold;
            color: #005151;
        }
        .equivalent .label {
            font-size: 9px;
            color: #6b7280;
        }
        .period {
            margin-top: 30px;
            font-size: 12px;
            color: #9ca3af;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            font-size: 10px;
            color: #9ca3af;
        }
        .qr-placeholder {
            width: 80px;
            height: 80px;
            background: #f3f4f6;
            border-radius: 8px;
            margin: 20px auto 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="badge">
            <div class="badge-inner">&#127793;</div>
        </div>

        <h1 class="title">Miljöcertifikat</h1>
        <p class="subtitle">Intyg om positiv miljöpåverkan genom återbruk</p>

        <div class="impact-showcase">
            <div class="impact-item">
                <div class="emoji">&#127811;</div>
                <div class="value">{{ number_format(($impact['co2_kg'] ?? 0) / 1000, 1, ',', ' ') }}</div>
                <div class="unit">ton</div>
                <div class="label">CO₂ besparat</div>
            </div>
            <div class="impact-item">
                <div class="emoji">&#128167;</div>
                <div class="value">{{ number_format(($impact['water_liters'] ?? 0) / 1000, 0, ',', ' ') }}</div>
                <div class="unit">m³</div>
                <div class="label">Vatten sparat</div>
            </div>
            <div class="impact-item">
                <div class="emoji">&#9889;</div>
                <div class="value">{{ number_format($impact['energy_kwh'] ?? 0, 0, ',', ' ') }}</div>
                <div class="unit">kWh</div>
                <div class="label">Energi sparad</div>
            </div>
        </div>

        <div class="divider"></div>

        <p style="font-size: 14px; color: #6b7280; margin-bottom: 15px;">
            <strong>{{ number_format($kpis['total_items'] ?? 0, 0, ',', ' ') }}</strong> föremål har fått ett nytt liv!
        </p>

        <div class="equivalents">
            <div class="equivalent">
                <div class="emoji">&#127794;</div>
                <div class="value">{{ number_format($impact['equivalents']['trees'] ?? 0, 0, ',', ' ') }}</div>
                <div class="label">träds årliga CO₂-upptag</div>
            </div>
            <div class="equivalent">
                <div class="emoji">&#128663;</div>
                <div class="value">{{ number_format($impact['equivalents']['car_km'] ?? 0, 0, ',', ' ') }}</div>
                <div class="label">km bilkörning undviken</div>
            </div>
            <div class="equivalent">
                <div class="emoji">&#128703;</div>
                <div class="value">{{ number_format($impact['equivalents']['showers'] ?? 0, 0, ',', ' ') }}</div>
                <div class="label">duschar sparade</div>
            </div>
            <div class="equivalent">
                <div class="emoji">&#128241;</div>
                <div class="value">{{ number_format($impact['equivalents']['phone_charges'] ?? 0, 0, ',', ' ') }}</div>
                <div class="label">mobilladdningar</div>
            </div>
        </div>

        <div class="period">
            Period: {{ $startDate->format('Y-m-d') }} - {{ $endDate->format('Y-m-d') }}
        </div>

        <div class="footer">
            <p>Genererat {{ $generatedAt->format('Y-m-d') }} av Scanit med AI-stöd från Anthropic Claude</p>
            <p style="margin-top: 5px;">Tillsammans skapar vi en mer hållbar framtid genom återbruk!</p>
            <p style="margin-top: 10px; font-size: 8px; color: #b0b0b0;">
                Källor: EPA, DEFRA, Water Footprint Network, IEA, Naturvårdsverket, Svenskt Vatten.
                Beräkningar baseras på livscykelanalyser och AI-analys. Värden är uppskattningar.
            </p>
        </div>
    </div>
</body>
</html>
