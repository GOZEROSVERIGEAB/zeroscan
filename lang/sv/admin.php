<?php

return [
    // Navigation
    'nav' => [
        'dashboard' => 'Översikt',
        'customers' => 'Kunder',
        'settings' => 'Inställningar',
        'logout' => 'Logga ut',
    ],

    // Auth
    'auth' => [
        'login_title' => 'Admin-inloggning',
        'login_subtitle' => 'Ange din admin-e-post för att få en inloggningskod',
        'email_label' => 'E-post',
        'email_placeholder' => 'admin@foretag.se',
        'send_code' => 'Skicka inloggningskod',
        'verify_title' => 'Verifiera din identitet',
        'verify_subtitle' => 'Ange den 6-siffriga koden som skickats till',
        'otp_label' => 'Verifieringskod',
        'otp_placeholder' => '000000',
        'code_expires' => 'Koden går ut om 10 minuter',
        'verify_button' => 'Verifiera & Logga in',
        'resend_code' => 'Skicka ny kod',
        'back_to_login' => 'Tillbaka till inloggning',
        'back_to_main' => 'Tillbaka till huvudinloggning',
        'all_rights' => 'Alla rättigheter förbehållna.',
        'not_authorized' => 'Du har inte behörighet att komma åt adminpanelen.',
        'email_not_found' => 'Inget adminkonto hittades med denna e-post.',
        'too_many_attempts' => 'För många försök. Försök igen om :seconds sekunder.',
        'code_sent' => 'En verifieringskod har skickats till din e-post.',
        'code_resent' => 'En ny verifieringskod har skickats.',
        'code_expired' => 'Verifieringskoden har gått ut. Begär en ny.',
        'invalid_code' => 'Ogiltig verifieringskod.',
    ],

    // Dashboard
    'dashboard' => [
        'title' => 'Översikt',
        'subtitle' => 'Översikt av alla kunder och plattformsstatistik',
        'total_customers' => 'Totalt kunder',
        'active' => 'aktiva',
        'on_trial' => 'på prov',
        'total_facilities' => 'Anläggningar',
        'total_stations' => 'Stationer',
        'total_scans' => 'Totalt skanningar',
        'this_month' => 'denna månad',
        'today' => 'idag',
        'recent_customers' => 'Senaste kunderna',
        'view_all' => 'Visa alla',
        'no_recent_customers' => 'Inga kunder registrerade de senaste 7 dagarna.',
        'expiring_trials' => 'Utgående provperioder',
        'upcoming' => 'kommande',
        'no_expiring_trials' => 'Inga provperioder går ut inom 7 dagar.',
        'days_left' => 'dagar kvar',
        'top_customers' => 'Största kunderna',
        'no_customers' => 'Inga kunder hittades.',
    ],

    // Customers
    'customers' => [
        'title' => 'Kunder',
        'subtitle' => 'Hantera alla kundkonton och prenumerationer',
        'create' => 'Ny kund',
        'create_title' => 'Skapa kund',
        'create_subtitle' => 'Lägg till ett nytt kundkonto på plattformen',
        'edit_title' => 'Redigera kund',
        'edit_subtitle' => 'Uppdatera kundinformation och inställningar',
        'search_placeholder' => 'Sök på namn, e-post eller org-nummer...',
        'no_customers' => 'Inga kunder hittades',
        'no_customers_desc' => 'Kom igång genom att skapa din första kund.',
        'create_first' => 'Skapa första kunden',
        'trial_ends' => 'Provperiod slutar om :days dagar',
        'facilities' => 'Anläggningar',
        'stations' => 'Stationer',
        'users' => 'Användare',
        'confirm_activate' => 'Är du säker på att du vill aktivera denna kund?',
        'confirm_suspend' => 'Är du säker på att du vill pausa denna kund?',
        'confirm_reactivate' => 'Är du säker på att du vill återaktivera denna kund?',
        'created_success' => 'Kund skapad.',
        'updated_success' => 'Kund uppdaterad.',
        'activated_success' => 'Kund aktiverad.',
        'suspended_success' => 'Kund pausad.',
        'trial_extended' => 'Provperiod förlängd med :days dagar.',
    ],

    // Status
    'status' => [
        'trial' => 'Provperiod',
        'active' => 'Aktiv',
        'suspended' => 'Pausad',
        'cancelled' => 'Avslutad',
    ],

    // Filters
    'filters' => [
        'all' => 'Alla',
    ],

    // Table
    'table' => [
        'customer' => 'Kund',
        'status' => 'Status',
        'facilities' => 'Anläggningar',
        'stations' => 'Stationer',
        'users' => 'Användare',
        'actions' => 'Åtgärder',
    ],

    // Actions
    'actions' => [
        'view' => 'Visa',
        'edit' => 'Redigera',
        'activate' => 'Aktivera',
        'suspend' => 'Pausa',
        'reactivate' => 'Återaktivera',
        'extend_trial' => 'Förläng prov +14 dagar',
        'view_details' => 'Visa detaljer',
        'save_changes' => 'Spara ändringar',
    ],

    // Wizard
    'wizard' => [
        'step_basic' => 'Grundinfo',
        'step_address' => 'Adress',
        'step_subscription' => 'Prenumeration',
        'step_limits' => 'Gränser',
        'basic_info' => 'Grundinformation',
        'address_info' => 'Adress',
        'subscription_info' => 'Prenumeration',
        'limits_info' => 'Användningsgränser',
        'limits_desc' => 'Lämna tomt för obegränsad användning.',
        'previous' => 'Föregående',
        'next' => 'Nästa',
        'create_customer' => 'Skapa kund',
    ],

    // Fields
    'fields' => [
        'name' => 'Företagsnamn',
        'org_number' => 'Organisationsnummer',
        'email' => 'E-post',
        'phone' => 'Telefon',
        'address' => 'Adress',
        'city' => 'Stad',
        'postal_code' => 'Postnummer',
        'country' => 'Land',
        'subscription_status' => 'Prenumerationsstatus',
        'trial_ends_at' => 'Provperiod slutar',
        'is_enterprise' => 'Enterprise-kund',
        'is_enterprise_desc' => 'Enterprise-kunder har tillgång till avancerade funktioner.',
        'is_active' => 'Aktiv',
        'is_active_desc' => 'Aktiva kunder kan logga in och använda plattformen.',
        'max_facilities' => 'Max anläggningar',
        'max_stations' => 'Max stationer',
        'max_scans_per_month' => 'Max skanningar per månad',
        'created_at' => 'Skapad',
    ],

    // Placeholders
    'placeholders' => [
        'company_name' => 'Företag AB',
        'address' => 'Gatuadress 123',
        'city' => 'Stockholm',
        'unlimited' => 'Obegränsat',
    ],

    // Sections
    'sections' => [
        'company_info' => 'Företagsinformation',
        'address' => 'Adress',
        'subscription_status' => 'Prenumeration',
        'limits' => 'Användningsgränser',
        'limits_desc' => 'Lämna tomt för obegränsad användning.',
        'usage_history' => 'Användningshistorik',
        'details' => 'Detaljer',
        'facilities' => 'Anläggningar',
        'users' => 'Användare',
    ],

    // Tabs
    'tabs' => [
        'basic_info' => 'Grundinfo',
        'subscription' => 'Prenumeration & Gränser',
        'usage' => 'Användningsstatistik',
    ],

    // Usage
    'usage' => [
        'no_data' => 'Ingen användningsdata tillgänglig.',
        'period' => 'Period',
        'scans' => 'Skanningar',
        'limit' => 'Gräns',
        'usage_percent' => 'Användning',
    ],

    // Stats
    'stats' => [
        'facilities' => 'Anläggningar',
        'stations' => 'Stationer',
        'scans_month' => 'Skanningar denna månad',
        'users' => 'Användare',
        'limit' => 'Gräns',
    ],

    // Misc
    'current' => 'Nuvarande',
    'unlimited' => 'Obegränsat',
    'days_left' => 'dagar kvar',
    'expired' => 'Utgången',
    'stations' => 'stationer',

    // Facilities/Users sections
    'facilities' => [
        'none' => 'Inga anläggningar skapade ännu.',
    ],
    'users' => [
        'none' => 'Inga användare skapade ännu.',
    ],

    // Validation
    'validation' => [
        'name_required' => 'Företagsnamn krävs.',
        'email_required' => 'E-post krävs.',
        'email_invalid' => 'Ange en giltig e-postadress.',
    ],
];
