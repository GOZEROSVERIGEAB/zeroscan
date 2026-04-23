<!DOCTYPE html>
<html lang="sv" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ __('scanit.email.report_title') }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        :root {
            color-scheme: light;
            supported-color-schemes: light;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #1a2634;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            width: 100% !important;
            min-width: 100%;
        }
        .wrapper {
            width: 100%;
            background-color: #f0f4f8;
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        .header {
            background: linear-gradient(135deg, #005151 0%, #006666 50%, #97d700 100%);
            padding: 50px 40px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="30" r="3" fill="rgba(255,255,255,0.08)"/><circle cx="50" cy="70" r="2.5" fill="rgba(255,255,255,0.06)"/><circle cx="90" cy="80" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="90" r="2" fill="rgba(255,255,255,0.05)"/></svg>');
            background-size: 100px 100px;
            opacity: 0.5;
        }
        .header-content {
            position: relative;
            z-index: 1;
        }
        .header-logo {
            max-width: 180px;
            max-height: 70px;
            margin-bottom: 25px;
        }
        .header-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 8px 24px;
            margin-bottom: 20px;
        }
        .header-badge-text {
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header-title {
            color: #ffffff;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header-subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 18px;
            font-weight: 500;
        }
        .header-items-count {
            display: inline-block;
            background: #97d700;
            color: #1a2634;
            padding: 4px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 14px;
            margin-top: 15px;
        }
        .greeting-section {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafb 100%);
            padding: 35px 40px 25px;
            text-align: center;
            border-bottom: 1px solid #e5e9ee;
        }
        .greeting-emoji {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .greeting-text {
            font-size: 20px;
            color: #1a2634;
            font-weight: 600;
        }
        .greeting-name {
            color: #005151;
        }
        .greeting-subtext {
            font-size: 15px;
            color: #64748b;
            margin-top: 8px;
            line-height: 1.5;
        }
        .stats-section {
            padding: 40px;
            background: #ffffff;
        }
        .stats-title {
            font-size: 13px;
            font-weight: 700;
            color: #005151;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            margin-bottom: 25px;
        }
        .stats-grid {
            width: 100%;
            border-spacing: 12px;
        }
        .stat-card {
            background: linear-gradient(145deg, #f0f9f0 0%, #e8f5e8 100%);
            border-radius: 20px;
            padding: 28px 20px;
            text-align: center;
            border: 2px solid #97d700;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(151, 215, 0, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        .stat-icon {
            font-size: 36px;
            margin-bottom: 12px;
            display: block;
        }
        .stat-value {
            font-size: 36px;
            font-weight: 800;
            color: #005151;
            line-height: 1;
            margin-bottom: 8px;
        }
        .stat-unit {
            font-size: 18px;
            font-weight: 600;
            color: #006666;
        }
        .stat-label {
            font-size: 13px;
            color: #4a6741;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-top: 5px;
        }
        .impact-section {
            background: linear-gradient(135deg, #005151 0%, #006666 100%);
            padding: 45px 40px;
            margin: 0 30px;
            border-radius: 24px;
            position: relative;
            overflow: hidden;
        }
        .impact-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(151, 215, 0, 0.3) 0%, transparent 70%);
            pointer-events: none;
        }
        .impact-title {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            margin-bottom: 30px;
        }
        .impact-title-accent {
            color: #97d700;
        }
        .impact-grid {
            width: 100%;
            border-spacing: 15px;
        }
        .impact-item {
            text-align: center;
            padding: 20px 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            backdrop-filter: blur(10px);
        }
        .impact-icon {
            font-size: 42px;
            margin-bottom: 12px;
            display: block;
        }
        .impact-value {
            font-size: 28px;
            font-weight: 800;
            color: #97d700;
            line-height: 1;
        }
        .impact-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 8px;
            line-height: 1.4;
        }
        .items-section {
            padding: 40px;
            background: #ffffff;
        }
        .items-title {
            font-size: 22px;
            font-weight: 700;
            color: #1a2634;
            margin-bottom: 8px;
        }
        .items-subtitle {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 25px;
        }
        .item-card {
            background: #ffffff;
            border: 1px solid #e5e9ee;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }
        .item-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #97d700 0%, #005151 100%);
        }
        .item-header {
            margin-bottom: 15px;
        }
        .item-name {
            font-size: 17px;
            font-weight: 700;
            color: #1a2634;
            margin-bottom: 4px;
        }
        .item-category {
            font-size: 13px;
            color: #64748b;
        }
        .item-category-badge {
            display: inline-block;
            background: #f0f4f8;
            color: #005151;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .item-stats {
            width: 100%;
            border-spacing: 8px;
        }
        .item-stat {
            background: linear-gradient(145deg, #f8fafb 0%, #f0f4f8 100%);
            border-radius: 10px;
            padding: 12px 10px;
            text-align: center;
        }
        .item-stat-value {
            font-size: 16px;
            font-weight: 700;
            color: #005151;
        }
        .item-stat-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }
        .item-fact {
            background: linear-gradient(135deg, #fef9e7 0%, #fdf5d8 100%);
            border-radius: 12px;
            padding: 14px 16px;
            margin-top: 15px;
            border-left: 3px solid #f59e0b;
        }
        .item-fact-icon {
            font-size: 16px;
            margin-right: 8px;
        }
        .item-fact-text {
            font-size: 13px;
            color: #92400e;
            font-style: italic;
            line-height: 1.5;
        }
        .cta-section {
            padding: 40px;
            background: linear-gradient(180deg, #ffffff 0%, #f0f4f8 100%);
            text-align: center;
        }
        .cta-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        .cta-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a2634;
            margin-bottom: 12px;
        }
        .cta-text {
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
            max-width: 400px;
            margin: 0 auto 25px;
        }
        .cta-highlight {
            background: linear-gradient(135deg, #005151 0%, #006666 100%);
            color: #ffffff;
            padding: 20px 30px;
            border-radius: 16px;
            display: inline-block;
        }
        .cta-highlight-text {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .cta-highlight-value {
            font-size: 28px;
            font-weight: 800;
            color: #97d700;
        }
        .share-section {
            padding: 30px 40px;
            background: #f8fafb;
            text-align: center;
            border-top: 1px solid #e5e9ee;
        }
        .share-text {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 15px;
        }
        .share-hashtag {
            display: inline-block;
            background: linear-gradient(135deg, #97d700 0%, #7cb300 100%);
            color: #1a2634;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
        }
        .footer {
            background: #1a2634;
            padding: 40px;
            text-align: center;
        }
        .footer-brand {
            margin-bottom: 20px;
        }
        .footer-brand-text {
            color: #97d700;
            font-size: 20px;
            font-weight: 700;
        }
        .footer-powered {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        .footer-divider {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #97d700, transparent);
            margin: 20px auto;
        }
        .footer-text {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .footer-links {
            margin-bottom: 20px;
        }
        .footer-link {
            color: #97d700;
            text-decoration: none;
            font-size: 13px;
            margin: 0 10px;
        }
        .footer-timestamp {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.4);
        }
        .footer-copyright {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.3);
            margin-top: 15px;
        }

        /* Mobile Responsive */
        @media only screen and (max-width: 600px) {
            .wrapper {
                padding: 20px 10px;
            }
            .container {
                border-radius: 16px;
            }
            .header {
                padding: 35px 25px;
            }
            .header-title {
                font-size: 26px;
            }
            .header-subtitle {
                font-size: 16px;
            }
            .greeting-section,
            .stats-section,
            .items-section,
            .cta-section,
            .footer {
                padding: 30px 25px;
            }
            .impact-section {
                margin: 0 15px;
                padding: 35px 25px;
            }
            .stat-value {
                font-size: 28px;
            }
            .impact-value {
                font-size: 22px;
            }
            .items-title {
                font-size: 20px;
            }
            .cta-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; margin: 0 auto;">
            <tr>
                <td>
                    <div class="container">
                        <!-- Header -->
                        <div class="header">
                            <div class="header-content">
                                @if($logoUrl)
                                    <img src="{{ $logoUrl }}" alt="{{ $stationName }}" class="header-logo">
                                @endif

                                <div class="header-badge">
                                    <span class="header-badge-text">Miljörapport</span>
                                </div>

                                <h1 class="header-title">Din insats gör skillnad!</h1>
                                <p class="header-subtitle">Tack för att du valde återbruk</p>

                                <div class="header-items-count">
                                    {{ $itemCount }} {{ $itemCount === 1 ? 'föremål' : 'föremål' }} registrerade
                                </div>
                            </div>
                        </div>

                        <!-- Greeting Section -->
                        <div class="greeting-section">
                            <div class="greeting-emoji">&#127807;</div>
                            @if($visitorName)
                                <p class="greeting-text">Hej <span class="greeting-name">{{ $visitorName }}</span>!</p>
                            @else
                                <p class="greeting-text">Hej miljövän!</p>
                            @endif
                            <p class="greeting-subtext">
                                Genom att ge dina saker ett nytt liv har du bidragit till en mer hållbar framtid.
                                Här är en sammanfattning av din positiva miljöpåverkan.
                            </p>
                        </div>

                        <!-- Main Stats Section -->
                        <div class="stats-section">
                            <div class="stats-title">Din miljöbesparing</div>

                            <table role="presentation" class="stats-grid" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td width="50%" valign="top" style="padding: 8px;">
                                        <div class="stat-card">
                                            <span class="stat-icon">&#127795;</span>
                                            <div class="stat-value">{{ number_format($totalCo2, 1, ',', ' ') }}</div>
                                            <span class="stat-unit">kg</span>
                                            <div class="stat-label">CO&#8322; besparat</div>
                                        </div>
                                    </td>
                                    <td width="50%" valign="top" style="padding: 8px;">
                                        <div class="stat-card">
                                            <span class="stat-icon">&#128167;</span>
                                            <div class="stat-value">{{ number_format($totalWater, 0, ',', ' ') }}</div>
                                            <span class="stat-unit">liter</span>
                                            <div class="stat-label">Vatten besparat</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" valign="top" style="padding: 8px;">
                                        <div class="stat-card">
                                            <span class="stat-icon">&#9889;</span>
                                            <div class="stat-value">{{ number_format($totalEnergy, 1, ',', ' ') }}</div>
                                            <span class="stat-unit">kWh</span>
                                            <div class="stat-label">Energi besparat</div>
                                        </div>
                                    </td>
                                    <td width="50%" valign="top" style="padding: 8px;">
                                        <div class="stat-card">
                                            <span class="stat-icon">&#9850;</span>
                                            <div class="stat-value">{{ $itemCount }}</div>
                                            <span class="stat-unit">st</span>
                                            <div class="stat-label">Föremål återbrukas</div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Environmental Impact Comparisons -->
                        <div class="impact-section">
                            <h2 class="impact-title">Vad betyder det <span class="impact-title-accent">egentligen?</span></h2>

                            <table role="presentation" class="impact-grid" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td width="50%" valign="top" style="padding: 8px;">
                                        <div class="impact-item">
                                            <span class="impact-icon">&#127794;</span>
                                            <div class="impact-value">{{ number_format($treesEquivalent, 1, ',', ' ') }}</div>
                                            <div class="impact-label">träds årliga<br>CO&#8322;-upptag</div>
                                        </div>
                                    </td>
                                    <td width="50%" valign="top" style="padding: 8px;">
                                        <div class="impact-item">
                                            <span class="impact-icon">&#128663;</span>
                                            <div class="impact-value">{{ number_format($carKmEquivalent, 0, ',', ' ') }} km</div>
                                            <div class="impact-label">bilkörning<br>undviken</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" valign="top" style="padding: 8px;">
                                        <div class="impact-item">
                                            <span class="impact-icon">&#128703;</span>
                                            <div class="impact-value">{{ number_format($showerEquivalent, 0, ',', ' ') }}</div>
                                            <div class="impact-label">duschar<br>sparade</div>
                                        </div>
                                    </td>
                                    <td width="50%" valign="top" style="padding: 8px;">
                                        <div class="impact-item">
                                            <span class="impact-icon">&#128241;</span>
                                            <div class="impact-value">{{ number_format($phoneChargesEquivalent, 0, ',', ' ') }}</div>
                                            <div class="impact-label">mobilladdningar<br>sparade</div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Items Section -->
                        <div class="items-section">
                            <h2 class="items-title">Dina registrerade föremål</h2>
                            <p class="items-subtitle">Här är detaljerna för varje föremål du lämnat till återbruk</p>

                            @foreach($inventories as $index => $inventory)
                                <div class="item-card">
                                    <div class="item-header">
                                        <div class="item-name">{{ $inventory->name ?? __('scanit.unknown_item') }}</div>
                                        <div class="item-category">
                                            @if($inventory->category)
                                                <span class="item-category-badge">{{ $inventory->category }}</span>
                                            @endif
                                            @if($inventory->brand)
                                                <span style="margin-left: 8px; color: #64748b;">{{ $inventory->brand }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <table role="presentation" class="item-stats" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td width="33%" style="padding: 4px;">
                                                <div class="item-stat">
                                                    <div class="item-stat-value">{{ number_format($inventory->co2_savings ?? 0, 1, ',', ' ') }} kg</div>
                                                    <div class="item-stat-label">CO&#8322; besparat</div>
                                                </div>
                                            </td>
                                            <td width="33%" style="padding: 4px;">
                                                <div class="item-stat">
                                                    <div class="item-stat-value">{{ number_format($inventory->estimated_value ?? 0, 0, ',', ' ') }} kr</div>
                                                    <div class="item-stat-label">Uppskattat värde</div>
                                                </div>
                                            </td>
                                            <td width="33%" style="padding: 4px;">
                                                <div class="item-stat">
                                                    @if($inventory->condition_rating)
                                                        <div class="item-stat-value">{{ $inventory->condition_rating }}/10</div>
                                                        <div class="item-stat-label">Skick</div>
                                                    @else
                                                        <div class="item-stat-value">-</div>
                                                        <div class="item-stat-label">Skick</div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    {{-- Fun environmental fact based on category --}}
                                    @php
                                        $facts = [
                                            'Kläder' => 'Visste du att det krävs cirka 2 700 liter vatten för att tillverka en ny bomullst-shirt?',
                                            'Möbler' => 'En begagnad möbel sparar i genomsnitt 80% av CO2-utsläppen jämfört med en ny.',
                                            'Elektronik' => 'Att återanvända elektronik minskar gruvdrift efter sällsynta jordartsmetaller.',
                                            'Böcker' => 'Att dela böcker sparar träd och minskar pappersproduktionens miljöpåverkan.',
                                            'Leksaker' => 'De flesta leksaker är gjorda av plast som tar hundratals år att bryta ner.',
                                            'Sport' => 'Återbrukad sportutrustning fungerar ofta lika bra som ny och sparar mycket resurser.',
                                            'Hushåll' => 'Genom att återbruka hushållsartiklar minskar du både avfall och nyproduktion.',
                                            'default' => 'Varje föremål som återbrukas bidrar till mindre avfall på soptippen.',
                                        ];
                                        $category = $inventory->category ?? 'default';
                                        $fact = $facts[$category] ?? $facts['default'];
                                    @endphp

                                    <div class="item-fact">
                                        <span class="item-fact-icon">&#128161;</span>
                                        <span class="item-fact-text">{{ $fact }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- CTA Section -->
                        <div class="cta-section">
                            <div class="cta-icon">&#127881;</div>
                            <h2 class="cta-title">Du är en miljöhjälte!</h2>
                            <p class="cta-text">
                                Genom ditt val att återbruka istället för att slänga har du aktivt bidragit
                                till en mer hållbar framtid. Fortsätt så!
                            </p>

                            @if($totalValue > 0)
                                <div class="cta-highlight">
                                    <div class="cta-highlight-text">Uppskattat totalt värde:</div>
                                    <div class="cta-highlight-value">{{ number_format($totalValue, 0, ',', ' ') }} kr</div>
                                </div>
                            @endif
                        </div>

                        <!-- Share Section -->
                        <div class="share-section">
                            <p class="share-text">Dela din insats med vänner och familj</p>
                            <span class="share-hashtag">#VäljÅterbruk #HållbarFramtid</span>
                        </div>

                        <!-- AI Sources & Methodology Section -->
                        @if(isset($aiSources))
                        <div style="padding: 30px 40px; background: #f8fafb; border-top: 1px solid #e5e9ee;">
                            <h3 style="font-size: 14px; font-weight: 700; color: #005151; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px;">
                                &#128300; Så har vi räknat - Källor & Metodik
                            </h3>

                            <div style="background: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 15px; border: 1px solid #e5e9ee;">
                                <p style="font-size: 13px; font-weight: 600; color: #1a2634; margin-bottom: 10px;">AI-analys</p>
                                <p style="font-size: 12px; color: #64748b; margin-bottom: 8px;">
                                    <strong>Modell:</strong> {{ implode(', ', $aiSources['models'] ?? ['Anthropic Claude']) }}
                                </p>
                                <p style="font-size: 12px; color: #64748b; margin-bottom: 8px;">
                                    <strong>Leverantör:</strong> {{ implode(', ', $aiSources['providers'] ?? ['Anthropic']) }}
                                </p>
                                <p style="font-size: 12px; color: #64748b;">
                                    <strong>Genomsnittlig konfidens:</strong> {{ $aiSources['avg_confidence'] ?? 0 }}%
                                </p>
                            </div>

                            <div style="background: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 15px; border: 1px solid #e5e9ee;">
                                <p style="font-size: 13px; font-weight: 600; color: #1a2634; margin-bottom: 10px;">Datakällor för miljöberäkningar</p>
                                <ul style="font-size: 11px; color: #64748b; margin: 0; padding-left: 20px; line-height: 1.8;">
                                    @foreach($aiSources['data_sources'] ?? [] as $source)
                                        <li>{{ $source }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div style="background: #ffffff; border-radius: 12px; padding: 20px; border: 1px solid #e5e9ee;">
                                <p style="font-size: 13px; font-weight: 600; color: #1a2634; margin-bottom: 10px;">Miljöekvivalenter - Referenser</p>
                                <ul style="font-size: 11px; color: #64748b; margin: 0; padding-left: 20px; line-height: 1.8;">
                                    @foreach($aiSources['equivalents_sources'] ?? [] as $key => $source)
                                        <li>{{ $source }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <p style="font-size: 10px; color: #9ca3af; margin-top: 15px; text-align: center; font-style: italic;">
                                Alla värden är uppskattningar baserade på AI-analys och vetenskapliga källor.
                                Faktiska miljöbesparingar kan variera beroende på produktens ursprung och tillverkningsmetoder.
                            </p>
                        </div>
                        @endif

                        <!-- Footer -->
                        <div class="footer">
                            <div class="footer-brand">
                                <div class="footer-powered">Powered by</div>
                                <div class="footer-brand-text">{{ $stationName }}</div>
                            </div>

                            <div class="footer-divider"></div>

                            <p class="footer-text">
                                Tack för att du bidrar till en mer hållbar framtid genom återbruk!<br>
                                Tillsammans gör vi verklig skillnad för vår planet.
                            </p>

                            <p class="footer-timestamp">
                                Rapport genererad: {{ now()->format('Y-m-d H:i') }}
                            </p>

                            <p class="footer-copyright">
                                &copy; {{ date('Y') }} PreZero Scanit. Alla rättigheter förbehållna.
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
