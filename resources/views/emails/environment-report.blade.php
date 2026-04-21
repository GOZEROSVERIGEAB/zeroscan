<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('scanit.email.report_title') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #22c55e 0%, #84cc16 100%);
            padding: 30px 20px;
            text-align: center;
        }
        .header-logo {
            max-width: 150px;
            max-height: 60px;
            margin-bottom: 15px;
        }
        .header-title {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
        }
        .content {
            padding: 30px 20px;
        }
        .summary-cards {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }
        .summary-card {
            flex: 1;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfccb 100%);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 1px solid #86efac;
        }
        .summary-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .summary-value {
            font-size: 28px;
            font-weight: 700;
            color: #166534;
            margin-bottom: 5px;
        }
        .summary-label {
            font-size: 12px;
            color: #4d7c0f;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #166534;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #86efac;
        }
        .item-list {
            margin-bottom: 30px;
        }
        .item {
            display: flex;
            padding: 15px;
            background-color: #fafafa;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #e5e5e5;
        }
        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            background-color: #e5e5e5;
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }
        .item-category {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }
        .item-stats {
            display: flex;
            gap: 15px;
            font-size: 13px;
        }
        .item-stat {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .item-stat-value {
            font-weight: 600;
            color: #166534;
        }
        .impact-section {
            background: linear-gradient(135deg, #ecfdf5 0%, #fef9c3 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .impact-title {
            font-size: 16px;
            font-weight: 600;
            color: #166534;
            margin-bottom: 15px;
            text-align: center;
        }
        .impact-items {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        .impact-item {
            flex: 1;
        }
        .impact-icon {
            font-size: 36px;
            margin-bottom: 8px;
        }
        .impact-value {
            font-size: 20px;
            font-weight: 700;
            color: #166534;
        }
        .impact-label {
            font-size: 11px;
            color: #4d7c0f;
        }
        .disclaimer {
            background-color: #f5f5f5;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }
        .disclaimer-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        .footer {
            background-color: #1f2937;
            padding: 25px 20px;
            text-align: center;
        }
        .footer-text {
            color: #9ca3af;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .footer-brand {
            color: #84cc16;
            font-weight: 600;
            font-size: 14px;
        }
        .footer-timestamp {
            color: #6b7280;
            font-size: 11px;
        }
        /* Mobile responsive */
        @media only screen and (max-width: 480px) {
            .summary-cards {
                flex-direction: column;
            }
            .impact-items {
                flex-direction: column;
                gap: 20px;
            }
            .item {
                flex-direction: column;
            }
            .item-image {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $stationName }}" class="header-logo">
            @endif
            <h1 class="header-title">{{ __('scanit.email.report_title') }}</h1>
            <p class="header-subtitle">{{ __('scanit.email.report_subtitle', ['count' => $itemCount]) }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Summary Cards -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                <tr>
                    <td width="48%" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfccb 100%); border-radius: 12px; padding: 20px; text-align: center; border: 1px solid #86efac;">
                        <div style="font-size: 32px; margin-bottom: 10px;">&#127793;</div>
                        <div style="font-size: 28px; font-weight: 700; color: #166534; margin-bottom: 5px;">
                            {{ number_format($totalCo2, 1) }} kg
                        </div>
                        <div style="font-size: 12px; color: #4d7c0f; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ __('scanit.email.co2_saved') }}
                        </div>
                    </td>
                    <td width="4%"></td>
                    <td width="48%" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfccb 100%); border-radius: 12px; padding: 20px; text-align: center; border: 1px solid #86efac;">
                        <div style="font-size: 32px; margin-bottom: 10px;">&#128176;</div>
                        <div style="font-size: 28px; font-weight: 700; color: #166534; margin-bottom: 5px;">
                            {{ number_format($totalValue, 0, ',', ' ') }} kr
                        </div>
                        <div style="font-size: 12px; color: #4d7c0f; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ __('scanit.email.estimated_value') }}
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Items Section -->
            <h2 class="section-title">{{ __('scanit.email.scanned_items') }}</h2>
            <div class="item-list">
                @foreach($inventories as $inventory)
                    <div class="item">
                        @if($inventory->image_path)
                            <img src="{{ asset('storage/' . $inventory->image_path) }}"
                                 alt="{{ $inventory->name }}"
                                 class="item-image">
                        @else
                            <div class="item-image" style="display: flex; align-items: center; justify-content: center; color: #999;">
                                &#128247;
                            </div>
                        @endif
                        <div class="item-details">
                            <div class="item-name">{{ $inventory->name ?? __('scanit.unknown_item') }}</div>
                            <div class="item-category">
                                {{ $inventory->category ?? '' }}
                                @if($inventory->brand)
                                    &bull; {{ $inventory->brand }}
                                @endif
                            </div>
                            <div class="item-stats">
                                <div class="item-stat">
                                    <span>CO2:</span>
                                    <span class="item-stat-value">{{ number_format($inventory->co2_savings ?? 0, 1) }} kg</span>
                                </div>
                                <div class="item-stat">
                                    <span>{{ __('scanit.email.value') }}:</span>
                                    <span class="item-stat-value">{{ number_format($inventory->estimated_value ?? 0, 0, ',', ' ') }} kr</span>
                                </div>
                                @if($inventory->condition_rating)
                                    <div class="item-stat">
                                        <span>{{ __('scanit.email.condition') }}:</span>
                                        <span class="item-stat-value">{{ $inventory->condition_rating }}/10</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Environmental Impact -->
            <div class="impact-section">
                <h3 class="impact-title">{{ __('scanit.email.environmental_impact') }}</h3>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50%" style="text-align: center; padding: 10px;">
                            <div style="font-size: 36px; margin-bottom: 8px;">&#127795;</div>
                            <div style="font-size: 20px; font-weight: 700; color: #166534;">
                                {{ number_format($treesEquivalent, 1) }}
                            </div>
                            <div style="font-size: 11px; color: #4d7c0f;">
                                {{ __('scanit.email.trees_equivalent') }}
                            </div>
                        </td>
                        <td width="50%" style="text-align: center; padding: 10px;">
                            <div style="font-size: 36px; margin-bottom: 8px;">&#128663;</div>
                            <div style="font-size: 20px; font-weight: 700; color: #166534;">
                                {{ number_format($carKmEquivalent, 0, ',', ' ') }} km
                            </div>
                            <div style="font-size: 11px; color: #4d7c0f;">
                                {{ __('scanit.email.car_km_equivalent') }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Disclaimer -->
            <div class="disclaimer">
                <div class="disclaimer-title">{{ __('scanit.email.disclaimer_title') }}</div>
                <p>{{ __('scanit.email.disclaimer_text') }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">{{ __('scanit.email.footer_text') }}</p>
            <p class="footer-brand">{{ $stationName }}</p>
            <p class="footer-timestamp">{{ now()->format('Y-m-d H:i') }}</p>
        </div>
    </div>
</body>
</html>
