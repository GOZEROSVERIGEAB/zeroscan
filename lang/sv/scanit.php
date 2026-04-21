<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ScanIT Swedish Translations
    |--------------------------------------------------------------------------
    */

    'app_name' => 'ZeroScan',

    'auth' => [
        'login_title' => 'Logga in',
        'login_subtitle' => 'Ange din e-postadress for att logga in',
        'email_label' => 'E-postadress',
        'email_placeholder' => 'din@email.se',
        'send_code' => 'Skicka inloggningskod',
        'verify_title' => 'Verifiera din identitet',
        'verify_subtitle' => 'Ange den sexsiffriga koden som skickats till din e-post',
        'otp_label' => 'Verifieringskod',
        'otp_placeholder' => '000000',
        'verify_button' => 'Verifiera',
        'resend_code' => 'Skicka ny kod',
        'code_expires' => 'Koden ar giltig i 10 minuter',
        'code_sent' => 'En inloggningskod har skickats till din e-post',
        'code_resent' => 'En ny inloggningskod har skickats',
        'invalid_code' => 'Ogiltig verifieringskod',
        'code_expired' => 'Koden har gatt ut. Begir en ny kod.',
        'email_not_found' => 'Vi kunde inte hitta ett konto med den e-postadressen',
        'back_to_login' => 'Tillbaka till inloggning',
        'logout' => 'Logga ut',
        'too_many_attempts' => 'For manga forsok. Forsok igen om :seconds sekunder.',
    ],

    'email' => [
        'otp_subject' => 'Din inloggningskod for ZeroScan',
        'otp_greeting' => 'Hej!',
        'otp_body' => 'Har ar din inloggningskod:',
        'otp_expiry' => 'Denna kod ar giltig i 10 minuter.',
        'otp_ignore' => 'Om du inte forsokte logga in kan du ignorera detta meddelande.',
        'report_subject' => 'Din miljorapport fran :station',
        'report_title' => 'Din miljorapport',
        'report_subtitle' => ':count foremal analyserade',
        'co2_saved' => 'CO2 besparat',
        'estimated_value' => 'Uppskattat varde',
        'scanned_items' => 'Skannade foremal',
        'value' => 'Varde',
        'condition' => 'Skick',
        'environmental_impact' => 'Din miljopaverkan',
        'trees_equivalent' => 'trad per ar (upptar lika mycket CO2)',
        'car_km_equivalent' => 'bilkorer besparade',
        'disclaimer_title' => 'Om uppskattningarna',
        'disclaimer_text' => 'Varden och CO2-besparingar ar uppskattningar baserade pa AI-analys. Faktiska varden kan variera beroende pa marknad, skick och andra faktorer. CO2-berakningar baseras pa genomsnittliga livscykeldata for produktkategorier.',
        'footer_text' => 'Tack for att du bidrar till en mer hallbar framtid genom aterbruk!',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'welcome' => 'Valkommen',
    ],

    // Public scanning flow
    'public' => [
        'title' => 'Skanna',
        'welcome_title' => 'Valsortera dina saker',
        'default_info_text' => 'Ta bilder av dina saker och fa en rapport pa hur de kan aterbrukas eller atervinnas.',
        'start_scanning' => 'Starta skanning',
        'capture_title' => 'Ta bilder',
        'capture_description' => 'Fota 1-5 foremal. Ju fler bilder, desto battre analys.',
        'images_taken' => 'Bilder tagna: :count/:max',
        'add_image' => 'Lagg till bild',
        'done_proceed' => 'Klar - Ga vidare',
        'processing' => 'Bearbetar...',
        'email_title' => 'Vill du ha en rapport?',
        'email_description' => 'Ange din e-post sa skickar vi en rapport nar analysen ar klar.',
        'email_label' => 'E-postadress (valfritt)',
        'email_placeholder' => 'din@email.se',
        'gdpr_text' => 'Jag godkanner att min e-post sparas for att skicka rapporten enligt var',
        'privacy_policy_link' => 'integritetspolicy',
        'submit' => 'Skicka in',
        'skip_email' => 'Hoppa over',
        'thankyou_title' => 'Tack!',
        'thankyou_message' => 'Dina bilder bearbetas nu. Det tar vanligtvis nagra minuter.',
        'report_will_be_sent' => 'Rapport skickas till: :email',
        'scan_more' => 'Skanna fler foremal',
        'error_no_images' => 'Du maste ta minst en bild innan du fortsatter.',
        'cancel' => 'Avbryt',
        'camera_access_denied' => 'Kameran kunde inte oppnas. Kontrollera att du har gett tillstand till kameran.',
    ],

    // Validation messages
    'validation' => [
        'gdpr_required' => 'Du maste godkanna integritetspolicyn for att ange e-post.',
        'email_invalid' => 'Ange en giltig e-postadress.',
    ],

    // Status messages
    'status' => [
        'queued' => 'Vantar i ko',
        'processing' => 'Bearbetar',
        'completed' => 'Klar',
        'failed' => 'Misslyckades',
    ],

    // Common
    'unknown_item' => 'Okant foremal',

];
