<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        EmailTemplate::updateOrCreate(
            ['identifier' => 'welcome_user'],
            [
                'name' => 'Välkomstmail till nya användare',
                'subject' => 'Välkommen till PreZero+ och Scanit!',
                'body' => $this->getWelcomeEmailBody(),
                'variables' => ['name', 'email', 'customer_name', 'role', 'login_url'],
            ]
        );
    }

    private function getWelcomeEmailBody(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Välkommen till PreZero+ och Scanit</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #1a2634;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
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
        }
        .header-title {
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.2;
        }
        .header-subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            font-weight: 500;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 20px;
            color: #1a2634;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .greeting-name {
            color: #005151;
        }
        .text {
            font-size: 15px;
            color: #4a5568;
            margin-bottom: 20px;
            line-height: 1.7;
        }
        .info-box {
            background: linear-gradient(145deg, #f0f9f0 0%, #e8f5e8 100%);
            border-radius: 16px;
            padding: 24px;
            margin: 30px 0;
            border: 2px solid #97d700;
        }
        .info-label {
            font-size: 12px;
            font-weight: 700;
            color: #005151;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        .info-value {
            font-size: 16px;
            color: #1a2634;
            font-weight: 600;
        }
        .info-row {
            margin-bottom: 15px;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #97d700 0%, #7cb300 100%);
            color: #005151;
            padding: 16px 40px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            margin: 20px 0;
        }
        .cta-section {
            text-align: center;
            padding: 30px 0;
        }
        .footer {
            background: #1a2634;
            padding: 40px;
            text-align: center;
        }
        .footer-brand {
            color: #97d700;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .footer-text {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }
        .footer-copyright {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.3);
            margin-top: 20px;
        }
        .role-badge {
            display: inline-block;
            background: #005151;
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1 class="header-title">Välkommen till PreZero+</h1>
                <p class="header-subtitle">Din resa mot hållbarhet börjar här</p>
            </div>

            <div class="content">
                <p class="greeting">Hej <span class="greeting-name">{{name}}</span>!</p>

                <p class="text">
                    Du har blivit tillagd som användare hos <strong>{{customer_name}}</strong> i PreZero+ och Scanit-plattformen.
                    Med Scanit kan du enkelt registrera och spåra miljöpåverkan från återbrukade föremål.
                </p>

                <p class="text">
                    Ditt konto är nu aktivt och du kan logga in direkt. Vi använder säker OTP-inloggning (engångskod via e-post)
                    istället för lösenord.
                </p>

                <div class="info-box">
                    <div class="info-row">
                        <div class="info-label">E-post</div>
                        <div class="info-value">{{email}}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Organisation</div>
                        <div class="info-value">{{customer_name}}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Din roll</div>
                        <div class="info-value"><span class="role-badge">{{role}}</span></div>
                    </div>
                </div>

                <div class="cta-section">
                    <a href="{{login_url}}" class="cta-button">Logga in nu</a>
                </div>

                <p class="text">
                    Om du har frågor eller behöver hjälp, kontakta din administratör eller svara på detta mail.
                </p>

                <p class="text">
                    Välkommen ombord!<br>
                    <strong>PreZero+ Team</strong>
                </p>
            </div>

            <div class="footer">
                <div class="footer-brand">PreZero+ Scanit</div>
                <p class="footer-text">
                    Tillsammans bygger vi en mer hållbar framtid genom återbruk.
                </p>
                <p class="footer-copyright">
                    &copy; 2026 PreZero+ — GoZero Sverige AB. Alla rättigheter förbehållna.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
